<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Mostrar todos los usuarios y sus roles
    public function editarRoles()
    {
        $usuarios = User::all();
        return view('usuarios.roles', compact('usuarios'));
    }

    // Actualizar el rol de un usuario
    public function actualizarRol(Request $request, User $user)
    {
        $request->validate([
            'rol' => 'required|in:admin,almacenista',
        ]);

        $user->rol = $request->rol;
        $user->save();

        return redirect()->route('usuarios.index')->with('success', 'Rol actualizado correctamente');
    }
}
