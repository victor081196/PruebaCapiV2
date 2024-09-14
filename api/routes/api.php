<?php

use App\Http\Controllers\ContactosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/contactos', [ContactosController::class, 'index']);
Route::post('/contactos/create', [ContactosController::class, 'create']);
Route::get('/contactos/get/{cts_id}', [ContactosController::class, 'get']);
Route::post('/contactos/delete', [ContactosController::class, 'delete']);
Route::get('/contactos/search', [ContactosController::class, 'search']);

Route::post('/contactos/datos/create', [ContactosController::class, 'datos_create']);


