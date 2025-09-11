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
        'mathematics',
        'science',
        'self care',
        'filipino sign language',
        'araling panlipunan',
        'filipino',
        'english',
        'sensory',
        'daily living skills',
        'numeracy',
        'language and literacy',
        'edukasyon sa pagpapakatao',
        'practical life skills',
        'music and arts',
        'health and pe'
    ];

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word,
        ];
    }

    public function allSubjects(): void
    {
        $iconMap = [
            'mathematics' => 'mathematics-icon.png',
            'science' => 'science-icon.png',
            'self care' => 'self-care-icon.png',
            'filipino sign language' => 'filipino-sign-language-icon.png',
            'araling panlipunan' => 'araling-panlipunan-icon.png',
            'filipino' => 'filipino-icon.png',
            'english' => 'english-icon.png',
            'sensory' => 'sensory-icon.png',
            'daily living skills' => 'daily-living-skill-icon.png',
            'numeracy' => 'numeracy-icon.png',
            'language and literacy' => 'language-and-literacy-icon.png',
            'edukasyon sa pagpapakatao' => 'edukasyon-sa-pagpapakatao-icon.png',
            'practical life skills' => 'practical-life-skills-icon.png',
            'music and arts' => 'music-and-arts-icon.png',
            'health and pe' => 'health-and-pe-icon.png',
        ];

        foreach ($this->subjects as $subject) {
            $icon = $iconMap[$subject] ?? '';
            Subject::create([
                'name' => $subject,
                'icon' => $icon ? "{$icon}" : '',
            ]);
        }
    }
}
