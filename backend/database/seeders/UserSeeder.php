<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@softstats.com',
            'password' => Hash::make('Admin123*'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Anotador',
            'email' => 'anotador@softstats.com',
            'password' => Hash::make('Anotador123*'),
            'role' => 'anotador',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@softstats.com',
            'password' => Hash::make('Juan123*'),
            'role' => 'jugador',
            'email_verified_at' => now(),
        ]);
    }
}
