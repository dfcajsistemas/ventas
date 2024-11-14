<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->name }}</td>
                <td>{{ $invoice->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
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
                <td>{{ $venta->cliente->razon_social }}</td>
                <td>{{ $venta->fpago == null ? 'Contado' : 'Crédito' }}</td>
                <td>{!! estadoPago($venta->est_pago) !!}</td>
                <td>{!! estadoVenta($venta->est_venta) !!}</td>
                <td>{{ $venta->total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
