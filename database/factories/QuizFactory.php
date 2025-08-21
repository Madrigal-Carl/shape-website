<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Quiz::class;

    public function definition(): array
    {
        return [
            'lesson_id' => Lesson::factory(),
            'title' => $this->faker->sentence(3),
            'score' => $this->faker->numberBetween(10,20),
            'description' => $this->faker->optional()->paragraph(),
        ];
    }
}
