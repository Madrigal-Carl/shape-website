<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Instructor::class;
    public function definition(): array
    {
        return [
            'license_number' => $this->faker->unique()->bothify('LIC-####'),
            'path' => $this->faker->randomElement(['default_profiles/default-male-teacher-pfp.png', 'default_profiles/default-female-teacher-pfp.png']),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'sex' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->date(),
            'status' => 'active',
        ];
    }
}
