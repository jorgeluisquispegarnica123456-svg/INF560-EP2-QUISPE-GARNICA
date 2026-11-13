<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tour->titulo }} - TuriPotosí</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
    <div class="max-w-4xl mx-auto px-6 py-10">
        <a href="{{ route('catalogo.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm inline-flex items-center gap-1 mb-6">&larr; Volver al catálogo</a>

        @php
            $img = match($tour->categoria->slug ?? '') {
                'mineria-e-historia' => 'https://images.unsplash.com/photo-1578593139857-4172f3e808fc?auto=format&fit=crop&w=1000&q=80',
                'aventura-y-naturaleza' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1000&q=80',
                default => 'https://images.unsplash.com/photo-1513584684374-8bab748fbf90?auto=format&fit=crop&w=1000&q=80'
            };
        @endphp

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Imagen Grande de Presentación -->
            <div class="h-72 w-full relative">
                <img src="{{ $tour->imagen ?? $img }}" alt="{{ $tour->titulo }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <span class="bg-indigo-600 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">
                        {{ $tour->categoria->nombre }}
                    </span>
                    <h1 class="text-3xl font-black mt-2 leading-tight">{{ $tour->titulo }}</h1>
                </div>
            </div>

            <div class="p-8">
                <p class="text-slate-600 text-base leading-relaxed">{{ $tour->descripcion }}</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 my-8 p-5 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                    <div><span class="text-xs text-slate-400 font-semibold block uppercase">Precio</span><strong class="text-lg text-emerald-600 font-black">Bs. {{ number_format($tour->precio, 2) }}</strong></div>
                    <div><span class="text-xs text-slate-400 font-semibold block uppercase">Duración</span><strong class="text-base text-slate-800">{{ $tour->duracion_horas }} hrs</strong></div>
                    <div><span class="text-xs text-slate-400 font-semibold block uppercase">Salida</span><strong class="text-sm text-slate-800">{{ $tour->fecha_salida->format('d/m/Y H:i') }}</strong></div>
                    <div><span class="text-xs text-slate-400 font-semibold block uppercase">Cupos Libres</span><strong class="text-base text-indigo-600">{{ $tour->cupos_disponibles }}</strong></div>
                </div>

                @if($tour->servicios->isNotEmpty())
                    <div class="mb-8">
                        <h3 class="font-bold text-sm uppercase tracking-wider text-slate-700 mb-3">Servicios Incluidos:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tour->servicios as $servicio)
                                <span class="bg-slate-100 text-slate-700 text-xs font-medium px-3 py-1.5 rounded-lg border border-slate-200">✓ {{ $servicio->nombre }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 text-red-700 border border-red-200 p-4 rounded-xl mb-6 text-sm font-medium">
                        {{ $errors->first() }}
                    </div>
                @endif

                @auth
                    @if($tour->cupos_disponibles > 0)
                        <form method="POST" action="{{ route('reservas.store', $tour) }}" class="border-t border-slate-100 pt-6 space-y-4">
                            @csrf
                            <h3 class="font-bold text-lg text-slate-900">Reservar este Tour</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Cantidad de personas</label>
                                    <input type="number" name="cantidad_personas" min="1" max="{{ $tour->cupos_disponibles }}" value="1" required class="border border-slate-300 rounded-xl px-4 py-2.5 w-full text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Observación (opcional)</label>
                                <textarea name="observacion" rows="2" class="border border-slate-300 rounded-xl px-4 py-2.5 w-full text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Ej: Necesito equipo talla L..."></textarea>
                            </div>
                            <button type="submit" class="bg-emerald-600 text-white font-semibold px-6 py-3 rounded-xl shadow-md hover:bg-emerald-700 transition w-full md:w-auto">Confirmar Reserva</button>
                        </form>
                    @else
                        <p class="text-red-500 font-bold border-t border-slate-100 pt-6 text-center">Lo sentimos, los cupos para este tour están agotados.</p>
                    @endif
                @else
                    <div class="border-t border-slate-100 pt-6 text-center bg-slate-50 p-4 rounded-2xl">
                        <p class="text-sm text-slate-600">Debes <a href="{{ route('login') }}" class="text-indigo-600 underline font-bold">iniciar sesión</a> para realizar una reserva.</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>