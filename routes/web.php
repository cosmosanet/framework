<?php

use Framework\Route;

Route::make('/', App\Controllers\UserController::class, 'index');
Route::make('/home', App\Controllers\UserController::class, 'home');
Route::make('/post', App\Controllers\UserController::class, 'post');
Route::start();