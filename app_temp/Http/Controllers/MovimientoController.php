<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
        ]);

        $movimiento = new Movimiento();
        $movimiento->producto_id = $request->producto_id;
        $movimiento->tipo = $request->tipo;
        $movimiento->cantidad = $request->cantidad;
        $movimiento->save();

        // Lógica para actualizar stock
        $producto = Producto::findOrFail($request->producto_id);
        if ($movimiento->tipo === 'entrada') {
            $producto->stock += $movimiento->cantidad;
        } else {
            $producto->stock -= $movimiento->cantidad;
        }
        $producto->save();

        return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    public function historico()
    {
        $movimientos = Movimiento::with('producto')->latest()->paginate(20);
        return view('movimientos.historico', compact('movimientos'));
    }
}
