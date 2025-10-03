<?php

namespace Database\Factories;

use App\Models\StudentActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentActivity>
 */
class StudentActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = StudentActivity::class;
    public function definition(): array
    {
        return [
            'student_id' => null,
            'activity_lesson_id' => null,
            'activity_lesson_type' => null,
            'status' => $this->faker->randomElement(['finished', 'unfinished']),
        ];
    }
}
