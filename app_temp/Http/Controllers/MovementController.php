<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryMovement::with(['producto', 'usuario']);

        if ($tipo = $request->input('tipo')) {
            $query->where('tipo', $tipo);
        }

        $movimientos = $query->orderBy('fecha', 'desc')->get();
        return view('movimientos.index', compact('movimientos'));
    }

    public function historico()
    {
        $movimientos = Movimiento::with('producto')->latest()->paginate(20);
        return view('movimientos.historico', compact('movimientos'));
    }
}