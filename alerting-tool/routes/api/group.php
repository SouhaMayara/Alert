<?php

use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;

Route::get('', [GroupController::class, 'show']);
Route::post('', [GroupController::class, 'store']);
Route::get('/{id}', [GroupController::class, 'index']);
Route::match(['patch', 'put'], '/{id}', [GroupController::class, 'update']);
Route::delete('/{id}', [GroupController::class, 'destroy']);

Route::post('/{id}/contact', [GroupController::class, 'addContacts']);
Route::delete('/{id}/contact', [GroupController::class, 'deleteContacts']);
