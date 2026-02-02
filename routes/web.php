<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditorController;


Route::get('/', [EditorController::class, 'index']);
Route::post('/store', [EditorController::class, 'store'])->name('editor.store');

