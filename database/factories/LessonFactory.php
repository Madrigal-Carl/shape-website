<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Lesson::class;
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'subject_id' => Subject::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
        ];
    }
}
