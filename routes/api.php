<?php

use App\Http\Controllers\Api\RoleController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('roles', RoleController::class);