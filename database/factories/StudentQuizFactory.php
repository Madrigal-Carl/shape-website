<?php

namespace Database\Factories;

use App\Models\StudentQuiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentQuiz>
 */
class StudentQuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = StudentQuiz::class;
    public function definition(): array
    {
        return [
            'student_id' => null,
            'quiz_id' => null,
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}
