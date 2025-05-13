<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $productos = Product::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        Product::create($request->validate(['nombre' => 'required|string|max:255']));
        return redirect()->route('productos.index');
    }

    public function entrada(Request $request, Product $producto)
    {
        $cantidad = $request->input('cantidad');
        $producto->increment('cantidad', $cantidad);

        InventoryMovement::create([
            'product_id' => $producto->id,
            'user_id' => Auth::id(),
            'tipo' => 'entrada',
            'cantidad' => $cantidad
        ]);

        return back();
    }

    public function salida(Request $request, Product $producto)
    {
        $cantidad = $request->input('cantidad');
        if ($producto->cantidad < $cantidad) {
            return back()->withErrors(['cantidad' => 'No hay suficiente inventario.']);
        }

        $producto->decrement('cantidad', $cantidad);

        InventoryMovement::create([
            'product_id' => $producto->id,
            'user_id' => Auth::id(),
            'tipo' => 'salida',
            'cantidad' => $cantidad
        ]);

        return back();
    }

    public function toggle(Product $producto)
    {
        $producto->activo = !$producto->activo;
        $producto->save();
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'cantidad' => 'required|integer|min:0',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

}