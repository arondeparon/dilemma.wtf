<?php

use App\Http\Controllers\DilemmaController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

Route::get('/', DilemmaController::class);
Route::get('ranking', RankingController::class)->name('ranking');
Route::get('/{hash}', DilemmaController::class)->name('dilemma');
