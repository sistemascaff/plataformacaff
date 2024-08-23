<?php
function helper_tituloPagina()
{
    return "CAFF";
}

function helper_versionApp()
{
    return "0.3 En desarrollo";
}

function helper_retrocederDirectorio($valor)
{
    $cadena = "";
    for ($i = 0; $i < $valor; $i++) {
        $cadena = $cadena . "../";
    }
    return $cadena;
}

function helper_formatoNullorEmpty($valor)
{
    if (empty($valor) || is_null($valor)) {
        return '-';
    } else {
        return $valor;
    }
}

function helper_formatoVistaFecha($fecha)
{
    if (helper_formatoNullorEmpty($fecha) == '-') {
        return '-';
    } else {
        return date('d/m/Y', strtotime($fecha));
    }
}

function helper_formatoVistaFechayHora($fecha)
{
    if (helper_formatoNullorEmpty($fecha) == '-') {
        return '-';
    } else {
        return date('d/m/Y H:i:s', strtotime($fecha));
    }
}

function helper_FormatoBotonCRUD($valor, $tipo)
{
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
        case '9':/*ADD*/
            $icono = 'fa fa-plus';
            $texto = 'AÑADIR';
            break;
        case '10':/*REFRESH*/
            $icono = 'fa fa-refresh';
            $texto = 'REFRESCAR';
            break;
        case '11':/*CHECK*/
            $icono = 'fa fa-check';
            $texto = 'MARCAR';
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

function helper_FormatoAtributoValorATexto($valor, $atributo)
{
    $asignaturaTipoCalificacion = '';
    $asignaturaTipoBloque = '';
    $asignaturaTipoAsignatura = '';
    $dimensionTipoCalculo = '';
    $horarioDia = '';

    switch ($valor) {
        case '-1':
            $silaboEstado = 'ELIMINADO';
            break;
        case '0':
            $silaboEstado = 'PENDIENTE';
            break;
        case '1':
            $asignaturaTipoCalificacion = 'CUANTITATIVA';
            $asignaturaTipoBloque = 'BLOQUE DE UN SOLO CURSO';
            $asignaturaTipoAsignatura = 'SIE';
            $dimensionTipoCalculo = 'SUMA';
            $silaboEstado = 'EN CURSO';
            $horarioDia = 'LUNES';
            break;
        case '2':
            $asignaturaTipoCalificacion = 'CUALITATIVA';
            $asignaturaTipoBloque = 'BLOQUE MIXTO';
            $asignaturaTipoAsignatura = 'INTERNA';
            $dimensionTipoCalculo = 'PROMEDIO';
            $silaboEstado = 'FINALIZADO';
            $horarioDia = 'MARTES';
            break;
        case '3':
            $horarioDia = 'MIÉRCOLES';
            break;
        case '4':
            $horarioDia = 'JUEVES';
            break;
        case '5':
            $horarioDia = 'VIERNES';
            break;
        case '6':
            $horarioDia = 'SÁBADO';
            break;
        case '7':
            $horarioDia = 'DOMINGO';
            break;
        default:
            return 'HELPER ERROR: ¡VALOR NUMÉRICO NO CORRESPONDIENTE!: ' . $valor;
            break;
    }

    if ($atributo === 'asignaturaTipoCalificacion') {
        return $asignaturaTipoCalificacion;
    } elseif ($atributo === 'asignaturaTipoBloque') {
        return $asignaturaTipoBloque;
    } elseif ($atributo === 'asignaturaTipoAsignatura') {
        return $asignaturaTipoAsignatura;
    } elseif ($atributo === 'dimensionTipoCalculo') {
        return $dimensionTipoCalculo;
    } elseif ($atributo === 'silaboEstado') {
        return $silaboEstado;
    } elseif ($atributo === 'horarioDia') {
        return $horarioDia;
    } else {
        return 'HELPER ERROR: ATRIBUTO INCORRECTO';
    }
}

function subhelper_key()
{
    $key = "C4FF...,";
    return $key;
}

function helper_encrypt($string)
{
    $result = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr(subhelper_key(), ($i % strlen(subhelper_key())) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result .= $char;
    }
    return base64_encode($result);
}


function helper_decrypt($string)
{
    $result = '';
    $string = base64_decode($string);
    for ($i = 0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr(subhelper_key(), ($i % strlen(subhelper_key())) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result .= $char;
    }
    return $result;
}

function helper_calcularMinutos($horaInicio, $horaFin) {
    $inicio = DateTime::createFromFormat('H:i:s', $horaInicio);
    $fin = DateTime::createFromFormat('H:i:s', $horaFin);
    // Verificar si las conversiones fueron exitosas
    if ($inicio === false || $fin === false) {
        return "Formato de hora inválido.";
    }
    // Calcular la diferencia en minutos
    $diferencia = $fin->diff($inicio);
    return ($diferencia->h * 60) + $diferencia->i;// Convertir horas a minutos y sumar los minutos
}
