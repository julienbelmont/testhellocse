<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/profil', [ProfilController::class, 'index']);
Route::post('/auth', [AuthController::class, 'auth']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/profil', [ProfilController::class, 'store']);
    Route::post('/profil/{profil}', [ProfilController::class, 'update']);
    Route::delete('/profil/{profil}', [ProfilController::class, 'destroy']);
});

Route::any('{any}', function(){
    return response()->json([
        'message'   => 'Page Not Found.',
    ], 404);
})->where('any', '.*');
