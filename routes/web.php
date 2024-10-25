<?php

use App\Http\Controllers\Admin\ArticuloController;
use App\Http\Controllers\Admin\EntradaController;
use App\Http\Controllers\Admin\PersonaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SalidaController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;






Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/home', function () {
    return view('admin.home.index');
})->middleware(['auth', 'verified'])->name('admin.home.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});


// Route::get('/login2', [AuthController::class, 'showLoginForm'])->name('login2');
// Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('register');
// Route::post('/login2', [LoginController::class, 'login2'])->name('login2');
// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register'])->name('register.custom');





Route::get('reporte/pdf', [SalidaController::class, 'generatePDF'])->name('reporte.pdf');
// Route::get('salida/pdf', [SalidaController::class, 'generatePDF'])->name('salida.pdf');
Route::get('/filter-salidas', [SalidaController::class, 'filterBySalidas'])->name('salidas.filter');

// RUTA PARA HACER EL GRÁFICO CIRCULAR DINÁMICO
Route::get('/api/salidas-mensuales', [SalidaController::class, 'getSalidasMensuales']);




Route::post('/admin/salida/{id}/devoluciones', [SalidaController::class, 'devoluciones'])->name('admin.salida.devoluciones');

// Route::get('/articulos/search', [EntradaController::class, 'searchArticulos'])->name('admin.articulos.search');
Route::get('/articulos/search', [SalidaController::class, 'searchArticulos'])->name('admin.articulos.search');



//RUTAS PARA HACER EL FILTRADO DE ENTRADAS

Route::get('reporteentrada/pdf', [EntradaController::class, 'generatePDF'])->name('reporteentrada.pdf');
Route::get('/filter-entradas', [EntradaController::class, 'filterByEntradas'])->name('entradas.filter');
Route::get('/filter-articulos', [ArticuloController::class, 'filterByArticulos'])->name('articulos.filter');
Route::get('reportearticulo/pdf', [ArticuloController::class, 'generatePDF'])->name('reportearticulo.pdf');

Route::delete('/admin/salida/{id}', [SalidaController::class, 'destroy'])->name('admin.salida.destroy');

Route::post('admin/personas/import', [PersonaController::class, 'import'])->name('admin.persona.import');
Route::post('personas/import', [PersonaController::class, 'import'])->name('personas.import');




require __DIR__.'/auth.php';
