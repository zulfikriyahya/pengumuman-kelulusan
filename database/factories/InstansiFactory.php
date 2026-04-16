<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstansiFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->word(),
            'npsn' => fake()->regexify('[A-Za-z0-9]{8}'),
            'logo' => fake()->word(),
            'logo_institusi' => fake()->word(),
            'nomor_surat' => fake()->word(),
            'nama_pimpinan' => fake()->word(),
            'nip_pimpinan' => fake()->word(),
            'tte_pimpinan' => fake()->word(),
            'nama_ketua' => fake()->word(),
            'nip_ketua' => fake()->word(),
            'tte_ketua' => fake()->word(),
            'jenjang' => fake()->randomElement(["SD","MI","SMP","MTS","SMA","SMK","MA"]),
            'akreditasi' => fake()->randomElement(["A","B","C","D","TT"]),
            'status' => fake()->boolean(),
        ];
    }
}
