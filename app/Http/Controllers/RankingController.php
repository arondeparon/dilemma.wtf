<?php

namespace App\Http\Controllers;

use App\Models\Dilemma;

class RankingController extends Controller
{
    public function __invoke()
    {
        $dilemmas = Dilemma::orderByDesc('first_dilemma_votes')
            ->orderByDesc('second_dilemma_votes')
            ->get();

        return view('ranking')
            ->with('rankings', $dilemmas);
    }
}
