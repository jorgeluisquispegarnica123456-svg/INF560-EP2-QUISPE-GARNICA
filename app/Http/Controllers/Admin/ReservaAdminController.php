<?php
// app/Http/Controllers/Admin/ReservaAdminController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaAdminController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['user', 'tour'])->latest()->paginate(15);
        return view('admin.reservas.index', compact('reservas'));
    }

    public function cambiarEstado(Request $request, Reserva $reserva)
    {
        $request->validate(['estado' => 'required|in:pendiente,confirmada,cancelada']);
        $reserva->update(['estado' => $request->estado]);
        return back()->with('success', 'Estado de reserva actualizado.');
    }
}