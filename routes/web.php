<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('v1/users', [UserController::class, 'registerAUser']);

Route::get('v1/users', function (){
    return view('register');
});
