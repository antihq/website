<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'user_id' => User::factory(),
            'personal_team' => false,
        ];
    }

    public function personal(): self
    {
        return $this->state(fn (array $attributes) => [
            'personal_team' => true,
        ]);
    }
}
