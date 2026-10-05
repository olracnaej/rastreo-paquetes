@extends('layouts.rastreo')

@section('title', 'Panel de paquetes')

@section('content')
    <h1>Registrar o actualizar paquete</h1>
    <p class="muted">Si el tracking ya existe, se actualiza su estado. Si es nuevo, se crea.</p>

    @if (session('ok'))<div class="msg ok" role="status">{{ session('ok') }}</div>@endif
    @if ($errors->any())
        <div class="msg bad" role="alert">
            <ul class="errors">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.packages.store') }}">
        @csrf
        <label for="tracking_id">Número de tracking</label>
        <input id="tracking_id" name="tracking_id" value="{{ old('tracking_id') }}" required>

        <div class="grid">
            <div>
                <label for="status">Estado</label>
                <select id="status" name="status" required>
                    @foreach (config('tracking.stages') as $stage)
                        <option value="{{ $stage }}" @selected(old('status') === $stage)>{{ $stage }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="location">Ubicación</label>
                <input id="location" name="location" value="{{ old('location') }}" placeholder="Ej: Bodega Miami">
            </div>
            <div>
                <label for="customer_name">Cliente (opcional)</label>
                <input id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
            </div>
            <div>
                <label for="estimated_delivery">Entrega estimada (opcional)</label>
                <input id="estimated_delivery" type="date" name="estimated_delivery" value="{{ old('estimated_delivery') }}">
            </div>
        </div>

        <label for="description">Qué contiene (opcional)</label>
        <input id="description" name="description" value="{{ old('description') }}">

        <label for="note">Nota (opcional)</label>
        <input id="note" name="note" value="{{ old('note') }}" placeholder="Ej: Salió en el vuelo de la tarde">

        <button class="btn" type="submit">Guardar paquete</button>
    </form>

    <h2>Últimos paquetes</h2>
    <div class="scroll">
        <table>
            <thead><tr><th>Tracking</th><th>Cliente</th><th>Estado</th><th>Ubicación</th><th>Actualizado</th></tr></thead>
            <tbody>
            @forelse ($packages as $p)
                <tr>
                    <td><a href="{{ route('tracking.index', ['tracking_id' => $p->tracking_id]) }}">{{ $p->tracking_id }}</a></td>
                    <td>{{ $p->customer_name }}</td>
                    <td>{{ $p->status }}</td>
                    <td>{{ $p->location }}</td>
                    <td>{{ $p->updated_at->timezone('America/Costa_Rica')->format('d/m g:i a') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Aún no hay paquetes. Registra el primero arriba.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:12px">{{ $packages->links() }}</div>
@endsection
