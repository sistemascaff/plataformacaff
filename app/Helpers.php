<?php

function retrocederDirectorio($valor){
    $cadena = "";
    for ($i=0; $i < $valor; $i++) {
        $cadena = $cadena . "../";
    }
    return $cadena;
}

function versionApp(){
    return "0.1 En desarrollo";
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
