<?php

namespace App\Http\Controllers;

use App\Models\Dilemma;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __invoke(string $hash, Request $request)
    {
        $request->validate([
            'vote' => 'required|in:first,second',
        ]);

        $dilemma = Dilemma::where('hash', $hash)->firstOrFail();

        $dilemma->increment("{$request->vote}_dilemma_votes");

        return response()->noContent();
    }
}
