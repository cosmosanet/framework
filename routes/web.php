<?php

use Framework\Route;

// Route::post('/post/{id}/sad/{s}', App\Controllers\UserController::class, 'post');
// Route::post('/asd', App\Controllers\UserController::class, 'post');
// Route::get('/', App\Controllers\UserController::class, 'home');
Route::get('/addition/{number1}/plus/{number2}/', App\Controllers\UserController::class, 'home');
Route::start();