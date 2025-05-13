{{-- resources/views/inventario/entrada.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Entrada de Productos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('inventario.entrada.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                <div class="mb-4">
                    <label for="producto_id" class="block text-gray-700 font-bold mb-2">Producto:</label>
                    <select name="producto_id" id="producto_id" class="shadow appearance-none border rounded w-full py-2 px-3">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="cantidad" class="block text-gray-700 font-bold mb-2">Cantidad a ingresar:</label>
                    <input type="number" name="cantidad" id="cantidad" min="1" class="shadow appearance-none border rounded w-full py-2 px-3">
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Registrar Entrada
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
