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
            'lesson_id' => null,
            'title' => $this->faker->sentence(3),
            'score' => $this->faker->numberBetween(0, 100),
            'path' => 'images/default-img-holder.png',
            'description' => $this->faker->optional()->paragraph(),
        ];
    }
}
