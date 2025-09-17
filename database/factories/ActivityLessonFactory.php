<?php

namespace Database\Factories;

use App\Models\ActivityLesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLesson>
 */
class ActivityLessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ActivityLesson::class;
    public function definition(): array
    {
        return [
            'lesson_id' => null,
            'game_activity_id' => null,
        ];
    }
}
