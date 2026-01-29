<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket</title>
    <style>
        @page {
            margin: 15px;
        }

        body {
            font-family: 'Arial', sans-serif;
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
        <div class="centered">
            <span style="font-size: 15px;">{{ $empresa->razon_social }}</span>
            <p style="font-size: 17px;">T-{{ $venta->cor_ticket }}</p>
            <p>{{ $venta->updated_at->format('d/m/Y H:i:s') }}</p>
            <p style="font-size: 12px;">Cliente: {{ $venta->cliente->razon_social }}</p>
        </div>
        <table>
            <thead>
                <tr style="border-bottom: 1px solid #777;">
                    <th>#</th>
                    <th>PRODUCTO</th>
                    <th style="text-align: center;">CANT</th>
                    <th style="text-align: center;">PU</th>
                    <th style="text-align: right;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->dventas as $dventa)
                    <tr>
                        <td style="vertical-align: top;">{{ $loop->iteration }}</td>
                        <td>{{ $dventa->producto->nombre }}</td>
                        <td style="text-align: right;">{{ $dventa->cantidad }}</td>
                        <td style="text-align: right;">{{ number_format($dventa->precio, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($dventa->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr style="border-top: 1px solid #777;">
                    <th colspan="4">Total a Pagar</th>
                    <th style="text-align: right;">{{ number_format($venta->total, 2) }}</th>
                </tr>
            </tbody>
        </table>
        <p class="centered">Por: {{ $user }}</p>
        <p class="centered">Gracias por su compra</p>
    </div>
</body>

</html>
