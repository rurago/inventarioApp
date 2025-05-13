<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $productos = Producto::all(); // o ->paginate(10)
        return view('inventario.index', compact('productos'));
    }

    public function create()
    {
        // Formulario para crear producto
        return view('inventario.create');

    }

    public function store(Request $request)
    {
        // Guardar nuevo producto en la base de datos
    }

    public function entradaForm()
    {
        // Formulario para entrada de productos
        $productos = Producto::where('activo', true)->get();
        return view('inventario.entrada', compact('productos'));
    }

    public function entradaStore(Request $request)
    {
        // Guardar movimiento de entrada
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);
        $producto->cantidad += $request->cantidad;
        $producto->save();

        // Guardar el movimiento
        Movimiento::create([
            'producto_id' => $producto->id,
            'tipo' => 'entrada',
            'cantidad' => $request->cantidad,
        ]);

        return redirect()->route('productos.index')->with('success', 'Entrada registrada correctamente.');
    }

    public function salidaForm()
    {
        $productos = Producto::where('activo', true)->get();
        return view('inventario.salida', compact('productos'));
    }

    public function salidaStore(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($producto->cantidad < $request->cantidad) {
            return redirect()->back()->withErrors(['cantidad' => 'No hay suficiente inventario disponible.']);
        }

        $producto->cantidad -= $request->cantidad;
        $producto->save();

        Movimiento::create([
            'producto_id' => $producto->id,
            'tipo' => 'salida',
            'cantidad' => $request->cantidad,
        ]);

        return redirect()->route('productos.index')->with('success', 'Salida registrada correctamente.');
    }


    public function toggleStatus($id)
    {
        // Dar de baja o reactivar un producto
    }
}
