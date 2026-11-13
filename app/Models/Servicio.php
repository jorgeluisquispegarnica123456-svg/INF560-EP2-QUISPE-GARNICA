<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function tours()
    {
        return $this->belongsToMany(Tour::class, 'servicio_tour');
    }
}