<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
   
    public function index(Request $request)
    {
        $query = Tour::with(['categoria', 'guia', 'servicios'])->where('activo', true);

        // Filtro por término de búsqueda (título)
        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        // Filtro por categoría
        if ($request->filled('categoria')) {
            $query->whereHas('categoria', function ($q) use ($request) {
                $q->where('slug', $request->categoria);
            });
        }

        $tours = $query->orderBy('fecha_salida', 'asc')->paginate(9)->withQueryString();
        $categorias = Categoria::all();

        return view('catalogo.index', compact('tours', 'categorias'));
    }

    public function show(Tour $tour)
    {
        if (!$tour->activo) {
            abort(404);
        }
        
        $tour->load(['categoria', 'guia', 'servicios']);

        return view('catalogo.show', compact('tour'));
    }
}