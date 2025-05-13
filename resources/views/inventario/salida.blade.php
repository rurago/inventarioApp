<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Salida de Producto') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('inventario.salida.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="producto_id" class="block font-medium text-sm text-gray-700">Producto</label>
                    <select name="producto_id" id="producto_id" required class="form-select w-full mt-1">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }} ({{ $producto->cantidad }} disponibles)</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="cantidad" class="block font-medium text-sm text-gray-700">Cantidad a retirar</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-input w-full mt-1" min="1" required>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Registrar salida
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
