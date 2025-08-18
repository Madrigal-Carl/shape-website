<?php

namespace Database\Factories;

use App\Models\Feed;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feed>
 */
class FeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Feed::class;
    public function definition(): array
    {
        $student = $this->faker->boolean(70) ? Student::factory() : null;

        return [
            'notifiable_id' => $student,
            'group' => $student ? 'students' : $this->faker->randomElement(['general', 'teachers']),
            'title' => $this->faker->sentence(4),
            'message' => $this->faker->paragraph,
        ];
    }
}
