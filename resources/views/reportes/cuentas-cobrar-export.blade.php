<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Sucursal</th>
            <th>Cliente</th>
            <th>F. pago</th>
            <th>Pago</th>
            <th>Estado</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                <td>{{ $venta->sucursal->nombre }}</td>
                <td>{{ $venta->razon_social }}</td>
                <td>{{ $venta->fpago == null ? 'Contado' : 'Crédito' }}</td>
                <td>{!! estadoPago($venta->est_pago) !!}</td>
                <td>{!! estadoVenta($venta->est_venta) !!}</td>
                <td>{{ $venta->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
