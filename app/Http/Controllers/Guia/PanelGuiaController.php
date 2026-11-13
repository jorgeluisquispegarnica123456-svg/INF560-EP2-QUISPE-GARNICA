<?php
// app/Http/Controllers/Guia/PanelGuiaController.php
namespace App\Http\Controllers\Guia;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Support\Facades\Auth;

class PanelGuiaController extends Controller
{
    public function index()
    {
        $tours = Tour::with(['categoria', 'reservas.user'])
            ->where('guia_id', Auth::id())
            ->orderBy('fecha_salida', 'asc')
            ->get();

        return view('guia.panel', compact('tours'));
    }
}