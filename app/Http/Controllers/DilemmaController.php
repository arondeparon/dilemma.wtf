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
        if ($hash) {
            [$file1, $file2] = explode('||', base64_decode($hash));
            $firstDilemma = $this->getDilemma->execute($file1);
            $secondDilemma = $this->getDilemma->execute($file2);
        } else {
            $dilemmas = $this->getTwoRandomDilemmas->execute();
            [$firstDilemma, $secondDilemma] = $dilemmas;
            $hash = base64_encode("{$firstDilemma->getBasename()}||{$secondDilemma->getBasename()}");
        }

        Queue::push(new GenerateSocialImageJob(
            route('dilemma', ['hash' => $hash]),
            $firstDilemma,
            $secondDilemma
        ));

        return view('dilemma')
            ->with('dilemma1', File::get($firstDilemma))
            ->with('dilemma2', File::get($secondDilemma))
            ->with('hash', $hash);
    }
}
