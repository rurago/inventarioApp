<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
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
}
