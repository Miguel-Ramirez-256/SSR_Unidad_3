<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function create(): View
    {
        return view('courses.create');
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        Course::create($request->validated());
        return redirect()->route('dashboard')->with('success', 'Curso creado correctamente.');
    }

   public function edit(Course $course)
   {
    // Solo el usuario dueño del curso puede editarlo
    $this->authorize('update', $course);

    return view('courses.edit', compact('course'));
}

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ]);

    $course->update($validated);

    return redirect()->route('courses.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
    $this->authorize('delete', $course);

    $course->delete();

    return redirect()->route('courses.index')->with('success', 'Curso eliminado correctamente.');
    }
}
