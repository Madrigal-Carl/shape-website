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
        $specializations = [
            'autism spectrum disorder',
            'speech disorder',
            'hearing impairment',
        ];

        return [
            'instructor_id' => Instructor::factory(),
            'name' => $this->faker->sentence(3),
            'grade_level' => 'Kindergarten 1',
            'specialization' => $this->faker->randomElements($specializations, rand(1, 2)),
            'description' => $this->faker->paragraph,
            'status' => 'inactive',
        ];
    }
}
