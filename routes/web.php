<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Todo\ListController;
use App\Http\Controllers\Todo\TaskController;


Auth::routes();

Route::get('/', function () {
    return redirect('/list');
});

Route::get('/list', [ListController::class, 'index'])->name('list.index');
Route::get('/list/{id}', [ListController::class, 'show'])->name('list.show');
Route::post('/list', [ListController::class, 'store'])->name('list.store');
Route::delete('/list/{id}', [ListController::class, 'destroy'])->name('list.destroy');

Route::post('/task/{list}', [TaskController::class, 'store'])->name('task.store');

