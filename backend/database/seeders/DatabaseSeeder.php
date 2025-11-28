<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario admin por defecto
        User::create([
            'name' => 'Arla',
            'email' => 'mario.lara.martin@gmail.com',
            'password' => Hash::make('Mlara806'),
        ]);

        $this->call([
            ContentSeeder::class,
        ]);
    }
}
