<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Task Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [TaskController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| CSV Export
|--------------------------------------------------------------------------
*/

Route::get('/tasks/export', [TaskController::class, 'export'])
    ->name('tasks.export');

/*
|--------------------------------------------------------------------------
| Trash
|--------------------------------------------------------------------------
*/

Route::get('/tasks-trash', [TaskController::class, 'trash'])
    ->name('tasks.trash');

Route::post('/tasks-trash/{id}/restore', [TaskController::class, 'restore'])
    ->name('tasks.restore');

Route::delete('/tasks-trash/{id}', [TaskController::class, 'forceDelete'])
    ->name('tasks.force-delete');

Route::delete('/tasks-trash', [TaskController::class, 'emptyTrash'])
    ->name('tasks.empty-trash');

/*
|--------------------------------------------------------------------------
| Bulk Delete
|--------------------------------------------------------------------------
*/

Route::post('/tasks/bulk-delete', [TaskController::class, 'bulkDestroy'])
    ->name('tasks.bulk-destroy');

/*
|--------------------------------------------------------------------------
| Resource Routes
|--------------------------------------------------------------------------
*/

Route::resource('tasks', TaskController::class);
