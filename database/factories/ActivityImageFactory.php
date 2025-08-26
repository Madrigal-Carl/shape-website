<?php

namespace Database\Factories;

use App\Models\ActivityImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityImage>
 */
class ActivityImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ActivityImage::class;
    public function definition(): array
    {
        return [
            'path' => 'images/game-icons/game-posters/mario-kart-world-review-1.jpg',
            'activity_id' => null,
        ];
    }
}
