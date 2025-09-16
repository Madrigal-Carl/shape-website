<?php

namespace Database\Factories;

use App\Models\GameImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GameImage>
 */
class GameImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = GameImage::class;
    public function definition(): array
    {
        return [
            'path' => 'images/game-icons/game-posters/mario-kart-world-review-1.jpg',
            'game_activity_id' => null,
        ];
    }
}
