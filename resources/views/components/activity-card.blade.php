<div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg"> <!-- Cambiamos el fondo a gris claro -->
    <div class="p-6">
        @if ($activity->image)
            <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->name }}"
                class="w-full h-48 object-cover mb-4 rounded">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center mb-4 rounded">
                <span class="text-gray-500">Sin imagen</span>
            </div>
        @endif

        <h3 class="text-lg text-gray-800 font-bold">{{ $activity->nombre }}</h3>

        <p class="mt-2 text-sm text-gray-600"><strong>Duración:</strong> {{ $activity->duracion_minutos }} minutos</p>
        <p class="text-sm text-gray-600"><strong>Dificultad:</strong> {{ $activity->nivel_dificultad }}</p>

        @if ($activity->classSessions && $activity->classSessions->count() > 0)
            <p class="text-sm text-gray-600 mt-2"><strong>Horarios disponibles:</strong></p>
            <ul class="text-xs text-gray-600 mt-1">
                @foreach ($activity->classSessions->take(3) as $session)
                    <li>
                        {{ $session->dia_semana }}: {{ \Carbon\Carbon::parse($session->hora_inicio)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($session->hora_fin)->format('H:i') }} ({{ $session->sala }})
                    </li>
                @endforeach
                @if ($activity->classSessions->count() > 3)
                    <li>... y más horarios</li>
                @endif
            </ul>
        @endif

        @if ($activity->classSessions && $activity->classSessions->count() > 0)
            <p class="mt-2 text-sm text-gray-600">
                <strong>Entrenadores:</strong>
                @php
                    $trainers = $activity->classSessions->pluck('trainer')->unique('id');
                @endphp
                @foreach ($trainers as $trainer)
                    {{ $trainer->nombre ?? '' }} {{ $trainer->apellido1 ?? '' }}@if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </p>
        @endif

        <!-- Botón condicional según estado de autenticación -->
        @if ($showReservationButton)
            @auth
                <a href="{{ route('activities.show', $activity->id) }}"
                    class="mt-4 block text-center w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                    Ver sesiones
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="mt-4 block text-center w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                    Iniciar sesión para reservar
                </a>
            @endauth
        @endif
    </div>
</div>
