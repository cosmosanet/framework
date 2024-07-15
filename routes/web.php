<?php

use Framework\Route;

// Route::post('/post/{id}/sad/{s}', App\Controllers\UserController::class, 'post');
// Route::post('/asd', App\Controllers\UserController::class, 'post');
// Route::get('/asd', App\Controllers\UserController::class, 'post');
Route::get('/addition/{number1}/plus/{number2}/{operator}/', App\Controllers\UserController::class, 'home');
Route::start();