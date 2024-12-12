<table>
    <thead>
        <tr>
            <th># Ped</th>
            <th>Susursal</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
            <tr wire:key="{{ $producto->id }}">
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->sucursal }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->cantidad }}</td>
                <td>{{ $producto->precio }}</td>
                <td>{{ $producto->total }}</td>
                <td>{{ $producto->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
