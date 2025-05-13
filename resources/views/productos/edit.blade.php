{{-- resources/views/productos/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('productos.update', $producto) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Nombre:</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                            class="w-full mt-1 p-2 border rounded">
                        @error('nombre')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Descripción:</label>
                        <input type="text" name="descripcion" value="{{ old('descripcion', $producto->descripcion) }}"
                            class="w-full mt-1 p-2 border rounded">
                        @error('descripcion')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Cantidad:</label>
                        <input type="number" name="cantidad" value="{{ old('cantidad', $producto->cantidad) }}" required
                            class="w-full mt-1 p-2 border rounded">
                        @error('cantidad')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('productos.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
