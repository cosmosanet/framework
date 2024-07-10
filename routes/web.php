<?php
    use Framework\Route;
    
    Route::make('/', App\Controllers\UserController::class, 'index');
    Route::make('/home', App\Controllers\UserController::class, 'home');
    Route::start();