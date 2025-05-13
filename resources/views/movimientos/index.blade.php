<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Movimientos') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($movimientos as $mov)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $mov->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2">{{ $mov->producto->nombre }}</td>
                            <td class="px-4 py-2">
                                @if ($mov->tipo === 'entrada')
                                    <span class="text-green-600 font-semibold">Entrada</span>
                                @else
                                    <span class="text-red-600 font-semibold">Salida</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $mov->cantidad }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">No hay movimientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
