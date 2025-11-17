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
        $courses = Course::with('user')
            ->latest()
            ->paginate(10);

        return view('home', compact('courses'));
    }

    /**
     * Mostrar el detalle público de un curso (usando SLUG)
     */
    public function show(Course $course)
    {
        // Cargar las reseñas con su usuario
        $course->load(['reviews.user' => function($q) {
            $q->latest();
        }]);

        return view('courses.show', compact('course'));
    }
}
