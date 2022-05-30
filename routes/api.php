<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\ZipController;
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

Route::get('/read',[MapController::class, 'read']);
Route::post('/findCountry',[MapController::class, 'findTwelveNeighboringCountries']);



Route::get('/fill',[MapController::class, 'fill']);

Route::get('/zip-download', [MapController::class, 'downloadZip']);
