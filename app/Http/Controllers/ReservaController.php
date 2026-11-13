<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function misReservas()
    {
        $reservas = Reserva::with('tour.categoria')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('turista.reservas', compact('reservas'));
    }

    public function store(Request $request, Tour $tour)
    {
        $request->validate([
            'cantidad_personas' => 'required|integer|min:1',
            'observacion' => 'nullable|string|max:500',
        ]);

        if ($request->cantidad_personas > $tour->cupos_disponibles) {
            return back()->withErrors(['cantidad_personas' => 'No hay suficientes cupos disponibles para este tour.']);
        }

        Reserva::create([
            'user_id' => Auth::id(),
            'tour_id' => $tour->id,
            'cantidad_personas' => $request->cantidad_personas,
            'estado' => 'pendiente',
            'observacion' => $request->observacion,
        ]);

        return redirect()->route('turista.reservas')->with('success', '¡Reserva realizada con éxito!');
    }

    public function cancelar(Reserva $reserva)
    {
        if ($reserva->user_id !== Auth::id() || $reserva->estado === 'cancelada') {
            abort(403);
        }

        $reserva->update(['estado' => 'cancelada']);
        return back()->with('success', 'Reserva cancelada correctamente.');
    }
}