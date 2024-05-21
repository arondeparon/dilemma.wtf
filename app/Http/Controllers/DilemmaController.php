<?php

namespace App\Http\Controllers;

use App\Actions\GetTwoRandomDilemmas;
use App\Jobs\GenerateSocialImageJob;
use App\Models\Decision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

class DilemmaController extends Controller
{
    public function __construct(
        private GetTwoRandomDilemmas $getTwoRandomDilemmas,
    ) {
    }

    public function __invoke(Request $request, ?string $hash = null)
    {
        $firstDilemma = null;
        $secondDilemma = null;

        if ($hash) {
            $decision = Decision::where('hash', $hash)
                ->with('firstDilemma', 'secondDilemma')
                ->first();

            $firstDilemma = $decision->firstDilemma;
            $secondDilemma = $decision->secondDilemma;

            if (! $firstDilemma || ! $secondDilemma) {
                // No need to fall back to anything else if somebody decides to use invalid hashes.
                abort(404);
            }
        }

        if (! $firstDilemma || ! $secondDilemma) {
            $dilemmas = $this->getTwoRandomDilemmas->execute();
            [$firstDilemma, $secondDilemma] = $dilemmas;
        }

        $hash = $hash ?? md5($firstDilemma->id.$secondDilemma->id);

        // Try to find a decision that has these two dilemmas
        $decision = Decision::where('hash', $hash)
            ->with('firstDilemma', 'secondDilemma')
            ->first();

        if (! $decision) {
            Decision::create([
                'first_dilemma_id' => $firstDilemma->id,
                'second_dilemma_id' => $secondDilemma->id,
                'hash' => $hash,
            ]);
        }

        Queue::push(new GenerateSocialImageJob(
            hash: $hash,
            firstDilemma: $firstDilemma->title,
            secondDilemma: $secondDilemma->title,
        ));

        return view('dilemma')
            ->with('dilemma1', $firstDilemma->title)
            ->with('dilemma2', $secondDilemma->title)
            ->with('hash', $hash);
    }
}
