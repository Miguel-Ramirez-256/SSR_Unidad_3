<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Guardar reseña
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5',
        ]);

        // Evitar reseñas duplicadas por el mismo usuario
        $existing = Review::where('course_id', $course->id)
                          ->where('user_id', Auth::id())
                          ->first();

        if ($existing) {
            return back()->with('error', 'Ya has dejado una reseña para este curso.');
        }

        Review::create([
            'course_id' => $course->id,
            'user_id'   => Auth::id(),
            'rating'    => $request->rating,
            'comment'   => $request->comment,
        ]);

        return redirect()
            ->route('public.courses.show', $course->id)
            ->with('success', 'Reseña añadida correctamente.');
    }

    // Eliminar reseña
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Reseña eliminada correctamente.');
    }
}
