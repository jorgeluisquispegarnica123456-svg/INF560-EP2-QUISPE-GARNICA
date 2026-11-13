<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Tour - TuriPotosí</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-3xl mx-auto p-6">
        <a href="{{ route('admin.tours.index') }}" class="text-indigo-600 text-sm hover:underline">&larr; Volver</a>
        <h1 class="text-2xl font-bold mt-2 mb-4">Crear Nuevo Tour</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.tours.store') }}" class="bg-white p-6 rounded shadow space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}" required class="border rounded w-full px-3 py-2 mt-1">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Categoría</label>
                    <select name="categoria_id" required class="border rounded w-full px-3 py-2 mt-1">
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Guía Asignado</label>
                    <select name="guia_id" class="border rounded w-full px-3 py-2 mt-1">
                        <option value="">-- Sin asignar --</option>
                        @foreach($guias as $guia)
                            <option value="{{ $guia->id }}">{{ $guia->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium">Descripción</label>
                <textarea name="descripcion" rows="3" required class="border rounded w-full px-3 py-2 mt-1">{{ old('descripcion') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium">Precio (Bs.)</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" required class="border rounded w-full px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium">Duración (hrs)</label>
                    <input type="number" name="duracion_horas" value="{{ old('duracion_horas', 3) }}" required class="border rounded w-full px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium">Cupo Máximo</label>
                    <input type="number" name="cupo_maximo" value="{{ old('cupo_maximo', 10) }}" required class="border rounded w-full px-3 py-2 mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium">Fecha Salida</label>
                    <input type="datetime-local" name="fecha_salida" value="{{ old('fecha_salida') }}" required class="border rounded w-full px-3 py-2 mt-1">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Servicios Incluidos</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($servicios as $srv)
                        <label class="flex items-center space-x-2 text-sm">
                            <input type="checkbox" name="servicios[]" value="{{ $srv->id }}">
                            <span>{{ $srv->nombre }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="flex items-center space-x-2 text-sm font-medium">
                    <input type="checkbox" name="activo" value="1" checked>
                    <span>Tour Activo (Visible en catálogo)</span>
                </label>
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded font-semibold hover:bg-indigo-700">Guardar Tour</button>
        </form>
    </div>
</body>
</html>