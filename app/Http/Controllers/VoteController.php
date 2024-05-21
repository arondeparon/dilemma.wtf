<?php

namespace App\Http\Controllers;

use App\Models\Decision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VoteController extends Controller
{
    public function __invoke(string $hash, Request $request)
    {
        $request->validate([
            'vote' => 'required|in:first,second',
        ]);

        $decision = Decision::where('hash', $hash)
            ->with('firstDilemma', 'secondDilemma')
            ->firstOrFail();

        $previousVote = Cache::get("{$request->ip()}:{$hash}");

        Cache::put("{$request->ip()}:{$hash}", $request->input('vote'), now()->addHour());

        if ($previousVote && $previousVote !== $request->input('vote')) {
            $decision->decrement("{$previousVote}_dilemma_votes");
        }

        $decision->increment("{$request->vote}_dilemma_votes");

        // Update the Elo ratings
        $this->updateEloRatings($decision, ($request->input('vote')));

        return response()->noContent();
    }

    private function updateEloRatings(Decision $decision, string $vote): void
    {
        $K = 32; // Elo K-factor

        $firstDilemmaRank = $decision->firstDilemma->rank;
        $secondDilemmaRank = $decision->secondDilemma->rank;

        $firstDilemmaExpected = 1 / (1 + 10 ** (($secondDilemmaRank - $firstDilemmaRank) / 400));
        $secondDilemmaExpected = 1 / (1 + 10 ** (($firstDilemmaRank - $secondDilemmaRank) / 400));

        $firstDilemmaActual = $vote === 'first' ? 1 : 0;
        $secondDilemmaActual = $vote === 'second' ? 1 : 0;

        $decision->firstDilemma->rank = $firstDilemmaRank + $K * ($firstDilemmaActual - $firstDilemmaExpected);
        $decision->secondDilemma->rank = $secondDilemmaRank + $K * ($secondDilemmaActual - $secondDilemmaExpected);

        $decision->firstDilemma->save();
        $decision->secondDilemma->save();
    }
}
