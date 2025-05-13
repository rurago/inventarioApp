{{-- resources/views/inventario/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Nuevo Producto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('inventario.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="cantidad" class="block text-gray-700 font-bold mb-2">Cantidad inicial:</label>
                        <input type="number" name="cantidad" id="cantidad" class="w-full border border-gray-300 rounded px-3 py-2" value="0" min="0" required>
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Guardar Producto
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
