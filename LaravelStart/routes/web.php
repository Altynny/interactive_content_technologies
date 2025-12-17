<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ServiceTypeController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('users', UserController::class);

Route::resource('listings', ListingController::class);

Route::post('listings/{id}/restore', [ListingController::class, 'restore'])->name('listings.restore');

Route::resource('service-types', ServiceTypeController::class);