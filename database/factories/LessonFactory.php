<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\LessonSubject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Lesson::class;
    public function definition(): array
    {
        return [
            'school_year_id' => null,
            'title' => $this->faker->unique()->sentence(2),
            'description' => $this->faker->paragraph,
        ];
    }
}
