<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonilFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'nip' => fake()->word(),
            'foto' => fake()->word(),
            'telepon' => fake()->regexify('[A-Za-z0-9]{15}'),
            'sosial_media' => fake()->word(),
            'jabatan' => fake()->word(),
            'quote' => fake()->text(),
        ];
    }
}
