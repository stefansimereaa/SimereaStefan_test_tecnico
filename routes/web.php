<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// VIEW INDEX TASKS
Route::get('/', [TaskController::class, 'index'])->name('home');

// CRUD TASKS
Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
Route::resource('tasks', App\Http\Controllers\TaskController::class);