<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Categoria;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with(['categoria', 'guia'])->latest()->paginate(10);
        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $servicios = Servicio::all();
        $guias = User::role('Guía')->get();
        return view('admin.tours.create', compact('categorias', 'servicios', 'guias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'guia_id' => 'nullable|exists:users,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'duracion_horas' => 'required|integer|min:1',
            'cupo_maximo' => 'required|integer|min:1',
            'fecha_salida' => 'required|date|after:now',
            'servicios' => 'nullable|array',
            'activo' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['titulo']) . '-' . uniqid();
        $data['activo'] = $request->has('activo');

        $tour = Tour::create($data);
        if ($request->has('servicios')) {
            $tour->servicios()->sync($request->servicios);
        }

        return redirect()->route('admin.tours.index')->with('success', 'Tour creado exitosamente.');
    }

    public function edit(Tour $tour)
    {
        $categorias = Categoria::all();
        $servicios = Servicio::all();
        $guias = User::role('Guía')->get();
        return view('admin.tours.edit', compact('tour', 'categorias', 'servicios', 'guias'));
    }

    public function update(Request $request, Tour $tour)
    {
        $data = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'guia_id' => 'nullable|exists:users,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'duracion_horas' => 'required|integer|min:1',
            'cupo_maximo' => 'required|integer|min:1',
            'fecha_salida' => 'required|date',
            'servicios' => 'nullable|array',
        ]);

        $data['activo'] = $request->has('activo');
        $tour->update($data);
        $tour->servicios()->sync($request->servicios ?? []);

        return redirect()->route('admin.tours.index')->with('success', 'Tour actualizado.');
    }

    public function destroy(Tour $tour)
    {
        $tour->delete();
        return back()->with('success', 'Tour eliminado.');
    }
}