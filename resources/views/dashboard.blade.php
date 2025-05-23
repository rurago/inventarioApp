
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        @auth
            @if (auth()->user()->rol && auth()->user()->rol->nombre === 'Administrador')
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <a href="{{ route('productos.index') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Ver Productos
                        </a>
                    </div>
                </div>
            @endif
        @endauth
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Bienvenido al sistema de inventario</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('inventario.index') }}" class="block p-4 bg-blue-100 rounded hover:bg-blue-200">
                        📦 Ver Inventario
                    </a>

                    @auth
                        @if (auth()->user()->rol && auth()->user()->rol->nombre === 'Administrador')
                            <a href="{{ route('inventario.create') }}" class="block p-4 bg-green-100 rounded hover:bg-green-200">
                                ➕ Agregar Nuevo Producto
                            </a>
                            <a href="{{ route('movimientos.index') }}" class="block p-4 bg-gray-100 rounded hover:bg-gray-200">
                                📋 Ver Historial de Movimientos
                            </a>
                        @endif
                    @endauth
                    
                    @auth
                        @if (auth()->user()->rol && auth()->user()->rol->nombre === 'Almacenista')
                            <a href="{{ route('inventario.entrada') }}" class="block p-4 bg-yellow-100 rounded hover:bg-yellow-200">
                                🔼 Entrada de Productos
                            </a>

                            <a href="{{ route('inventario.salida') }}" class="block p-4 bg-red-100 rounded hover:bg-red-200">
                                🔽 Salida de Productos
                            </a>
                        @endif
                    @endauth
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
