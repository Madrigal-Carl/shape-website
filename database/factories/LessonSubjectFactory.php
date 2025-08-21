<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\CurriculumSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LessonSubject>
 */
class LessonSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'curriculum_subject_id' => CurriculumSubject::factory(),
            'student_id' => Student::factory(),
        ];
    }
}
