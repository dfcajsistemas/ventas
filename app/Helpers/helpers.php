<?php

if (!function_exists('estadoVenta')) {
    function estadoVenta($e = null)
    {
        $est = [
            1 => ['estado' => 'Solicitado', 'color' => 'text-warning'],
            2 => ['estado' => 'Delivery', 'color' => 'text-primary'],
            3 => ['estado' => 'Entregado', 'color' => 'text-success'],
            4 => ['estado' => 'Anulado', 'color' => 'text-danger'],
        ];
        if ($e == null) {
            $result = [];
            foreach ($est as $key => $value) {
                $result[$key] = $value['estado'];
            }
            return $result;
        } elseif (array_key_exists($e, $est)) {
            return '<h6 class="mb-0 w-px-100 ' . $est[$e]['color'] . '"><i class="bx bxs-circle fs-tiny me-2"></i>' . $est[$e]['estado'] . '</h6>';
        } else {
            return 'Error';
        }
    }
}

if (!function_exists('tipoMovimiento')) {
    function tipoMovimiento($v = null)
    {
        $valores = [
            1 => 'Ingreso',
            2 => 'Egreso'
        ];
        if ($v == null) {
            return $valores;
        } elseif (array_key_exists($v, $valores)) {
            return $valores[$v];
        } else {
            return 'Error';
        }
    }
}

if (!function_exists('estadoPago')) {
    function estadoPago($e = null)
    {
        if ($e == null) {
            return '<span class="badge bg-label-success"> Pagado </span>';
        } elseif ($e == 1) {
            return '<span class="badge bg-label-warning"> Pendiente </span>';
        } else {
            return '<span class="badge bg-label-danger"> Error </span>';
        }
    }
}
