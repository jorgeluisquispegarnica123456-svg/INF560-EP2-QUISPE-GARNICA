<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tours - TuriPotosí</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <nav class="bg-gray-900 text-white p-4 mb-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="space-x-6 flex items-center">
                <span class="font-bold text-lg">TuriPotosí Admin</span>
                <a href="{{ route('admin.tours.index') }}" class="text-sm underline">Tours</a>
                <a href="{{ route('admin.reservas.index') }}" class="text-sm hover:underline">Reservas</a>
                <a href="{{ route('catalogo.index') }}" class="text-sm text-gray-300 hover:text-white">Ver Sitio</a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-400 hover:underline">Salir</button>
            </form>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Gestión de Tours</h1>
            <a href="{{ route('admin.tours.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm font-semibold hover:bg-indigo-700">+ Nuevo Tour</a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b text-xs uppercase text-gray-600">
                    <tr>
                        <th class="p-3">Título</th>
                        <th class="p-3">Categoría</th>
                        <th class="p-3">Guía</th>
                        <th class="p-3">Precio</th>
                        <th class="p-3">Cupos</th>
                        <th class="p-3">Salida</th>
                        <th class="p-3">Estado</th>
                        <th class="p-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($tours as $tour)
                        <tr>
                            <td class="p-3 font-semibold">{{ $tour->titulo }}</td>
                            <td class="p-3">{{ $tour->categoria->nombre }}</td>
                            <td class="p-3">{{ $tour->guia->name ?? 'Sin asignar' }}</td>
                            <td class="p-3">Bs. {{ number_format($tour->precio, 2) }}</td>
                            <td class="p-3">{{ $tour->cupos_disponibles }} / {{ $tour->cupo_maximo }}</td>
                            <td class="p-3">{{ $tour->fecha_salida->format('d/m/Y H:i') }}</td>
                            <td class="p-3">{{ $tour->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('admin.tours.edit', $tour) }}" class="text-indigo-600 hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.tours.destroy', $tour) }}" onsubmit="return confirm('¿Eliminar tour?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $tours->links() }}</div>
    </main>
</body>
</html>