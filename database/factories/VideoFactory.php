<?php

namespace Database\Factories;

use App\Models\Video;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Video::class;
    public function definition(): array
    {
        return [
            'lesson_id' => Lesson::factory(),
            'url' => null,
            'title' => $this->faker->words(3, true),
            'thumbnail' => $this->faker->imageUrl(640, 480, 'education'),
        ];
    }
}
