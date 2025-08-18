<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Account;
use App\Models\Student;
use App\Models\Instructor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password123'),
        ];
    }

    // Factory states for specific roles
    public function admin(Admin $admin): static
    {
        return $this->state(fn() => [
            'accountable_id' => $admin->id,
            'accountable_type' => Admin::class,
        ]);
    }

    public function instructor(Instructor $instructor): static
    {
        return $this->state(fn() => [
            'accountable_id' => $instructor->id,
            'accountable_type' => Instructor::class,
        ]);
    }

    public function student(Student $student): static
    {
        return $this->state(fn() => [
            'accountable_id' => $student->id,
            'accountable_type' => Student::class,
        ]);
    }
}
