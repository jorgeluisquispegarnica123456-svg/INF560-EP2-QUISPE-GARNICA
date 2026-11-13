<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Guía - TuriPotosí</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="bg-white shadow p-4 mb-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <span class="text-xl font-bold text-indigo-700">TuriPotosí | Guía</span>
            <div class="space-x-4">
                <a href="{{ route('catalogo.index') }}" class="text-sm text-gray-700">Catálogo</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Mis Tours Asignados ({{ auth()->user()->name }})</h1>

        @if($tours->isEmpty())
            <div class="bg-white p-6 rounded shadow text-gray-500">No tienes tours asignados todavía.</div>
        @else
            <div class="space-y-6">
                @foreach($tours as $tour)
                    <div class="bg-white p-5 rounded shadow">
                        <div class="flex justify-between items-start border-b pb-3">
                            <div>
                                <span class="text-xs font-bold text-indigo-600 uppercase">{{ $tour->categoria->nombre }}</span>
                                <h2 class="text-xl font-bold">{{ $tour->titulo }}</h2>
                                <p class="text-sm text-gray-600">Salida: {{ $tour->fecha_salida->format('d/m/Y H:i') }} | Cupos ocupados: {{ $tour->cupo_maximo - $tour->cupos_disponibles }} / {{ $tour->cupo_maximo }}</p>
                            </div>
                        </div>
                        <h3 class="font-semibold text-sm mt-3 mb-2">Lista de Turistas Inscritos:</h3>
                        @php $activas = $tour->reservas->where('estado', '!=', 'cancelada'); @endphp
                        @if($activas->isEmpty())
                            <p class="text-xs text-gray-500">Sin turistas registrados aún.</p>
                        @else
                            <ul class="divide-y text-sm">
                                @foreach($activas as $res)
                                    <li class="py-2 flex justify-between">
                                        <span><strong>{{ $res->user->name }}</strong> ({{ $res->user->email }}) — <em>{{ $res->observacion ?? 'Sin obs.' }}</em></span>
                                        <span>{{ $res->cantidad_personas }} pers. | <strong class="uppercase text-xs">{{ $res->estado }}</strong></span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>