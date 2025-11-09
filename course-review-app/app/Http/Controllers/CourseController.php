<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Middleware: solo usuarios autenticados pueden crear/editar cursos
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    // Mostrar lista de cursos (pública o privada)
    public function index()
    {
        $courses = Course::with('user')->latest()->paginate(10);
        return view('courses.index', compact('courses'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('courses.create');
    }

    // Guardar un curso nuevo
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
        ]);

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('courses.index')->with('success', 'Curso creado correctamente.');
    }

    // Mostrar detalle de un curso
    public function show(Course $course)
    {
        $course->load('reviews.user'); // eager loading
        return view('courses.show', compact('course'));
    }

    // Mostrar formulario de edición
    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    // Actualizar curso
    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
        ]);

        $course->update($request->only(['title', 'description']));

        return redirect()->route('courses.index')->with('success', 'Curso actualizado correctamente.');
    }

    // Eliminar curso
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Curso eliminado correctamente.');
    }
}
