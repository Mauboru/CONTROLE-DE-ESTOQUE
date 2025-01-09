<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;

Route::get('/', function () {
    return view('main');
})->name('main');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::resource('clientes', ClienteController::class);
Route::resource('produtos', ProdutoController::class);