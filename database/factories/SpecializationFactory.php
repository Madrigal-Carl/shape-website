<?php

namespace Database\Factories;

use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialization>
 */
class SpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Specialization::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'autism spectrum disorder',
                'speech disorder',
                'hearing impairment',
            ]),
        ];
    }
}
