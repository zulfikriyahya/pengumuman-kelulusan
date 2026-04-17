<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'avatar' => 'assets/avatar/default.png',
            'username' => 'administrator',
            'status' => 'Aktif',
            'email' => 'adm@mtsn1pandeglang.sch.id',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $this->call([
            InstansiSeeder::class,
            TahunPelajaranSeeder::class,
            SiswaSeeder::class,
            AlumniSeeder::class,
            PersonilSeeder::class,
        ]);
    }
}
