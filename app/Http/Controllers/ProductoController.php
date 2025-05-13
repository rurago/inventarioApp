<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    $productos = Producto::all();
    return view('productos.index', compact('productos'));
}
