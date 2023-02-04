<?php

use App\Http\Controllers\ApartmentController;
use Geocoder\Query\GeocodeQuery;
use Illuminate\Support\Facades\Route;

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

Route::get('/test/geocode', function () {
    $result = app('geocoder')->geocodeQuery(GeocodeQuery::create('13a, Kuldīgas, Rīga, Latvija')->withLocale('lv')->withLimit(1));

    dd($result);
});