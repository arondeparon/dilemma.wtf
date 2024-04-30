<?php

use App\Http\Controllers\DilemmaController;
use Illuminate\Support\Facades\Route;

Route::get('/', DilemmaController::class);
Route::get('/{hash}', DilemmaController::class)->name('dilemma');
