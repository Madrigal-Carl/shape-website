<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Profile::class;

    public function definition(): array
    {
        $grades = ['kindergarten 1', 'kindergarten 2', 'kindergarten 3'];
        $disabilities = ['autism spectrum disorder', 'speech disorder', 'hearing impairment'];

        return [
            'student_id' => Student::factory(),
            'lrn' => $this->faker->unique()->numerify('LRN######'),
            'grade_level' => $this->faker->randomElement($grades),
            'disability_type' => $this->faker->randomElement($disabilities),
            'support_need' => $this->faker->sentence(),
        ];
    }
}
