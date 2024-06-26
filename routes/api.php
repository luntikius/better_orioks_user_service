<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('v1/users', [UserController::class, 'registerAUser']);

Route::delete('v1/users',[UserController::class, 'deleteUser']);

Route::get('v1/users', [UserController::class, 'getUsers']);

Route::get('v1/performances', [UserController::class, 'getPerformance']);

