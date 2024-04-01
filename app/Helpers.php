<?php

function tituloPagina(){
    return "CAFF";
}

function versionApp(){
    return "0.1 En desarrollo";
}

function retrocederDirectorio($valor){
    $cadena = "";
    for ($i=0; $i < $valor; $i++) {
        $cadena = $cadena . "../";
    }
    return $cadena;
}

function encapsular($string){
    $string = "'" . $string . "'";
    return $string;
}

function formatoNullorEmpty($valor){
    if (empty($valor) || is_null($valor)) {
        return '-';
    }
    else{
        return $valor;
    }
}

function formatoVistaFecha($fecha){
    return date('d/m/Y', strtotime($fecha));
}

function formatoVistaFechayHora($fecha){
    if (formatoNullorEmpty($fecha) == '-') {
        return $fecha;
    }
    else{
        return date('d/m/Y H:i:s', strtotime($fecha));
    }
}
/*
function formatoDocente_GradoEstudios($valor)
    {
        if ($valor == "superadmincaff@froebel.edu.bo") {
            return "ESTE ES EL CORREO DEL ADMIN";
        }
        else{
            return "ESTE NO ES EL CORREO DEL ADMIN";
        }
    }
    */
