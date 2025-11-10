<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function create(): View
    {
        return view('courses.create');
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Crear curso asociado al usuario autenticado
        Course::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'video_url' => $validated['video_url'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Curso creado correctamente.');
    }

    public function edit(Course $course): View
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'video_url' => 'nullable|url',
        ]);

        $course->update($validated);

        return redirect()->route('dashboard')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()->route('dashboard')->with('success', 'Curso eliminado correctamente.');
    }
}
