@extends('layouts.rastreo')

@section('title', '¿Dónde está mi paquete?')

@section('content')
    <h1>¿Dónde está mi paquete?</h1>
    <p class="muted">Pega tu número de tracking de Amazon y mira su avance de Miami a Costa Rica.</p>

    <form method="GET" action="{{ route('tracking.index') }}">
        <label for="tracking_id">Número de tracking</label>
        <input id="tracking_id" name="tracking_id" value="{{ $searched }}" placeholder="Ej: TBA123456789000" autocomplete="off" required>
        <button class="btn" type="submit">Buscar paquete</button>
    </form>

    @if ($searched && ! $package)
        <div class="msg bad" role="alert">
            No encontramos el número {{ $searched }}. Revisa que esté completo o escríbenos si crees que es un error.
        </div>
    @endif

    @if ($package)
        @php($stages = config('tracking.stages'))
        @php($current = $package->stageIndex())

        <div class="now-box">
            <div class="muted" style="color:#B9C7D6">Estado actual</div>
            <div class="big">{{ $package->status }}</div>
            @if ($package->location)<div>{{ $package->location }}</div>@endif
            <div style="margin-top:8px">
                Actualizado {{ $package->updated_at->timezone('America/Costa_Rica')->format('d/m/Y g:i a') }}
                @if ($package->estimated_delivery)
                    · Entrega estimada: {{ $package->estimated_delivery->format('d/m/Y') }}
                @endif
            </div>
        </div>

        <h2>Ruta</h2>
        <ol class="route">
            @foreach ($stages as $i => $stage)
                <li class="{{ $i < $current ? 'done' : ($i === $current ? 'done now' : '') }}">{{ $stage }}</li>
            @endforeach
        </ol>

        <h2>Historial</h2>
        <ul class="hist">
            @foreach ($package->events as $event)
                <li>
                    <strong>{{ $event->status }}</strong>
                    @if ($event->location) — {{ $event->location }}@endif
                    <div class="muted">
                        {{ $event->created_at->timezone('America/Costa_Rica')->format('d/m/Y g:i a') }}
                        @if ($event->note) · {{ $event->note }}@endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
