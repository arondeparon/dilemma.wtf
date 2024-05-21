<?php

namespace App\Actions;

use App\Models\Dilemma;
use App\Support\Traits\Makeable;

class GetTwoRandomDilemmas
{
    use Makeable;

    public function execute()
    {
        // Retrieve all dilemmas ordered by their Elo rank
        $dilemmas = Dilemma::orderBy('rank')->get();

        if ($dilemmas->count() < 2) {
            throw new \Exception('Not enough dilemmas to compare.');
        }

        // Select a random index
        $randomIndex = rand(0, $dilemmas->count() - 1);
        $firstDilemma = $dilemmas[$randomIndex];

        // Define a range for Elo rating
        $eloRange = 50;

        // Filter dilemmas to find ones within the Elo range
        $filteredDilemmas = $dilemmas->filter(function ($dilemma) use ($firstDilemma, $eloRange) {
            return abs($dilemma->rank - $firstDilemma->rank) <= $eloRange && $dilemma->id !== $firstDilemma->id;
        });

        if ($filteredDilemmas->isEmpty()) {
            // If no dilemmas are within the range, pick any different dilemma
            $secondDilemma = $dilemmas->where('id', '!=', $firstDilemma->id)->random();
        } else {
            // Otherwise, pick a random dilemma from the filtered list
            $secondDilemma = $filteredDilemmas->random();
        }

        return [$firstDilemma, $secondDilemma];
    }
}
