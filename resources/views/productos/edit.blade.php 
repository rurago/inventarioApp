<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('productos.update', $producto) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                            class="w-full border border-gray-300 rounded px-4 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700">Descripción</label>
                        <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion', $producto->descripcion) }}"
                            class="w-full border border-gray-300 rounded px-4 py-2 mt-1">
                    </div>

                    <div class="mb-4">
                        <label for="cantidad" class="block text-gray-700">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad', $producto->cantidad) }}" min="0"
                            class="w-full border border-gray-300 rounded px-4 py-2 mt-1">
                    </div>

                    <div class="mb-6">
                        <label for="activo" class="inline-flex items-center">
                            <input type="checkbox" name="activo" id="activo" value="1"
                                {{ $producto->activo ? 'checked' : '' }}
                                class="form-checkbox text-indigo-600">
                            <span class="ml-2 text-gray-700">Activo</span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('productos.index') }}" class="bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded mr-2">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
