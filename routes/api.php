<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnnualLeaveController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// route url untuk Resh API
Route::get('/annual-leaves', [AnnualLeaveController::class, 'index']);
Route::get('/annual-leaves/{id}', [AnnualLeaveController::class, 'show']);

Route::post('/annual-leaves',  [AnnualLeaveController::class, 'store']);
