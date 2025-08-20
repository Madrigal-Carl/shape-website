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
        $specializations = [
            'autism spectrum disorder',
            'speech disorder',
            'hearing impairment',
        ];

        return [
            'license_number' => $this->faker->unique()->bothify('LIC-####'),
            'path' => null,
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'sex' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->date(),
            'specialization' => $this->faker->randomElements($specializations, rand(1, 2)),
            'status' => 'active',
        ];
    }
}
