<?php

use Framework\Facade\Route;
Route::get('/addition/{number1}/plus/{number2}/', App\Controllers\UserController::class, 'home');
Route::get('/', App\Controllers\UserController::class, 'index');
Route::post('/post/{id}/', App\Controllers\UserController::class, 'post');
