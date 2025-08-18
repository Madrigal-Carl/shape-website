<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Subject::class;
    protected $subjects = [
        'mathematics', 'science', 'self care', 'filipino sign language',
        'araling panlipunan', 'filipino', 'english', 'sensory',
        'daily living skills', 'numeracy', 'language and literacy',
        'edukasyon sa pagpapakatao', 'practical life skills', 'music and arts', 'health and pe'
    ];

    public function definition()
    {
        return [
            'name' => 'placeholder',
        ];
    }

    public function allSubjects(): void
    {
        foreach ($this->subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}
