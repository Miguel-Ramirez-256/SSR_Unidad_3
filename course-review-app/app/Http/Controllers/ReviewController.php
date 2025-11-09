<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Requests\StoreReviewRequest;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Course $course) {
    $course->reviews()->create([
        'user_id' => auth()->id(),
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);
    return back()->with('success', 'Reseña enviada.');
}

}
