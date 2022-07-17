<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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
    return redirect("cms/admin/login");
});
Route::prefix("cms")->middleware("guest:web,admin")->group(function () {
    Route::get("{guard}/login", [AuthController::class, "showLogin"])->name("login");
    Route::post("login", [AuthController::class, "login"])->name("doLogin");
}); 
Route::prefix("cms/admin")->middleware("auth:web,admin")->group(function(){
    Route::resource("cities",CityController::class);
    Route::resource("users", UserController::class);

});

Route::prefix("cms/admin")->middleware("auth:admin")->group(function(){
    Route::resource("roles", RoleController::class);
    Route::resource("permissions", PermissionController::class);
    Route::post("/role/update-permission",[RoleController::class,"updateRolePermission"]);
    Route::resource("admins",AdminController::class);
});

Route::prefix("cms/admin")->middleware("auth:web,admin")->group(function(){
    Route::get("logout",[AuthController::class,"logout"])->name("logout");
});

Route::get("news/title",function(){
    echo "News Content Preview";
})->middleware("age:10");
