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
            'name' => $this->faker->unique()->word(),
            'icon' => 'default-icon.png',
        ];
    }

    public function createDefaults()
    {
        $specializations = [
            [
                'name' => 'autism spectrum disorder',
                'icon' => 'autism-icon.png',
            ],
            [
                'name' => 'speech disorder',
                'icon' => 'hearing-icon.png',
            ],
            [
                'name' => 'hearing impaired',
                'icon' => 'speech-icon.png',
            ],
        ];

        foreach ($specializations as $data) {
            Specialization::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
