<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Mostrar todos los usuarios con sus roles disponibles
    public function editarRoles()
    {
        $usuarios = User::with('rol')->get();
        $roles = Rol::all();

        // 🐞 Imprimir los queries ejecutados
        dd(DB::getQueryLog());
        return view('usuarios.roles', compact('usuarios', 'roles'));
    }

    // Actualizar el rol del usuario
    public function actualizarRol(Request $request, User $user)
    {
        $request->validate([
            'rol_id' => 'required|exists:roles,id',
        ]);

        $user->rol_id = $request->rol_id;
        $user->save();

        return redirect()->route('usuarios.index')->with('success', 'Rol actualizado correctamente');
    }
}
