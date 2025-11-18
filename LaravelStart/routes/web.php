<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmissionController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/form', function () {
    return view('form');
})->name('form.show');
Route::post('/submit', [SubmissionController::class, 'submit'])->name('form.submit');

Route::get('/submissions', [SubmissionController::class, 'listSubmissions'])->name('submissions.list');
