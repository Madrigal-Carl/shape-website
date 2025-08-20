<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Activity::class;

    public function definition(): array
    {
        $categories = [
            'autism',
            'speech',
            'hearing',
        ];

        return [
            'lesson_id' => Lesson::factory(),
            'name' => $this->faker->words(2, true),
            'category' => $this->faker->randomElements($categories, rand(1, 2)),
        ];
    }
}
