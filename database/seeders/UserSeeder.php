<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@turipotosi.com'],
            ['name' => 'Administrador TuriPotosí', 'password' => Hash::make('password')]
        );
        $admin->assignRole('Admin');

        $guia = User::firstOrCreate(
            ['email' => 'guia@turipotosi.com'],
            ['name' => 'Guía Local', 'password' => Hash::make('password')]
        );
        $guia->assignRole('Guía');

        $turista = User::firstOrCreate(
            ['email' => 'turista@turipotosi.com'],
            ['name' => 'Turista De Prueba', 'password' => Hash::make('password')]
        );
        $turista->assignRole('Turista');
    }
}