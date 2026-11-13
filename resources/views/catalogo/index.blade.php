<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TuriPotosí - Catálogo de Tours</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-16 flex justify-between items-center">
            <a href="{{ route('catalogo.index') }}" class="text-2xl font-black tracking-tight text-indigo-600">Turi<span class="text-slate-800">Potosí</span></a>
            <div class="flex items-center space-x-5">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Mi Panel</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-700 transition">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="text-sm font-semibold bg-indigo-600 text-white px-4 py-2 rounded-xl shadow-md hover:bg-indigo-700 transition">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Explora nuestros Tours en Potosí</h1>
            <p class="text-slate-500 text-sm mt-1">Vive la magia de la Villa Imperial con guías locales certificados.</p>
        </div>

        <!-- Filtros Estilizados -->
        <form method="GET" action="{{ route('catalogo.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-10 bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 items-center">
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="🔍 Buscar tour por título..." class="border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            <select name="categoria" class="border border-slate-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none bg-white">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->slug }}" {{ request('categoria') == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 text-white font-medium px-4 py-2.5 rounded-xl text-sm hover:bg-indigo-700 transition shadow-sm">Filtrar</button>
                <a href="{{ route('catalogo.index') }}" class="bg-slate-100 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-slate-200 text-center transition">Limpiar</a>
            </div>
        </form>

        <!-- Grid de Tours -->
        @if($tours->isEmpty())
            <div class="bg-white p-12 rounded-2xl shadow-sm border border-slate-200 text-center text-slate-500">
                <p class="text-lg font-medium">No hay tours disponibles por el momento.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($tours as $tour)
                    @php
                        $img = match($tour->categoria->slug ?? '') {
                            'mineria-e-historia' => 'https://images.unsplash.com/photo-1542224566-6e85f2e6772f?auto=format&fit=crop&w=600&q=80',
                            'aventura-y-naturaleza' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
                            default => 'https://images.unsplash.com/photo-1513584684374-8bab748fbf90?auto=format&fit=crop&w=600&q=80'
                        };
                    @endphp
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden flex flex-col justify-between hover:shadow-xl transition duration-300 group">
                        <div>
                            <!-- Contenedor de Imagen -->
                            <div class="h-48 overflow-hidden relative bg-slate-200">
                                <img src="{{ $tour->imagen ?? $img }}" alt="{{ $tour->titulo }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-indigo-700 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                                    {{ $tour->categoria->nombre }}
                                </span>
                            </div>
                            <div class="p-6">
                                <h2 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition">{{ $tour->titulo }}</h2>
                                <p class="text-sm text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $tour->descripcion }}</p>
                                <div class="mt-4 pt-4 border-t border-slate-100 text-xs text-slate-600 space-y-1.5 font-medium">
                                    <p class="flex items-center gap-1.5">📅 <strong>Salida:</strong> {{ $tour->fecha_salida->format('d/m/Y H:i') }}</p>
                                    <p class="flex items-center gap-1.5">⏱️ <strong>Duración:</strong> {{ $tour->duracion_horas }} horas</p>
                                    <p class="flex items-center gap-1.5">🎟️ <strong>Cupos disponibles:</strong> <span class="text-indigo-600 font-bold">{{ $tour->cupos_disponibles }} / {{ $tour->cupo_maximo }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex justify-between items-center border-t border-slate-100">
                            <div>
                                <span class="text-xs text-slate-400 block uppercase font-bold tracking-wider">Precio</span>
                                <span class="text-lg font-black text-emerald-600">Bs. {{ number_format($tour->precio, 2) }}</span>
                            </div>
                            <a href="{{ route('catalogo.show', $tour) }}" class="bg-indigo-600 text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm hover:bg-indigo-700 transition">Ver y Reservar</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-10">
                {{ $tours->links() }}
            </div>
        @endif
    </main>
</body>
</html>