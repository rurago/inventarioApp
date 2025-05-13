{{-- resources/views/productos/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Productos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('productos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                + Agregar Producto
            </a>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Descripción</th>
                            <th class="px-6 py-3">Cantidad</th>
                            <th class="px-6 py-3">Activo</th>
                            <th class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="border-t">
                                <td class="px-6 py-4">{{ $producto->nombre }}</td>
                                <td class="px-6 py-4">{{ $producto->descripcion }}</td>
                                <td class="px-6 py-4">{{ $producto->cantidad }}</td>
                                <td class="px-6 py-4">
                                    @if ($producto->activo)
                                        <span class="text-green-600 font-semibold">Activo</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <a href="{{ route('productos.edit', $producto) }}" class="text-blue-500 hover:underline">Editar</a>

                                    <form action="{{ route('inventario.toggle', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cambiar el estado del producto?');">
                                        @csrf
                                        <button type="submit" class="text-sm {{ $producto->activo ? 'text-red-600' : 'text-green-600' }} hover:underline">
                                            {{ $producto->activo ? 'Dar de Baja' : 'Reactivar' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($productos->isEmpty())
                    <div class="p-4 text-gray-600">No hay productos registrados.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
