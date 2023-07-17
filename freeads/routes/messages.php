<?php

use App\Http\Controllers\MessageController;

Route::middleware('auth')->group(function () {
    
    Route::get('/newmessage/{id}', [MessageController::class, 'create'])->name('newmessage');
    Route::post('/newmessage/send', [MessageController::class, 'store']);

    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::get('/conversation/{receiver_id}', [MessageController::class, 'conversation'])->name('conversation');
});