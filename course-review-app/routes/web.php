<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\ReviewController;
use App\Models\Course;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas web de la aplicación. 
| Todas se cargan por el RouteServiceProvider y estarán 
| asignadas al grupo "web" middleware.
|
*/

// 🔒 Redirigir al login al entrar a la raíz
Route::get('/', function () {
    return Redirect::route('login');
});

// 📋 Dashboard (solo para usuarios autenticados)
Route::get('/dashboard', function () {
    $courses = Course::latest()->get();
    return view('dashboard', compact('courses'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Perfil del usuario autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🎓 CRUD de cursos (solo usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class)->except(['index', 'show']);
});

// 🌍 Rutas públicas SSR (para la fase 5)
Route::get('/home', [PublicCourseController::class, 'index'])->name('home');
Route::get('/curso/{course}', [PublicCourseController::class, 'show'])->name('courses.show');

// 📝 Reseñas (solo usuarios autenticados)
Route::post('/curso/{course}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('auth');

// 🔐 Rutas de autenticación Breeze
require __DIR__ . '/auth.php';
