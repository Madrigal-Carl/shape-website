<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guardian>
 */
class GuardianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Guardian::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->unique()->phoneNumber,
        ];
    }
}
