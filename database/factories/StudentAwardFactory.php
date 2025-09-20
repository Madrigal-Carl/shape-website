<?php

namespace Database\Factories;

use App\Models\StudentAward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentAward>
 */
class StudentAwardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = StudentAward::class;
    public function definition(): array
    {
        return [
            'student_id' => null,
            'award_id' => null,
            'school_year_id' => null,
        ];
    }
}
