<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class PublicCourseController extends Controller
{
    public function index() {
    $courses = Course::latest()->paginate(10);
    return view('home', compact('courses'));
}
public function show(Course $course) {
    $course->load('reviews.user'); // EAGER LOADING crítico
    return view('courses.show', compact('course'));
}

}

