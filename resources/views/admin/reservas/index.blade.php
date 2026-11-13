<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reservas - TuriPotosí</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="bg-gray-900 text-white p-4 mb-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="space-x-6 flex items-center">
                <span class="font-bold text-lg">TuriPotosí Admin</span>
                <a href="{{ route('admin.tours.index') }}" class="text-sm hover:underline">Tours</a>
                <a href="{{ route('admin.reservas.index') }}" class="text-sm underline">Reservas</a>
                <a href="{{ route('catalogo.index') }}" class="text-sm text-gray-300 hover:text-white">Ver Sitio</a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-400 hover:underline">Salir</button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Todas las Reservas</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b text-xs uppercase text-gray-600">
                    <tr>
                        <th class="p-3">Turista</th>
                        <th class="p-3">Tour</th>
                        <th class="p-3">Personas</th>
                        <th class="p-3">Observación</th>
                        <th class="p-3">Estado Actual</th>
                        <th class="p-3">Cambiar Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($reservas as $reserva)
                        <tr>
                            <td class="p-3">{{ $reserva->user->name }}<br><span class="text-xs text-gray-500">{{ $reserva->user->email }}</span></td>
                            <td class="p-3 font-semibold">{{ $reserva->tour->titulo }}</td>
                            <td class="p-3">{{ $reserva->cantidad_personas }}</td>
                            <td class="p-3 text-gray-600">{{ $reserva->observacion ?? '-' }}</td>
                            <td class="p-3 font-bold uppercase text-xs">{{ $reserva->estado }}</td>
                            <td class="p-3">
                                <form method="POST" action="{{ route('admin.reservas.estado', $reserva) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="estado" class="border rounded px-2 py-1 text-xs">
                                        <option value="pendiente" {{ $reserva->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="confirmada" {{ $reserva->estado == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                        <option value="cancelada" {{ $reserva->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                    </select>
                                    <button type="submit" class="bg-indigo-600 text-white px-2 py-1 rounded text-xs">Guardar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $reservas->links() }}</div>
    </main>
</body>
</html>