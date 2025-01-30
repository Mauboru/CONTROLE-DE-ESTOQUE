<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('main');
})->name('login');
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('main');
})->name('main');

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::resource('clientes', ClienteController::class);
    Route::get('/clientes/verify-email', [ClienteController::class, 'verifyEmail']);

    Route::resource('categorias', CategoriaController::class);
    Route::resource('unidades', UnidadeController::class);
    Route::resource('produtos', ProdutoController::class);
    Route::resource('vendas', VendaController::class);

    Route::get('/vendas/{id}/detalhes', [VendaController::class, 'detalhes'])->name('vendas.detalhes');
    Route::get('/relatorios', [VendaController::class, 'relatorios'])->name('relatorios');
});