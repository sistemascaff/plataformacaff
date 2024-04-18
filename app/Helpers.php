<?php

function helper_tituloPagina(){
    return "CAFF";
}

function helper_versionApp(){
    return "0.1 En desarrollo";
}

function helper_retrocederDirectorio($valor){
    $cadena = "";
    for ($i=0; $i < $valor; $i++) {
        $cadena = $cadena . "../";
    }
    return $cadena;
}

function helper_encapsular($string){
    $string = "'" . $string . "'";
    return $string;
}

function helper_formatoNullorEmpty($valor){
    if (empty($valor) || is_null($valor)) {
        return '-';
    }
    else{
        return $valor;
    }
}

function helper_formatoVistaFecha($fecha){
    if (helper_formatoNullorEmpty($fecha) == '-') {
        return '-';
    }
    else{
        return date('d/m/Y', strtotime($fecha));
    }
}

function helper_formatoVistaFechayHora($fecha){
    if (helper_formatoNullorEmpty($fecha) == '-') {
        return '-';
    }
    else{
        return date('d/m/Y H:i:s', strtotime($fecha));
    }
}

function helper_FormatoBotonCRUD($valor, $tipo){
    $icono = '';
    $texto = '';
    
    switch ($valor) {
        case '1':/*CREATE*/
            $icono = 'fa fa-plus';
            $texto = 'CREAR';
            break;
        case '2':/*READ*/
            $icono = 'fa fa-eye';
            $texto = 'VER';
            break;
        case '3':/*UPDATE*/
            $icono = 'fa fa-pencil';
            $texto = 'EDITAR';
            break;
        case '4':/*DELETE*/
            $icono = 'fa fa-trash';
            $texto = 'ELIMINAR';
            break;
        case '5':/*SAVE*/
            $icono = 'fa fa-save';
            $texto = 'GUARDAR';
            break;
        case '6':/*CANCEL*/
            $icono = 'fa fa-times-circle';
            $texto = 'CANCELAR';
            break;
        case '7':/*RETURN*/
            $icono = 'fa fa-arrow-left';
            $texto = 'VOLVER';
            break;
        case '8':/*SEARCH*/
            $icono = 'fa fa-search';
            $texto = 'BUSCAR';
            break;
        default:
            return 'HELPER ERROR: VALOR EXCEDIDO';
            break;
    }
    
    if ($tipo === 'icono') {
        return '<i class="' . $icono . '"></i>';
    } elseif ($tipo === 'texto') {
        return '<i class="' . $icono . '"></i> ' . $texto;
    } else {
        return 'HELPER ERROR: VALOR EXCEDIDO';
    }
}

function helper_FormatoAtributoValorATexto($valor, $atributo){
    $materiaTipoMateria = '';
    
    switch ($valor) {
        case '1':
            $materiaTipoMateria = 'CUALITATIVA';

            break;
        case '2':
            $materiaTipoMateria = 'CUANTITATIVA';

            break;
        default:
            return 'HELPER ERROR: VALOR EXCEDIDO';
            break;
    }
    
    if ($atributo === 'materiaTipoMateria') {
        return $materiaTipoMateria;
        /*
    } elseif ($tipo === 'texto') {
        return '<i class="' . $icono . '"></i> ' . $texto;*/
    } else {
        return 'HELPER ERROR: ATRIBUTO INCORRECTO';
    }
}


