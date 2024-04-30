<?php

namespace App\Http\Controllers;

use App\Actions\GetTwoRandomDilemmas;
use Illuminate\Http\Request;

class DilemmaController extends Controller
{
    public function __construct(public GetTwoRandomDilemmas $getTwoRandomDilemmas)
    {
    }

    public function __invoke(Request $request)
    {
        $dilemmas = $this->getTwoRandomDilemmas->execute();

        return view('dilemma')
            ->with('dilemma1', $dilemmas[0])
            ->with('dilemma2', $dilemmas[1]);
    }
}
