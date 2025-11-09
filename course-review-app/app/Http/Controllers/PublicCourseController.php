<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class PublicCourseController extends Controller
{
    // Página principal: lista de cursos
    public function index()
    {
        // Cargar los cursos ordenados por fecha y paginados
        $courses = Course::latest()->paginate(10);

        // Retornar la vista SSR (home.blade.php)
        return view('home', compact('courses'));
    }

    // Página de detalle del curso
    public function show(Course $course)
    {
        // Eager Loading: cargar reseñas y usuarios en una sola consulta
        $course->load('reviews.user');

        // Retornar la vista SSR (courses/show.blade.php)
        return view('courses.show', compact('course'));
    }
}
