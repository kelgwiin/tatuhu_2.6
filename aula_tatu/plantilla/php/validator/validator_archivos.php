<?php
$GLOBALS["MAX_FILENAME_LENGTH"] = 260;
$GLOBALS["invalid_chars_regex"] = "[^\wáéíóúÁÉÍÓÚ´ñÑ\s+\(\)\[\].,°!\'&=]";
$GLOBALS["char_no_valid"] = array(",", " ", "-", "_","ñ","á","é","í","ó","ú"); 

function tipo_correcto ($nombre, $tiposValidos){
     if(!in_array(end(explode('.', $nombre)), $tiposValidos)) {
       return false;
     }
     return true;
}

function tipo_archivo ($nombre){
       return (end(explode('.', $nombre)));
}

function nombre_correcto ($nombre){
if(preg_match($GLOBALS['invalid_chars_regex'],$nombre))
        return false;
    return true;
}

function tamanio_correcto($tmpFile, $maxTam){
$file_size = @filesize($tmpFile);
if (!$file_size || $file_size > $maxTam || $file_size <= 0)
        return false;
return true;
}

function imagen_valida($tmpFile, $tiposValidos, $widthMin, $widthMax, $heightMin, $heightMax){
    $imageinfo = getimagesize($tmpFile);
    if(in_array(end(explode('.', $imageinfo['mime'])), $tiposValidos) && isset($imageinfo) 
            && ($imageinfo[0] >= $widthMin && $imageinfo[0] <= $widthMax)
            && ($imageinfo[1] >= $heightMin && $imageinfo[1] <= $heightMax))
        return true;
    return false;
}

function get_nombre($archivo){
    $archivo = trim($archivo);
    $remuevo = array( "([^a-zA-Z0-9-.])", "(-{2,})" );
    $remplazo = array("", "");
    $nuevo_nombre = preg_replace($remuevo, $remplazo, $archivo);
    return $nuevo_nombre;
}

function get_nombre_subida($sufix,$nombre){
    return strtoupper(tipo_archivo($nombre)).$sufix.get_nombre($nombre);      
}

function check_file($file){
    if(!empty($file["error"]) || empty($file['tmp_name']) || $file['tmp_name'] == 'none'){
            return false;
    }
    return true;
}

function valida_tamanio_imagen($file, $mA, $mL, $MA, $ML){
    list($width, $height) = getimagesize($file);
    if (($width > $MA) || ($height > $ML)){ //excede el tamaño
        return "MAX";
    }
    if (($width < $mA) || ($height < $mL)){ //es mas pequeña de lo permitido
        return "MIN";
    }
    return "OK";
}

?>