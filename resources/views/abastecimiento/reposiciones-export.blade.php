<table>
    <thead>
        <tr>
            <th colspan="4" style="font-size: 11px; font-weight:500;">REPOSISCIONES
                ({{ date('d/m/Y', strtotime($desde)) }} -
                {{ date('d/m/Y', strtotime($hasta)) }})</th>
        </tr>
        <tr>
            <th colspan="4" style="font-size: 13px; font-weight:500;">{{ $nombre }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Id</th>
            <th style="font-weight: bold;">Lote</th>
            <th style="font-weight: bold;">Cantidad</th>
            <th style="font-weight: bold;">Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reposiciones as $reposicion)
            <tr wire:key="{{ $reposicion->id }}">
                <td>{{ $reposicion->id }}</td>
                <td>{{ $reposicion->lote }}</td>
                <td>{{ $reposicion->cantidad }}</td>
                <td>{{ date('d/m/Y', strtotime($reposicion->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
