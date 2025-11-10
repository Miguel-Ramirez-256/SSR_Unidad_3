<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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

    public function edit(Course $course): View
    {
        return view('courses.edit', compact('course'));
    }

    public function update(StoreCourseRequest $request, Course $course): RedirectResponse
    {
        $course->update($request->validated());
        return redirect()->route('dashboard')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();
        return redirect()->route('dashboard')->with('success', 'Curso eliminado correctamente.');
    }
}
