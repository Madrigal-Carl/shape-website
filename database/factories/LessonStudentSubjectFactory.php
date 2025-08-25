<?php

namespace Database\Factories;

use App\Models\LessonSubjectStudent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LessonSubjectStudent>
 */
class LessonStudentSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LessonSubjectStudent::class;
    public function definition(): array
    {
        return [
            'curriculum_subject_id',
            'lesson_id',
            'student_id',
        ];
    }
}
