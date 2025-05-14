<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario') }}
        </h2>
    </x-slot>

    <div class="py-4 px-6">
        @auth
            @if (auth()->user()->rol && auth()->user()->rol->nombre === 'Administrador')
                <a href="{{ route('inventario.create') }}"
                   class="mb-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    ➕ Agregar Producto
                </a>
            @endif
        @endauth

        <table class="min-w-full bg-white border mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nombre</th>
                    <th class="px-4 py-2 border">Descripción</th>
                    <th class="px-4 py-2 border">Cantidad</th>
                    <th class="px-4 py-2 border">Estatus</th>
                    @auth
                        @if (auth()->user()->rol && auth()->user()->rol->nombre === 'Administrador')
                            <th class="px-4 py-2 border">Acciones</th>
                        @endif
                    @endauth
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td class="border px-4 py-2">{{ $producto->id }}</td>
                        <td class="border px-4 py-2">{{ $producto->nombre }}</td>
                        <td class="border px-4 py-2">{{ $producto->descripcion }}</td>
                        <td class="border px-4 py-2">{{ $producto->cantidad }}</td>
                        <td class="border px-4 py-2">
                            <span class="text-sm px-2 py-1 rounded {{ $producto->activo ? 'bg-green-200' : 'bg-red-200' }}">
                                {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        @auth
                            @if (auth()->user()->rol && auth()->user()->rol->nombre === 'Administrador')
                                <td class="border px-4 py-2">
                                    <form action="{{ route('inventario.toggle', $producto->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:underline">
                                            {{ $producto->activo ? 'Dar de baja' : 'Reactivar' }}
                                        </button>
                                    </form>
                                </td>
                            @endif
                        @endauth
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No hay productos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
