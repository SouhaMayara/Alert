<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlertController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

/** commented just for testing (without token) */
//Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'currentUser']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::name('alert')
        ->prefix('alert')
        ->namespace('alert')
        ->group(__DIR__ . '/api/alert.php');

    Route::name('contact')
        ->prefix('contact')
        ->namespace('contact')
        ->group(__DIR__ . '/api/contact.php');

    Route::name('group')
        ->prefix('group')
        ->namespace('group')
        ->group(__DIR__ . '/api/group.php');
//});

