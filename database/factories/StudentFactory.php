<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Curriculum;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Student::class;
    public function definition(): array
    {
        return [
            'instructor_id' => Instructor::factory(),
            'path' => null,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'sex' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'graduated', 'dropped', 'transferred']),
        ];
    }
}
