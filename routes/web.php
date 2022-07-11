<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('cms.temp');
});
Route::prefix("cms/admin")->group(function(){
    Route::resource("/cities", CityController::class);
    Route::resource("/users", UserController::class);

});
