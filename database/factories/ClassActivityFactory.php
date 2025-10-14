<?php

namespace Database\Factories;

use App\Models\Instructor;
use App\Models\ClassActivity;
use App\Models\CurriculumSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassActivity>
 */
class ClassActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ClassActivity::class;
    public function definition(): array
    {
        return [
            'school_year_id' => null,
            'curriculum_subject_id' => null,
            'instructor_id'         => null,
            'name'                  => $this->faker->sentence(3), // e.g. "Math Quiz 1"
            'description'           => $this->faker->paragraph(),
        ];
    }
}
