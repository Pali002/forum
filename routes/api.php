<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

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

Route::post("/register", [AuthController::class, "signUp"]);
Route::post("/login", [AuthController::class, "signIn"]);
Route::get("/blogs", [BlogController::class, "index"]);
Route::post("/blogs", [BlogController::class, "store"]);
Route::get("/blog/{blog}", [BlogController::class], "show");
Route::put("/blog/{blog}", [BlogController::class], "update");
Route::delete("/blog/{blog}", [BlogController::class], "destroy");