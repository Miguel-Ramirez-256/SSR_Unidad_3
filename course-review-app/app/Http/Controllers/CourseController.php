<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Mostrar lista de cursos (solo para administrador).
     */
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('courses.index', compact('courses'));
    }

    /**
     * Mostrar formulario para crear curso.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Guardar curso nuevo en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Curso creado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Actualizar curso existente.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    /**
     * Eliminar curso.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Curso eliminado correctamente.');
    }
}
