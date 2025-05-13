<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Resumen de Movimientos por Producto') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2 text-green-700">Total Entradas</th>
                        <th class="px-4 py-2 text-red-700">Total Salidas</th>
                        <th class="px-4 py-2 text-blue-700">Disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($resumen as $item)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $item->nombre }}</td>
                            <td class="px-4 py-2 text-green-700 font-semibold">{{ $item->total_entradas }}</td>
                            <td class="px-4 py-2 text-red-700 font-semibold">{{ $item->total_salidas }}</td>
                            <td class="px-4 py-2 text-blue-700 font-semibold">{{ $item->disponibles }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">No hay datos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
