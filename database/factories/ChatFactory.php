<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chat_type' => 'private'
        ];
    }
    public function group(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => fake()->name(),
                'description' => fake()->sentence(),
                'chat_type' => 'group'
            ];

        });
    }
    public function private(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'chat_type' => 'private'
            ];
        });
    }
}
