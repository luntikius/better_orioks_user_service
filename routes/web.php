<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/add_user', [UserController::class, 'registerAUser']);

Route::get('/add_user', function (){
    return view('register');
});
