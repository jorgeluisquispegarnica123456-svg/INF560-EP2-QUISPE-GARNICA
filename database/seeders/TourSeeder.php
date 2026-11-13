<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Categoria;
use App\Models\Servicio;
use App\Models\User;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        $catMineria = Categoria::where('slug', 'mineria-e-historia')->first();
        $catColonial = Categoria::where('slug', 'arquitectura-colonial')->first();
        $catAventura = Categoria::where('slug', 'aventura-y-naturaleza')->first();
        $guia = User::where('email', 'guia@turipotosi.com')->first();
        $servicios = Servicio::pluck('id');

        $t1 = Tour::firstOrCreate(
            ['slug' => 'expedicion-cerro-rico'],
            [
                'categoria_id' => $catMineria->id,
                'guia_id' => $guia?->id,
                'titulo' => 'Expedición Interior Mina Cerro Rico',
                'descripcion' => 'Recorrido guiado por las galerías históricas del Cerro Rico de Potosí con equipo completo de seguridad.',
                'precio' => 120.00,
                'duracion_horas' => 4,
                'cupo_maximo' => 12,
                'fecha_salida' => now()->addDays(3)->setTime(9, 0),
                'activo' => true,
            ]
        );
        $t1->servicios()->sync($servicios->take(3));

        $t2 = Tour::firstOrCreate(
            ['slug' => 'ruta-casa-moneda-colonial'],
            [
                'categoria_id' => $catColonial->id,
                'guia_id' => $guia?->id,
                'titulo' => 'Ruta Colonial y Casa Nacional de Moneda',
                'descripcion' => 'Visita guiada por el casco viejo de la Villa Imperial, iglesias barrocas y la Casa de la Moneda.',
                'precio' => 85.00,
                'duracion_horas' => 3,
                'cupo_maximo' => 15,
                'fecha_salida' => now()->addDays(5)->setTime(14, 30),
                'activo' => true,
            ]
        );
        $t2->servicios()->sync($servicios->take(2));

        $t3 = Tour::firstOrCreate(
            ['slug' => 'lagunas-del-kari-kari'],
            [
                'categoria_id' => $catAventura->id,
                'guia_id' => $guia?->id,
                'titulo' => 'Trekking Lagunas Coloniales del Kari Kari',
                'descripcion' => 'Caminata de altura por las represas coloniales y miradores naturales de la cordillera.',
                'precio' => 150.00,
                'duracion_horas' => 6,
                'cupo_maximo' => 8,
                'fecha_salida' => now()->addDays(7)->setTime(8, 0),
                'activo' => true,
            ]
        );
        $t3->servicios()->sync($servicios);
    }
}