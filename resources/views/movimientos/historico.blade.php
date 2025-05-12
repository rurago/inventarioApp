@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Histórico de movimientos</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $movimiento)
                <tr>
                    <td>{{ $movimiento->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $movimiento->producto->nombre }}</td>
                    <td>{{ ucfirst($movimiento->tipo) }}</td>
                    <td>{{ $movimiento->cantidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $movimientos->links() }}
</div>
@endsection
