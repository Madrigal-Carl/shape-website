<?php

namespace Database\Factories;

use App\Models\GameActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameActivity>
 */
class GameActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = GameActivity::class;

    public function definition(): array
    {
        return [
            'todo_id' => null,
            'name' => $this->faker->words(2, true),
            'path' => 'images/game-icons/mario.jpeg',
            'description' => $this->faker->paragraph(),
        ];
    }
}
