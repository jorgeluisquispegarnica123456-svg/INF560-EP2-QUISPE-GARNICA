<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas - TuriPotosí</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="bg-white shadow p-4 mb-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('catalogo.index') }}" class="text-xl font-bold text-indigo-700">TuriPotosí</a>
            <div class="space-x-4">
                <a href="{{ route('catalogo.index') }}" class="text-sm text-gray-700 hover:text-indigo-600">Catálogo</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Mis Reservas ({{ auth()->user()->name }})</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        @if($reservas->isEmpty())
            <div class="bg-white p-6 rounded shadow text-center">
                <p class="text-gray-500 mb-3">Aún no tienes reservas registradas.</p>
                <a href="{{ route('catalogo.index') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm">Explorar Tours</a>
            </div>
        @else
            <div class="bg-white rounded shadow overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b text-xs uppercase text-gray-600">
                        <tr>
                            <th class="p-3">Tour</th>
                            <th class="p-3">Salida</th>
                            <th class="p-3">Personas</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Estado</th>
                            <th class="p-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-sm">
                        @foreach($reservas as $reserva)
                            <tr>
                                <td class="p-3 font-semibold">{{ $reserva->tour->titulo }}</td>
                                <td class="p-3">{{ $reserva->tour->fecha_salida->format('d/m/Y H:i') }}</td>
                                <td class="p-3">{{ $reserva->cantidad_personas }}</td>
                                <td class="p-3">Bs. {{ number_format($reserva->tour->precio * $reserva->cantidad_personas, 2) }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        {{ $reserva->estado === 'confirmada' ? 'bg-green-100 text-green-800' : ($reserva->estado === 'cancelada' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($reserva->estado) }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    @if($reserva->estado !== 'cancelada')
                                        <form method="POST" action="{{ route('reservas.cancelar', $reserva) }}" onsubmit="return confirm('¿Seguro que deseas cancelar esta reserva?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Cancelar</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
</body>
</html>