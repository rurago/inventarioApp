<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Producto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('productos.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre">
                        Nombre
                    </label>
                    <input name="nombre" type="text" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="descripcion">
                        Descripción
                    </label>
                    <input name="descripcion" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cantidad">
                        Cantidad
                    </label>
                    <input name="cantidad" type="number" min="0" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" value="0">
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                        Guardar
                    </button>
                    <a href="{{ route('productos.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
