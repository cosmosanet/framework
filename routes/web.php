<?php

use Framework\Route;

Route::post('/post', App\Controllers\UserController::class, 'post');
Route::get('/', App\Controllers\UserController::class, 'home');
Route::start();