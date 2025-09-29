<?php

namespace Database\Factories;

use App\Models\GradeLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GradeLevel>
 */
class GradeLevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = GradeLevel::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Kindergarten 1',
                'Kindergarten 2',
                'Kindergarten 3',
                'Grade 1',
                'Grade 2',
                'Grade 3',
                'Grade 4',
                'Grade 5',
                'Grade 6',
            ]),
        ];
    }
}
