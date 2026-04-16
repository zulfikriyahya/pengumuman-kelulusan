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
            'name'              => 'Administrator',
            'email'             => 'admin@admin.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
            'remember_token'    => Str::random(10),
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
