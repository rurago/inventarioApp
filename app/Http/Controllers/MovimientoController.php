<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        $tipo = $request->input('tipo');

        $movimientos = Movimiento::with('producto')
            ->when($tipo, function ($query, $tipo) {
                $query->where('tipo', $tipo);
            })
            ->latest()
            ->paginate(10);

        return view('movimientos.index', compact('movimientos', 'tipo'));
    }


    public function resumen()
    {
        $resumen = DB::table('productos')
            ->leftJoin('movimientos as entradas', function ($join) {
                $join->on('productos.id', '=', 'entradas.producto_id')
                     ->where('entradas.tipo', '=', 'entrada');
            })
            ->leftJoin('movimientos as salidas', function ($join) {
                $join->on('productos.id', '=', 'salidas.producto_id')
                     ->where('salidas.tipo', '=', 'salida');
            })
            ->select(
                'productos.id',
                'productos.nombre',
                DB::raw('COALESCE(SUM(entradas.cantidad), 0) as total_entradas'),
                DB::raw('COALESCE(SUM(salidas.cantidad), 0) as total_salidas'),
                DB::raw('COALESCE(SUM(entradas.cantidad), 0) - COALESCE(SUM(salidas.cantidad), 0) as disponibles')
            )
            ->groupBy('productos.id', 'productos.nombre')
            ->get();

        return view('movimientos.resumen', compact('resumen'));
    }
}
