<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('auth')->group(function (){
    Route::get('/categoria', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categoria/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categoria/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categoria/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/categoria/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categoria/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
});