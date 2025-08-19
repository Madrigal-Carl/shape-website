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
        return [
            'lesson_id' => Lesson::factory(),
            'category' => json_encode([$this->faker->randomElement(['autism','hearing','speech'])]),
        ];
    }
}
