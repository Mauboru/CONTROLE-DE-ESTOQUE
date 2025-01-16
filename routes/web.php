<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\UnidadeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::resource('clientes', ClienteController::class);
Route::get('/clientes/verify-email', [ClienteController::class, 'verifyEmail']);

Route::resource('categorias', CategoriaController::class);
Route::resource('unidades', UnidadeController::class);
Route::resource('produtos', ProdutoController::class);
