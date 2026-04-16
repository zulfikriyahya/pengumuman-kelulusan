<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nama_orangtua' => fake()->name(),
            'nisn' => fake()->numerify('##########'), // fix: 10 digit numerik
            'berkas_skl' => null,
            'telepon' => fake()->numerify('08##########'),
            // fix: nilai sesuai enum PHP
            'status' => fake()->randomElement(['Lulus', 'Tidak Lulus', 'Lulus Bersyarat']),
            'barcode_url' => null,
        ];
    }
}
