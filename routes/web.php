<?php

use App\Http\Controllers\ApartmentController;
use Illuminate\Support\Facades\Route;
use Feed;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ApartmentController::class, 'index'])->name('apartments.index');
Route::get('/apartments/{apartment}', [ApartmentController::class, 'show'])->name('apartments.show');

Route::get('/test/rss', function () {
    $rss = Feed::loadRss(config('services.ss.feed'));

    dd($rss->toArray());
});