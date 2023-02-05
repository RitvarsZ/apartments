<?php

use App\Http\Controllers\ApartmentController;
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

Route::middleware('auth')->group(function () {
    Route::post('/apartments/{apartment}/seen', [ApartmentController::class, 'seen'])->name('apartments.seen');
    Route::post('/apartments/{apartment}/favorite', [ApartmentController::class, 'favorite'])->name('apartments.favorite');
});
