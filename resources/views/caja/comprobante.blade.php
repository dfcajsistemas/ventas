<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante</title>
    <style>
        @page {
            margin: 15px;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 10px;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .length {
            font-size: 20px;
        }

        .ticket table {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket th,
        .ticket td {
            padding: 2px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <p class="centered" style="font-size: 20px;">{{$venta->tcomprobante->descripcion}}<br></p>
        <p class="centered">{{ $venta->created_at->format('d/m/Y H:i:s') }}</p>
        <p class="centered" style="font-size: 11px;">Cliente: {{ $venta->cliente->razon_social }}</p>
        <table>
            <thead>
                <tr style="border-bottom: 1px solid #777;">
                    <th>#</th>
                    <th>PRODUCTO</th>
                    <th style="text-align: center;">CANT.</th>
                    <th style="text-align: center;">PU</th>
                    <th style="text-align: right;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->dventas as $dventa)
                <tr>
                    <td style="vertical-align: top;">{{$loop->iteration}}</td>
                    <td>{{ $dventa->producto->nombre }}</td>
                    <td style="text-align: right;">{{ $dventa->cantidad }}</td>
                    <td style="text-align: right;">{{ number_format($dventa->precio, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($dventa->total, 2) }}</td>
                </tr>
                @endforeach
                <tr style="border-top: 1px solid #777;">
                    <td colspan="4">Op. Exonerada</td>
                    <td>{{$venta->op_exonerada}}</td>
                </tr>
                <tr>
                    <td colspan="4">Op. Inafecta</td>
                    <td>{{$venta->op_inafecta}}</td>
                </tr>
                <tr>
                    <td colspan="4">Op. Grabada</td>
                    <td>{{$venta->op_grabada}}</td>
                </tr>
                <tr>
                    <td colspan="4">IGV</td>
                    <td>{{$venta->igv}}</td>
                </tr>
                <tr>
                    <td colspan="4">Total a Pagar</td>
                    <td>{{$venta->total}}</td>
                </tr>
            </tbody>
        </table>
        <p class="centered">Total: {{ number_format($venta->total, 2) }}</p>
        <p class="centered">Gracias por su compra</p>
    </div>
</body>

</html>