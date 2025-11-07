<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

// Rota pública para testar
Route::get('/public', function () {
    return '<h1>Página Pública</h1><p>Esta página pode ser acessada por qualquer pessoa.</p><a href="/dashboard">Ir para Dashboard (protegida)</a><br><a href="/login">Login</a>';
})->name('public');

// Rota protegida para testar
Route::get('/dashboard', function () {
    $user = Auth::user();
    return '<h1>Dashboard Protegida</h1><p>Olá, ' . $user->name . '!</p><p>Esta página só pode ser acessada por usuários logados.</p><a href="/public">Voltar para página pública</a><br><a href="/logout" onclick="event.preventDefault(); document.getElementById(\'logout-form\').submit();">Logout</a><form id="logout-form" action="/logout" method="POST" style="display: none;">'.csrf_field().'</form>';
})->name('dashboard')->middleware('auth');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
