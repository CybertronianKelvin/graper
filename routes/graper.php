<?php

use CybertronianKelvin\Graper\Http\Controllers\GraperBlockController;
use CybertronianKelvin\Graper\Http\Controllers\GraperPageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/graper/api/blocks', [GraperBlockController::class, 'index'])->name('graper.blocks');
    Route::get('/graper/api/page/{page}', [GraperPageController::class, 'show'])->name('graper.show');
    Route::put('/graper/api/page/{page}', [GraperPageController::class, 'update'])->name('graper.update');
    Route::get('/graper/edit/{page}', [GraperPageController::class, 'edit'])->name('graper.edit');
});
