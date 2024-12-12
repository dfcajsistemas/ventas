<table>
    <thead>
        <tr>
            <th># Caja</th>
            <th>Sucursal</th>
            <th>F. Apertura</th>
            <th>F. Cierre</th>
            <th>Responsable</th>
            <th>Monto cierre</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cajas as $caja)
            <tr wire:key="{{ $caja->id }}">
                <td>{{ $caja->id }}</td>
                <td>{{ $caja->sucursal }}</td>
                <td>{{ $caja->apertura }}</td>
                <td>{{ $caja->cierre }}</td>
                <td>{{ $caja->usuario }}</td>
                <td>{{ $caja->monto_cierre }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
