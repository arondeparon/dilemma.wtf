<?php

namespace App\Http\Controllers;

use App\Models\Dilemma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VoteController extends Controller
{
    public function __invoke(string $hash, Request $request)
    {
        $request->validate([
            'vote' => 'required|in:first,second',
        ]);

        $dilemma = Dilemma::where('hash', $hash)->firstOrFail();

        $previousVote = Cache::get("{$request->ip()}:{$hash}");

        Cache::put("{$request->ip()}:{$hash}", $request->input('vote'), now()->addHour());

        if ($previousVote && $previousVote !== $request->input('vote')) {
            $dilemma->decrement("{$previousVote}_dilemma_votes");
        }

        $dilemma->increment("{$request->vote}_dilemma_votes");

        return response()->noContent();
    }
}
