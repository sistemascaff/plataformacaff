<?php
function helper_tituloPagina()
{
    return "CAFF";
}

function helper_versionApp()
{
    return "0.5 En desarrollo";
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
            $texto = 'Crear';
            break;
        case '2':/*READ*/
            $icono = 'fa fa-eye';
            $texto = 'Ver';
            break;
        case '3':/*UPDATE*/
            $icono = 'fa fa-pencil';
            $texto = 'Editar';
            break;
        case '4':/*DELETE*/
            $icono = 'fa fa-trash';
            $texto = 'Eliminar';
            break;
        case '5':/*SAVE*/
            $icono = 'fa fa-save';
            $texto = 'Guardar';
            break;
        case '6':/*CANCEL*/
            $icono = 'fa fa-times-circle';
            $texto = 'Cancelar';
            break;
        case '7':/*RETURN*/
            $icono = 'fa fa-arrow-left';
            $texto = 'Volver';
            break;
        case '8':/*SEARCH*/
            $icono = 'fa fa-search';
            $texto = 'Buscar';
            break;
        case '9':/*ADD*/
            $icono = 'fa fa-plus';
            $texto = 'Añadir';
            break;
        case '10':/*REFRESH*/
            $icono = 'fa fa-refresh';
            $texto = 'Refrescar';
            break;
        case '11':/*CHECK*/
            $icono = 'fa fa-check';
            $texto = 'Marcar';
            break;
        case '12':/*PRINT*/
                $icono = 'fa fa-print';
                $texto = 'Imprimir';
                break;
        case '13':/*RESTORE*/
                $icono = 'fa fa-rotate-left';
                $texto = 'Restaurar';
                break;
        case '14':/*CONFIRM*/
                $icono = 'fa fa-check';
                $texto = 'Confirmar';
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
    $libroEstado = '';
    $libroAdquisicion = '';
    switch ($valor) {
        case '-1':
            $silaboEstado = 'ELIMINADO';
            break;
        case '0':
            $silaboEstado = 'PENDIENTE';
            $libroEstado = 'ELIMINADO';
            break;
        case '1':
            $asignaturaTipoCalificacion = 'CUANTITATIVA';
            $asignaturaTipoBloque = 'BLOQUE DE UN SOLO CURSO';
            $asignaturaTipoAsignatura = 'SIE';
            $dimensionTipoCalculo = 'SUMA';
            $silaboEstado = 'EN CURSO';
            $horarioDia = 'LUNES';
            $libroEstado = 'DISPONIBLE';
            $libroAdquisicion = 'COMPRA';
            break;
        case '2':
            $asignaturaTipoCalificacion = 'CUALITATIVA';
            $asignaturaTipoBloque = 'BLOQUE MIXTO';
            $asignaturaTipoAsignatura = 'INTERNA';
            $dimensionTipoCalculo = 'PROMEDIO';
            $silaboEstado = 'FINALIZADO';
            $horarioDia = 'MARTES';
            $libroEstado = 'EN USO';
            $libroAdquisicion = 'DONACIÓN';
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
    } elseif ($atributo === 'libroEstado') {
        return $libroEstado;
    } elseif ($atributo === 'libroAdquisicion') {
        return $libroAdquisicion;
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
/* MÓDULO ASIGNATURAS, SUMA DE HORARIOS DE LAS ASIGNATURAS. */
function helper_calcularMinutos($horaInicio, $horaFin) {
    $inicio = DateTime::createFromFormat('H:i:s', $horaInicio);
    $fin = DateTime::createFromFormat('H:i:s', $horaFin);
    
    if ($inicio === false || $fin === false) {
        return "Formato de hora inválido.";
    }
    // Calcular la diferencia en minutos
    $diferencia = $fin->diff($inicio);
    return ($diferencia->h * 60) + $diferencia->i;// Convertir horas a minutos y sumar los minutos
}

/* MÓDULO BIBLIOTECA, ETIQUETA DE DISPONIBILIDAD DE UN LIBRO */
function helper_formatoClassLibroEstado($libroEstado){
    switch ($libroEstado) {
        case '0':
            return "card bg-danger text-center";
            break;
        case '1':
            return "card bg-success text-center";
            break;
        case '2':
            return "card bg-info text-center";
            break;    
        default:
        return "";
            break;
    }
}

function helper_centralizadoresVerificarReprobado($puntaje)
{
    if (intval($puntaje) < 51) {
        return '<span class="font-weight-bold text-danger">' . $puntaje . '</span>';
    } else {
        return $puntaje;
    }
}

/* CENTRALIZADORES INTERNOS, SIE Y BOLETINES. */
function helper_reemplazarOrdinal($cadena)
{
    $ordinales = [
        "PRIMERO" => "1°",
        "SEGUNDO" => "2°",
        "TERCERO" => "3°",
        "CUARTO" => "4°",
        "QUINTO" => "5°",
        "SEXTO" => "6°"
    ];
    foreach ($ordinales as $literal => $numeral) {
        if (stripos($cadena, $literal) !== false) {
            $cadena = preg_replace('/\b' . $literal . '\b/i', $numeral, $cadena, 1);
            break;
        }
    }

    return $cadena;
}

function helper_abreviarCurso($cadena) {
    if(helper_formatoNullorEmpty($cadena) == '-'){
        return '';
    }
    
    $cadena = strtoupper(trim($cadena));
    $partes = explode(' ', $cadena);

    // Casos especiales
    $especiales = [
        'TALLER INICIAL ROT' => 'TIR',
        'TALLER INICIAL WEISS' => 'TIW',
        'PRE KINDER ROT' => 'PKR',
        'PRE KINDER WEISS' => 'PKW',
        'KINDER ROT' => 'KR',
        'KINDER WEISS' => 'KW',
    ];

    if (isset($especiales[$cadena])) {
        return $especiales[$cadena];
    }

    // Tablas para los casos regulares
    $cursos = [
        'PRIMERO' => '1',
        'SEGUNDO' => '2',
        'TERCERO' => '3',
        'CUARTO' => '4',
        'QUINTO' => '5',
        'SEXTO' => '6',
    ];

    $niveles = [
        'PRIMARIA' => 'P',
        'SECUNDARIA' => 'S',
    ];

    $paralelos = [
        'ROT' => 'R',
        'WEISS' => 'W',
    ];

    // Búsqueda y armado del resultado
    $curso = $cursos[$partes[0]] ?? '';
    $nivel = $niveles[$partes[2] ?? ''] ?? '';
    $paralelo = $paralelos[$partes[3] ?? $partes[2] ?? ''] ?? '';

    return $curso . $nivel . $paralelo;
}

function recortarTexto($texto, $longitudMaxima) {
    if (strlen($texto) > $longitudMaxima) {
        return substr($texto, 0, $longitudMaxima - 3) . '...';
    }
    return $texto;
}