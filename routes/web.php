<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditorController;

Route::get('/', [EditorController::class, 'index'])->name('editor.index');

Route::get('/create', [EditorController::class, 'create'])->name('editor.create');
Route::post('/store', [EditorController::class, 'store'])->name('editor.store');
Route::post('/autosave', [EditorController::class, 'autoSave'])->name('editor.autosave');

Route::get('/edit/{id}', [EditorController::class, 'edit'])->name('editor.edit');
Route::put('/update/{id}', [EditorController::class, 'update'])->name('editor.update');
Route::get('/trash', [EditorController::class, 'trash'])->name('editor.trash');

Route::get('/restore/{id}', [EditorController::class, 'restore'])->name('editor.restore');
Route::delete('/delete/{id}', [EditorController::class, 'destroy'])->name('editor.delete');
Route::get('/force-delete/{id}', [EditorController::class, 'forceDelete'])->name('editor.forceDelete');