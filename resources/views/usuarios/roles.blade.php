@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Gestión de Roles</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border mb-4">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 text-left">Nombre</th>
                <th class="p-2 text-left">Email</th>
                <th class="p-2 text-left">Rol actual</th>
                <th class="p-2 text-left">Cambiar rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr class="border-b">
                    <td class="p-2">{{ $usuario->name }}</td>
                    <td class="p-2">{{ $usuario->email }}</td>
                    <td class="p-2 capitalize">{{ $usuario->rol }}</td>
                    <td class="p-2">
                        @if($usuario->id !== auth()->id())
                        <form method="POST" action="{{ route('usuarios.actualizarRol', $usuario) }}">
                            @csrf
                            <select name="rol" class="border p-1 mr-2">
                                <option value="admin" {{ $usuario->rol === 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="almacenista" {{ $usuario->rol === 'almacenista' ? 'selected' : '' }}>Almacenista</option>
                            </select>
                            <button class="bg-blue-500 text-white px-2 py-1 rounded">Guardar</button>
                        </form>
                        @else
                            <span class="text-gray-500 italic">No editable</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
