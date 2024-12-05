<table class="table table-sm table-hover text-small">
    <thead>
        <tr>
            <th>Id</th>
            <th>Sucursal</th>
            <th>Producto</th>
            <th>Stock Mínimo</th>
            <th>Stock</th>
            <th>Precio Costo</th>
            <th>Precio 1</th>
            <th>Precio 2</th>
            <th>Precio 3</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
            <tr wire:key="{{ $producto->id }}">
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->sucursal }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->stock_minimo }}</td>
                <td>{{ $producto->stock }}</td>
                <td>{{ $producto->p_costo }}</td>
                <td>{{ $producto->p_venta1 }}</td>
                <td>{{ $producto->p_venta2 }}</td>
                <td>{{ $producto->p_venta3 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
