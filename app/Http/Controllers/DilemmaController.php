<?php

namespace App\Http\Controllers;

use App\Actions\GetDilemma;
use App\Actions\GetTwoRandomDilemmas;
use App\Jobs\GenerateSocialImageJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;

class DilemmaController extends Controller
{
    public function __construct(
        private GetTwoRandomDilemmas $getTwoRandomDilemmas,
        private GetDilemma $getDilemma,
    )
    {
    }

    public function __invoke(Request $request, ?string $hash = null)
    {
        $firstDilemma = null;
        $secondDilemma = null;

        if ($hash) {
            rescue(
                callback: function () use ($hash, &$firstDilemma, &$secondDilemma) {
                    [$file1, $file2] = explode('||', base64_decode($hash));
                    $firstDilemma = $this->getDilemma->execute($file1);
                    $secondDilemma = $this->getDilemma->execute($file2);
                },
                report: false
            );
        }

        if (! $firstDilemma || ! $secondDilemma) {
            $dilemmas = $this->getTwoRandomDilemmas->execute();
            [$firstDilemma, $secondDilemma] = $dilemmas;
        }

        $hash = base64_encode("{$firstDilemma->getBasename()}||{$secondDilemma->getBasename()}");

        $firstDilemmaText = File::get($firstDilemma);
        $secondDilemmaText = File::get($secondDilemma);

        Queue::push(new GenerateSocialImageJob(
            route('dilemma', ['hash' => $hash]),
            $firstDilemmaText,
            $secondDilemmaText
        ));

        return view('dilemma')
            ->with('dilemma1', $firstDilemmaText)
            ->with('dilemma2', $secondDilemmaText)
            ->with('hash', $hash);
    }
}
