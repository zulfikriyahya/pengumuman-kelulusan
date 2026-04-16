<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TahunPelajaranFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'jadwal_pengumuman_mulai' => fake()->dateTime(),
            'jadwal_pengumuman_selesai' => fake()->dateTime(),
            'jadwal_kelulusan_mulai' => fake()->dateTime(),
            'jadwal_kelulusan_selesai' => fake()->dateTime(),
            'jadwal_kelulusan_tempat' => fake()->word(),
            'status' => fake()->boolean(),
        ];
    }
}
