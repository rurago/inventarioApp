<?php

namespace App\Http\MovimientoController;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class MovimientoController extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'tipo',
        'cantidad',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function index()
    {
        $movimientos = Movimiento::with('producto')->orderBy('created_at', 'desc')->get();
        return view('movimientos.index', compact('movimientos'));
    }

    // mostrara el resumen de los movimientos, entradas y salidas
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
                DB::raw('COALESCE(SUM(DISTINCT entradas.cantidad), 0) as total_entradas'),
                DB::raw('COALESCE(SUM(DISTINCT salidas.cantidad), 0) as total_salidas'),
                DB::raw('COALESCE(SUM(DISTINCT entradas.cantidad), 0) - COALESCE(SUM(DISTINCT salidas.cantidad), 0) as disponibles')
            )
            ->groupBy('productos.id', 'productos.nombre')
            ->get();

        return view('movimientos.resumen', compact('resumen'));
    }
}
