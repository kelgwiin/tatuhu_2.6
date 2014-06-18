<?php
$valid_exts=array('jpg','bmp','png','gif');
$valid_exts_vid=array('mp4','ogv','webm');
$invalid_chars_regex = '[^\wαινσϊΑΙΝΣΪ΄ρΡ\s+\(\)\[\].,°!\'&=]';
$_dir = "../../";

function valida_nombre_libro($nombre){
    $tmp = explode("/",$nombre);
    $nombreDir = $tmp[1];
    if(preg_match($GLOBALS['invalid_chars_regex'],$nombreDir))
        return false;
    return true;
}

function directorio_libro($libro){
    return opendir($GLOBALS['_dir'].$libro);
}

function ruta_libro($libro){
    return $GLOBALS['_dir'].$libro;
}

function paginas_libro($dir,$ruta){
    $pages = array();
    while($ptr=readdir($dir)){
        if($ptr!='.' && $ptr!='..') {
            $ext=strtolower(substr($ptr,-3));
            if (array_search($ext,$GLOBALS['valid_exts'])!==false) {
                $pages[]= $GLOBALS['_dir'].$ruta.$ptr;
            }
        }
    }
    closedir($dir);
    sort($pages);
  //  print_r($pages);
    return $pages;
}

//Extensiones permitidas: mp4, ogv, webm - EL NOMBRE DEL ARCHIVO NO PUEDE CONTENER PUNTO
function valida_extension_video($video){
    $ext = substr(strrchr($video, '.'), 1);
    if (!in_array($ext, $valid_exts_vid))
        return false;
 return true;
}

function extension_video($video){
    return substr(strrchr($video, '.'), 1);
}

//Retorna el ID de un video de youtube
function video_ID($link){
    return substr(strrchr($link, '='), 1);
}

?>