<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{
    /**
     * Mostrar la lista pública de cursos (SSR)
     */
    public function index()
    {
        $courses = Course::with(['user'])   // Cargar instructor
            ->withAvg('reviews', 'rating')  // Obtener promedio
            ->withCount('reviews')          // Obtener total
            ->latest()
            ->paginate(10);

        return view('home', compact('courses'));
    }

    /**
     * Mostrar el detalle público de un curso (usando SLUG)
     */
    public function show(Course $course)
    {
        // Cargar reseñas con usuario + evitar N+1
        $course->load([
            'reviews.user'
        ]);

        // Cargar promedio y total
        $course->loadAvg('reviews', 'rating');
        $course->loadCount('reviews');

        return view('courses.show', compact('course'));
    }
}
