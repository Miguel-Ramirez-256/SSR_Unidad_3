<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran todas las rutas web del proyecto SSR.
| Incluye las vistas públicas (SSR), el CRUD de cursos, reseñas y autenticación.
|
*/

// Página principal (vista pública SSR)
Route::get('/', [PublicCourseController::class, 'index'])->name('home');

// Detalle de curso (vista pública SSR con Eager Loading)
Route::get('/curso/{course}', [PublicCourseController::class, 'show'])->name('courses.show');

// Reseñas: solo usuarios autenticados pueden crear reseñas
Route::post('/curso/{course}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');

// Dashboard de usuario autenticado (Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas del perfil del usuario (autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas protegidas del CRUD de cursos (solo autenticados)
Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class)->except(['index', 'show']);
});

// Rutas de autenticación Breeze
require __DIR__.'/auth.php';
