<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GoalController;

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('transactions.index');
    }
    Route::redirect('/','/login');
});

Auth::routes();


Route::middleware('auth')->group(function (){
    Route::get('/categoria', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categoria/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categoria/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categoria/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/categoria/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categoria/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/transacao', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transacao/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transacao/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transacao/show/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transacao/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transacao/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transacao/destroy/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    Route::resource('goals', GoalController::class);
});