<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::post('/tasks/bulk-delete', [TaskController::class, 'bulkDestroy'])
    ->name('tasks.bulk-destroy');

Route::resource('tasks', TaskController::class);

Route::get('/', [TaskController::class, 'index'])
    ->name('home');