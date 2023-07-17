<?php

use App\Http\Controllers\AddController;

Route::middleware('auth')->group(function () {
    
    Route::get('/newadd', [AddController::class, 'create'])->name('newadd.create');
    Route::post('/newadd', [AddController::class, 'store']);
    Route::get('/adds', [AddController::class, 'index'])->name('adds');
    Route::get('/myadds', [AddController::class, 'myadds'])->name('myadds');
    Route::get('/editadd/{id}', [AddController::class, 'editAdd'])->name('editadd');
    Route::post('/editadd', [AddController::class, 'updateAdd'])->name('updateadd');
    Route::delete('/deleteadd/{id}', [AddController::class, 'deleteAdd'])->name('deleteadd');
    Route::get('/adds/search', [AddController::class, 'search'])->name('adds.search');
});