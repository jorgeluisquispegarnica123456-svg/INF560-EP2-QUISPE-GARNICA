<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        Servicio::firstOrCreate(['nombre' => 'Transporte privado']);
        Servicio::firstOrCreate(['nombre' => 'Guía bilingüe']);
        Servicio::firstOrCreate(['nombre' => 'Equipo de protección (Casco/Linterna)']);
        Servicio::firstOrCreate(['nombre' => 'Almuerzo tradicional']);
    }
}