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
| Todas las rutas están gestionadas por el RouteServiceProvider
| y asignadas al grupo "web" middleware.
|
*/

// 🏠 Redirigir al login al acceder a la raíz
Route::get('/', function () {
    return Redirect::route('login');
});

// 📋 Dashboard (solo para usuarios autenticados y verificados)
Route::get('/dashboard', function () {
    // Obtener los cursos creados por el usuario autenticado
    $courses = Course::with('user') // Incluye la relación con el usuario (para mostrar nombre)
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('dashboard', compact('courses'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Rutas de perfil (solo usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🎓 CRUD de cursos (solo usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class)->except(['index', 'show']);
});

// 🌍 Rutas públicas (visible para todos los usuarios)
Route::get('/home', [PublicCourseController::class, 'index'])->name('home');
Route::get('/curso/{course}', [PublicCourseController::class, 'show'])->name('courses.show');

// 📝 Reseñas (solo usuarios autenticados)
Route::post('/curso/{course}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('auth');

// 🔐 Rutas de autenticación (Laravel Breeze)
require __DIR__ . '/auth.php';
