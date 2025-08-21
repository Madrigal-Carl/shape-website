<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CurriculumSubject>
 */
class CurriculumSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CurriculumSubject::class;
    public function definition(): array
    {
        return [
            'curriculum_id' => Curriculum::factory(),
            'subject_id' => Subject::factory(),
        ];
    }
}
