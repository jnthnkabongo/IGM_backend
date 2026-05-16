<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur de test
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mines.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Créer quelques utilisateurs supplémentaires pour la démo
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@mines.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Marie Curie',
            'email' => 'marie@mines.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
