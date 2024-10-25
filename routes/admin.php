<?php

use App\Http\Controllers\Admin\ArticuloController;
use App\Http\Controllers\Admin\EntradaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PersonaController;
use App\Http\Controllers\Admin\SalidaController;


Route::resource('home', HomeController::class)->only(['index', 'edit', 'update'])->names('admin.home')->middleware('can:admin.home.index');;

Route::resource('articulos', ArticuloController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.articulo')->middleware('can:admin.articulo.index');
Route::get('/admin/articulos/pdf', [ArticuloController::class, 'pdf'])->name('articulo.pdf');

Route::resource('entradas', EntradaController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.entrada')->middleware('can:admin.entrada.index');
Route::get('/admin/entradas/pdf', [EntradaController::class, 'pdf'])->name('entrada.pdf');

Route::resource('personas', PersonaController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.persona')->middleware('can:admin.persona.index');


Route::resource('salidas', SalidaController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.salida')->middleware('can:admin.salida.index');
Route::get('/admin/salidas/pdf', [SalidaController::class, 'pdf'])->name('salida.pdf');

Route::post('personas/import', [PersonaController::class, 'import'])->name('personas.import');




