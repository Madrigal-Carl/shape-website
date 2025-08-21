<?php

namespace Database\Factories;

use App\Models\Progress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Progress>
 */
class ProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Progress::class;

    public function definition(): array
    {
        return [
            'best_time_spent' => $this->faker->optional()->numberBetween(60, 5000),
            'status' => $this->faker->randomElement(['incomplete','completed']),
            'item_id' => null,
            'item_type' => null,
        ];
    }
}
