<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::insert([
            'name' => 'Mustafa Genç',
            'email' => 'm@gmail.com',
            'email_verified_at' => now(),
            'type' => 'admin',
            'password' => Hash::make('123'),
            'remember_token' => Str::random(10),
        ]);
        \App\Models\User::factory(5)->create();
    }
}
