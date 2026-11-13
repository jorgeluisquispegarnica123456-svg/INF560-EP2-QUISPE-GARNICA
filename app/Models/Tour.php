<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id', 'guia_id', 'titulo', 'slug', 'descripcion',
        'precio', 'duracion_horas', 'cupo_maximo', 'fecha_salida', 'imagen', 'activo'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'fecha_salida' => 'datetime',
        'activo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function guia()
    {
        return $this->belongsTo(User::class, 'guia_id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_tour');
    }

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function getCuposDisponiblesAttribute()
    {
        $ocupados = $this->reservas()
            ->whereIn('estado', ['pendiente', 'confirmada'])
            ->sum('cantidad_personas');

        return $this->cupo_maximo - $ocupados;
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true)
                     ->where('fecha_salida', '>', now());
    }
}
