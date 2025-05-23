<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'cantidad' => 'required|integer|min:0',
        ]);

        // Crear producto
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
            'activo' => true,
        ]);

        // Redirigir con mensaje
        return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'cantidad' => 'required|integer|min:0',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'cantidad' => $request->cantidad,
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function baja(Producto $producto)
    {
        $producto->activo = false;
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto dado de baja.');
    }

    public function activar(Producto $producto)
    {
        $producto->activo = true;
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto reactivado.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado permanentemente.');
    }


}
