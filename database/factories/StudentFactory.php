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
            'path' => $this->faker->randomElement(['default_profiles/default-male-student-pfp.png', 'default_profiles/default-female-student-pfp.png']),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'sex' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->date(),
            'lrn' => $this->faker->unique()->numerify('############'),
            'disability_type' => $this->faker->randomElement(['autism spectrum disorder', 'speech disorder', 'hearing impaired']),
            'support_need' => $this->faker->sentence(),
        ];
    }
}
