<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        // Mostrar listado de productos
        return view('inventario.index');
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
        return view('inventario.entrada');
    }

    public function entradaStore(Request $request)
    {
        // Guardar movimiento de entrada
    }

    public function salidaForm()
    {
        // Formulario para salida de productos
        return view('inventario.salida');
    }

    public function salidaStore(Request $request)
    {
        // Guardar movimiento de salida
    }

    public function toggleStatus($id)
    {
        // Dar de baja o reactivar un producto
    }
}
