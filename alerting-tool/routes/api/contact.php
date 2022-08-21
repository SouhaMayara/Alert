<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('', [ContactController::class, 'show']);
Route::post('', [ContactController::class, 'store']);
Route::get('/{id}', [ContactController::class, 'index']);
Route::match(['patch','put'],'/{id}', [ContactController::class, 'update']);
Route::delete('/{id}', [ContactController::class, 'destroy']);