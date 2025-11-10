<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Determina si el usuario puede actualizar el curso.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }

    /**
     * Determina si el usuario puede eliminar el curso.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->user_id;
    }
}
