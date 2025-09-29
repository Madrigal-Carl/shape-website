<?php

namespace Database\Factories;

use App\Models\Curriculum;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curriculum>
 */
class CurriculumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Curriculum::class;
    public function definition(): array
    {
        return [
            'instructor_id' => null,
            'name' => $this->faker->sentence(3),
            'grade_level_id' => null,
            'description' => $this->faker->paragraph,
            'status' => 'inactive',
        ];
    }
}
