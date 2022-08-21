<?php

use App\Http\Controllers\AlertController;
use Illuminate\Support\Facades\Route;

Route::get('', [AlertController::class, 'show']);
Route::post('', [AlertController::class, 'store']);
Route::post('/{id}/aknowledge', [AlertController::class, 'aknowledgeAlert']);
Route::post('/aknowledge', [AlertController::class, 'aknowledgeAll']);
Route::post('/snooze', [AlertController::class, 'snooze']);