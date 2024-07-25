<?php

use Framework\Facade\Route;

Route::get('/', App\Controllers\UserController::class)->name('index');
Route::get('/addition/{number1}/plus/{number2}/', App\Controllers\UserController::class)->middleware(App\Middleware\Auth::class)->name('home');
Route::get('/auth', App\Controllers\UserController::class)->name('auth');
Route::get('/dropSession', App\Controllers\UserController::class)->name('dropSession');
Route::post('/post/{id}/', App\Controllers\UserController::class)->name('post');
Route::isExit();