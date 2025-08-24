<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\LessonQuiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LessonQuiz>
 */
class LessonQuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LessonQuiz::class;
    public function definition(): array
    {
        return [
            'quiz_id' => null,
            'lesson_id'   => null,
            'score' => $this->faker->numberBetween(10, 20),
        ];
    }
}
