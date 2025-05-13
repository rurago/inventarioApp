<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Movimientos') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded">
            <form method="GET" action="{{ route('movimientos.index') }}" class="mb-4">
                <label for="tipo" class="mr-2 font-semibold">Filtrar por tipo:</label>
                <select name="tipo" id="tipo" onchange="this.form.submit()" class="border rounded px-2 py-1">
                    <option value="">-- Todos --</option>
                    <option value="entrada" {{ request('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="salida" {{ request('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
                </select>
            </form>

            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Usuario</th>
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
                            <td>{{ $mov->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">No hay movimientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $movimientos->appends(['tipo' => $tipo])->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
