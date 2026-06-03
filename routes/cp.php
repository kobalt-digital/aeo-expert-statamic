<?php

use Illuminate\Support\Facades\Route;
use KobaltDigital\AeoExpert\Http\Controllers\CpController;

Route::prefix('aeo-expert')->name('aeo-expert.')->group(function () {
    Route::get('/', [CpController::class, 'index'])->name('index');
    Route::post('/', [CpController::class, 'update'])->name('update');
    Route::post('/fetch-score', [CpController::class, 'fetchScore'])->name('fetch-score');
    Route::post('/generate-llms', [CpController::class, 'generateLlms'])->name('generate-llms');
});
