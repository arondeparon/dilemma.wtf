<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dilemma>
 */
class DilemmaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hash' => $this->faker->unique()->sha1,
            'first_dilemma' => $this->faker->sentence,
            'second_dilemma' => $this->faker->sentence,
        ];
    }
}
