{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Panel de Control</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        @role('Administrador')
            <!-- Administrador: Ver inventario -->
            <a href="{{ route('inventario.index') }}" class="btn-dashboard">Ver Inventario</a>
            <a href="{{ route('inventario.create') }}" class="btn-dashboard">Agregar Productos</a>
            <a href="{{ route('inventario.entrada') }}" class="btn-dashboard">Entrada de Productos</a>
            <a href="{{ route('inventario.baja') }}" class="btn-dashboard">Dar de baja/reactivar</a>
            <a href="{{ route('inventario.salida') }}" class="btn-dashboard">Salida de Productos</a>
            <a href="{{ route('movimientos.index') }}" class="btn-dashboard">Historial de Movimientos</a>
        @elserole('Almacenista')
            <!-- Almacenista -->
            <a href="{{ route('inventario.index') }}" class="btn-dashboard">Ver Inventario</a>
            <a href="{{ route('inventario.entrada') }}" class="btn-dashboard">Entrada de Productos</a>
            <a href="{{ route('inventario.salida') }}" class="btn-dashboard">Salida de Productos</a>
            <a href="{{ route('movimientos.index') }}" class="btn-dashboard">Historial de Movimientos</a>
        @endrole

    </div>
</div>

<style>
    .btn-dashboard {
        @apply bg-blue-600 text-white p-4 rounded-lg shadow hover:bg-blue-700 transition text-center block;
    }
</style>
@endsection
