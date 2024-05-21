<?php

use App\Http\Controllers\RankingController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::post('dilemma/{hash}/vote', VoteController::class);
