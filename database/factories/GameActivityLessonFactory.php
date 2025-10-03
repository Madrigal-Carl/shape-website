<?php

namespace Database\Factories;

use App\Models\GameActivityLesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameActivityLesson>
 */
class GameActivityLessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = GameActivityLesson::class;
    public function definition(): array
    {
        return [
            'lesson_id' => null,
            'game_activity_id' => null,
        ];
    }
}
