<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Snapshot>
 */
class SnapshotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakeId = fake()->numberBetween(1, 11);
        return [
            'title' => fake()->name(),
            'path' => 'images/' . $fakeId . '/' . Str::random(10) . '.jpg',
            'user_id' => $fakeId,
        ];
    }
}
