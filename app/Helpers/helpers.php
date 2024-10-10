<?php

if (!function_exists('estadoVenta')) {
    function estadoVenta($e = null)
    {
        $est = [
            1 => 'Solicitado',
            2 => 'Preparado',
            3 => 'Delivery',
            4 => 'Entregado',
            5 => 'Anulado'
        ];
        if ($e == null) {
            return $est;
        } elseif (array_key_exists($e, $est)) {
            return $est[$e];
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

if (!function_exists('estadoCuota')) {
    function estadoCuota($e = null)
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
