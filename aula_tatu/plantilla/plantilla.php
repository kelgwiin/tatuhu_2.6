<?php
error_reporting(~E_ALL);
function p_contenido($lugar,$contenido,$reemplazar=false) {
    GLOBAL $__P;
    if ($reemplazar) {
        $__P['contenido'][$lugar]=$contenido;
    }else{
        $__P['contenido'][$lugar].=$contenido;
    }
}

function p_dibujar($cual_plantilla='standard') {
    GLOBAL $__P;
    extract($__P,EXTR_OVERWRITE);
    require '_'.$cual_plantilla.'.php';
    die();
    
}

function p_con_shortcuts($estatus) {
    GLOBAL $__P;
    if($estatus!==true && $estatus!==false)
        die('Error p_con_shortcuts: el estatus debe ser "activo" o "inactivo"');
    $__P['con_shortcuts']=$estatus;
}

function p_shortcuts_agregar($nombre,$link,$clase=null) {
    GLOBAL $__P;
    $__P['shortcuts'][$nombre]=array(
        'link'=>$link,
        'clase'=>$clase,
        'current'=>false
    );
}

function p_shortcuts_set_activo($nombre) {
    GLOBAL $__P;
    if(!isset($__P['shortcuts'][$nombre])) die('Error p_shortcuts_set_activo: el shortcut "'.$nombre.'" no fue definido');
    $__P['shortcuts'][$nombre]['current']=true;
}


function p_con_menu($estatus) {
    GLOBAL $__P;
    if($estatus!==true && $estatus!==false)
        die('Error p_con_menu: el estatus debe ser "activo" o "inactivo"');
    $__P['con_menu']=$estatus;
}

function p_set_menu_archivo($archivo,$agregar=false) {
    GLOBAL $__P;
    if ($agregar) {
        $__P['menu']['archivos'][]=$archivo;
    }else{
        $__P['menu']['archivos']=array($archivo);
    }
}

function p_login_set_titulo($titulo) {
    GLOBAL $__P;
    $__P['titulo']=$titulo;
}

function p_login_set_msg_contenido($msg) {
    GLOBAL $__P;
    $__P['msg']['contenido']=$msg;
}

function p_login_set_msg_titulo($titulo) {
    GLOBAL $__P;
    $__P['msg']['titulo']=$titulo;
}

function p_login_set_msg_img($imagen) {
    GLOBAL $__P;
    $__P['msg']['imagen']=$imagen;
}

function p_login_set_form_action($action) {
    GLOBAL $__P;
    $__P['form']['action']=$action;
}

function p_login_set_login_error($error) {
    GLOBAL $__P;
    $__P['login_error']=$error;
}


function p_set_rel_path($r_path) {
    GLOBAL $__P;
    $__P['rel_path']=$r_path;
}

function p_get_rel_path() {
    GLOBAL $__P;
    return $__P['rel_path'];
}

function p_css_agregar_archivo($css_file) {
    GLOBAL $__P;
    $__P['css']['files'][]=$css_file;
}

function p_css_agregar_texto($css_text) {
    GLOBAL $__P;
    $__P['css']['text'][]=$css_text;
}

function p_con_pizarra($activo) {
    GLOBAL $__P;
    if($activo!==true && $activo!==false)
        die('Error p_con_pizarra: el estatus debe ser "activo" o "inactivo"');
    $__P['pizarra']['activo']=$activo;
}

function p_js_agregar_texto($texto) {
    GLOBAL $__P;
    $__P['js'][]=$texto;
}

function p_js_agregar_archivo($archivo) {
    GLOBAL $__P;
    $__P['js_files'][]=$archivo;
}

function p_bacceso_agregar_icono($posicion,$nombre,$icono,$link=null,$contador=null) {
    GLOBAL $__P;
    if($posicion < 1 || $posicion > 4) die('Posicion debe estar entre 1 y 4');
    //<li><a href="javascript:void(0);" title="Messages"><span class="icon-inbox"></span><span class="count">2</span></a></li>
    $__P['accessbar'][$posicion]=array(
        'icon'=>$icono,
        'link'=>$link,
        'count'=>$contador,
        'nombre'=>$nombre
    );
}

function p_html_bgcolor($color){
	GLOBAL $__P;
	
	$__P['html']['bgcolor']=$color;
}

function get_random_color(){
    $colors = array("blue-gradient","orange-gradient","green-gradient","silver-gradient");
    return $colors[rand(0,3)];
}

?>