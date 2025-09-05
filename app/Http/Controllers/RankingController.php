<?php

namespace App\Http\Controllers;

use App\Models\Decision;

class RankingController extends Controller
{
    public function __invoke()
    {
        $dilemmas = Decision::with('firstDilemma', 'secondDilemma')
            ->where(function ($q) {
                $q->where('first_dilemma_votes', '>', 0)
                  ->orWhere('second_dilemma_votes', '>', 0);
            })
            ->orderByDesc('first_dilemma_votes')
            ->orderByDesc('second_dilemma_votes')
            ->get();

        return view('ranking')
            ->with('rankings', $dilemmas);
    }
}
