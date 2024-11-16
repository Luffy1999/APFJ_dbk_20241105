<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/nuevousuario', [AuthController::class,"registar"]);
Route::get("/login", [AuthController::class,"login"]);
Route::get("/usuario", [AuthController::class,"me"])->middleware('auth:sanctum');