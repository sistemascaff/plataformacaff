<?php
/*COMENTARIO TEST GITHUB*/
function helper_tituloPagina(){
    return "CAFF";
}

function helper_versionApp(){
    return "0.3 En desarrollo";
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
    $asignaturaTipoCalificacion = '';
    $asignaturaTipoBloque = '';
    $asignaturaTipoAsignatura = '';
    $dimensionTipoCalculo = '';
    
    switch ($valor) {
        case '1':
            $asignaturaTipoCalificacion = 'CUALITATIVA';
            $asignaturaTipoBloque = 'BLOQUE DE UN SOLO CURSO';
            $asignaturaTipoAsignatura = 'SIE';
            $dimensionTipoCalculo = 'SUMA';
            break;
        case '2':
            $asignaturaTipoCalificacion = 'CUANTITATIVA';
            $asignaturaTipoBloque = 'BLOQUE MIXTO';
            $asignaturaTipoAsignatura = 'INTERNA';
            $dimensionTipoCalculo = 'PROMEDIO';
            break;
        default:
            return 'HELPER ERROR: VALOR EXCEDIDO';
            break;
    }
    
    if ($atributo === 'asignaturaTipoCalificacion') {
        return $asignaturaTipoCalificacion;
    }
    elseif ($atributo === 'asignaturaTipoBloque') {
        return $asignaturaTipoBloque;
    }
    elseif ($atributo === 'asignaturaTipoAsignatura') {
        return $asignaturaTipoAsignatura;
    }
    elseif ($atributo === 'dimensionTipoCalculo') {
        return $dimensionTipoCalculo;
    }
    else {
        return 'HELPER ERROR: ATRIBUTO INCORRECTO';
    }
}


