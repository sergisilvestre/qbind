<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/',                     [HomeController::class, 'index'])->name('home');
Route::post('/',                    [HomeController::class, 'upload'])->name('upload');
Route::post('validateVatNumer',     [HomeController::class, 'validateVatNumer'])->name('validateVatNumer');
