<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Enrollment::class;

    public function definition(): array
    {
        return [
            'school_year_id' => null,
            'student_id' => Student::factory(),
            'grade_level' => $this->faker->randomElement(['kindergarten 1', 'kindergarten 2', 'kindergarten 3']),
        ];
    }
}
