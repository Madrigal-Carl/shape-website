<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Student;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Address::class;
    public function definition(): array
    {
        return [
            'province' => $this->faker->state,
            'municipality' => $this->faker->city,
            'barangay' => $this->faker->streetName,
            'type' => $this->faker->randomElement(['current', 'permanent']),
            'owner_id' => Student::factory(),
            'owner_type' => Student::class,
        ];
    }
    public function instructor()
    {
        return $this->state(function (array $attributes) {
            return [
                'owner_id' => Instructor::factory(),
                'owner_type' => Instructor::class,
            ];
        });
    }
    public function student()
    {
        return $this->state(function (array $attributes) {
            return [
                'owner_id' => Student::factory(),
                'owner_type' => Student::class,
            ];
        });
    }
}
