<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'nisn' => fake()->regexify('[A-Za-z0-9]{10}'),
            'tahun_lulus' => fake()->regexify('[A-Za-z0-9]{4}'),
            'avatar' => fake()->word(),
            'quote' => fake()->text(),
        ];
    }
}
