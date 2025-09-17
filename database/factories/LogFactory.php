<?php

namespace Database\Factories;

use App\Models\Log;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Log::class;

    public function definition(): array
    {
        return [
            'student_activity_id' => null,
            'attempt_number' => $this->faker->numberBetween(1, 5),
            'time_spent_seconds' => $this->faker->numberBetween(60, 120),
            'score' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['in-progress', 'completed']),
        ];
    }
}
