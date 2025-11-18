<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\ReviewController;
use App\Models\Course; 

/*
|--------------------------------------------------------------------------
| 📌 RUTA PRINCIPAL — SIEMPRE AL LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| 📌 RUTAS PÚBLICAS DE CURSOS (Invitados pueden ver)
|--------------------------------------------------------------------------
*/

Route::get('/cursos', [PublicCourseController::class, 'index'])
    ->name('public.courses');

Route::get('/cursos/{course}', [PublicCourseController::class, 'show'])
    ->name('public.courses.show');

/*
|--------------------------------------------------------------------------
| 🔐 RUTAS PRIVADAS — Requieren AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard — mostrar TODOS los cursos
    Route::get('/dashboard', function () {
    // traer todos los cursos con su autor para mostrar quién creó cada uno
        $courses = \App\Models\Course::with('user')->latest()->get();

        return view('dashboard', compact('courses'));
    })->middleware(['auth', 'verified'])->name('dashboard');


    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de cursos autenticados (usa ID)
    Route::resource('courses', CourseController::class)->except(['index', 'show']);

    /*
    |--------------------------------------------------------------------------
    | ⭐ RUTAS DE RESEÑAS (AUTENTICADOS)
    |--------------------------------------------------------------------------
    | IMPORTANTE: Las reseñas usan ID, NO slug
    */

    // Guardar reseña
    Route::post('/courses/{course}/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');

    // Eliminar reseña
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
    ->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| 🔐 Rutas de Breeze (login, register, logout)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
