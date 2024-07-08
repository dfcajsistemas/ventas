<?php

if(!function_exists('docTipo')) {
    function docTipo($t=null){
        $tipos = [
            1 => 'DNI',
            2 => 'Carnet de Extranjería',
            3 => 'Pasaporte'
        ];
        if($t==null){
            return $tipos;
        }elseif(array_key_exists($t, $tipos)){
            return $tipos[$t];
        }else{
            return 'Error';
        }
    }
}
