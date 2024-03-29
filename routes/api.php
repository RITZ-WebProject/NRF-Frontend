<?php

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/dinger-callback', [OrderController::class, 'dingerCallback'])->name('dinger.callback')->middleware('api');
Route::get('/success', [OrderController::class, 'success'])->name('success');
Route::get('/error', [OrderController::class, 'error'])->name('error');