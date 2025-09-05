<?php

namespace App\Http\Controllers;

use App\Models\Decision;

class RankingController extends Controller
{
    public function __invoke()
    {
        $dilemmas = Decision::with('firstDilemma', 'secondDilemma')
            ->orderByDesc('first_dilemma_votes')
            ->orderByDesc('second_dilemma_votes')
            ->get();

        return view('ranking')
            ->with('rankings', $dilemmas);
    }
}
