<?php

use App\Http\Controllers\Api\TopMoviesController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('topmovies')->name('api.topmovies.')->group(function () {
    Route::get('', [TopMoviesController::class,'index'])->name('api.topmovies.index');
    Route::get('test', [TopMoviesController::class,'test'])->name('api.topmovies.test');
    Route::get('update', [TopMoviesController::class,'update'])->name('api.topmovies.update');
    Route::get('get', [TopMoviesController::class,'get'])->name('api.topmovies.get');
});
