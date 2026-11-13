<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        Categoria::firstOrCreate(
            ['slug' => 'mineria-e-historia'],
            ['nombre' => 'Minería e Historia', 'descripcion' => 'Recorridos históricos por el Cerro Rico y la Casa de la Moneda.']
        );

        Categoria::firstOrCreate(
            ['slug' => 'arquitectura-colonial'],
            ['nombre' => 'Arquitectura Colonial', 'descripcion' => 'Visitas guiadas por templos y calles coloniales de la Villa Imperial.']
        );

        Categoria::firstOrCreate(
            ['slug' => 'aventura-y-naturaleza'],
            ['nombre' => 'Aventura y Naturaleza', 'descripcion' => 'Excursiones hacia lagunas altoandinas y paisajes de altura.']
        );
    }
}
