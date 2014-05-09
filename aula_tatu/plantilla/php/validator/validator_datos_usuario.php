<?php
//variables para validaciones del lado del server
$GLOBALS["cedula"] = '/^([0-9]{7,8})$/i';
$GLOBALS["nombre"] = '/^([a-z áéíóú]{2,60})$/i';
$GLOBALS["telefono"] = '/^((([0-9]{1})*[- .(]*([0-9]{3})[- .)]*[0-9]{3}[- .]*[0-9]{4})+)*$/';
$GLOBALS["correo"] = "/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i";
$GLOBALS["usuario"] = '/^([a-z0-9]{8,15})$/i';
$GLOBALS["fecha"] = ' /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/';
$GLOBALS["tipo_usuario"] = array("ADMINISTRADOR","PROFESOR","ESTUDIANTE","ADMINISTRADOR DE ESCUELA");

function cedulaValida($ci){
    return preg_match($GLOBALS["cedula"], $ci);
}

function nombresValidos($n){
    return preg_match($GLOBALS["nombre"], $n);
}

function telefonoValido($t){
    return preg_match($GLOBALS["telefono"], $t);
}

function correoValido($c){
    return preg_match($GLOBALS["correo"], $c);
}

function usuarioValido($u){
    return preg_match($GLOBALS["usuario"], $u);
}

function fechaValida($f){
    $ano = date('Y');     
    $dtDay = split('/',$f)[0];
    $dtMonth= split('/',$f)[1];
    $dtYear = split('/',$f)[2];
    if(!preg_match($GLOBALS["fecha"], $f))
        return false;
    if($dtYear >= $ano) return false;
    if ($dtMonth < 1 || $dtMonth > 12) return false;
        else if ($dtDay < 1 || $dtDay> 31) return false;
        else if (($dtMonth==4 || $dtMonth==6 || $dtMonth==9 || $dtMonth==11) && $dtDay ==31) return false;
        else if ($dtMonth == 2){
           $isleap = ($dtYear % 4 == 0 && ($dtYear % 100 != 0 || $dtYear % 400 == 0));
           if ($dtDay> 29 || ($dtDay ==29 && !$isleap)) return false;
        }
    return true;
}

function tipoValido($t){
    return in_array($t,$GLOBALS["tipo_usuario"]);
}


?>