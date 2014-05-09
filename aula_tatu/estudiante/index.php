<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'ESTUDIANTE') die('No autorizado');
p_set_rel_path('../');
$areas = $_SESSION["interfaz"]["areas"];
$contenido='
<div id="centro">
    <div class="roundaboutContainer">
        <ul id="myRoundabout" class="roundabout-holder">';
foreach($areas as $indice=>$elemento){
    $contenido.= '<li>
                  <a href="componentes.php?id_area='.$elemento['id_area'].'&pos='.$indice.'">
                      <img alt="'.$elemento['nombre_area'].'" src="'.$elemento['imagen'].'">
                  </a>
                 </li>';

}
$contenido.='</ul></div>
    <div id="mensajesArea">
<div class="izq"><a href="#" id="ant"><img src="../plantilla/img/menuAA/previous.png"></a></div>
<span>Selecciona un &Aacute;rea de Aprendizaje</span>
<div class="der"><a href="#" id="sig"><img src="../plantilla/img/menuAA/next.png"></a></div>
</div>
</div>
';

p_contenido('centro',$contenido);

p_js_agregar_archivo('plantilla/js/libs/fredhq-roundabout/jquery.roundabout.min.js');
p_js_agregar_archivo('plantilla/js/developr.confirm.js');
p_css_agregar_archivo("../plantilla/css/stylesTatu/carrusel_tatu.css");

p_js_agregar_texto('
    $(document).ready(function() {
        $("#myRoundabout").roundabout({
			autoplayDuration: 4000,
			autoplayPauseOnHover:true,
			btnNext:"#sig",
			btnPrev: "#ant"
		});
         
    })
');

p_con_menu(true);

p_contenido('titulo_1','Aula Virtual Tatu Hú');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');
p_contenido('migajas','<a href="index.php"> &Aacute;reas de Aprendizaje </a>');

p_con_pizarra(true);
p_contenido('pizarra','Selecciona un &Aacute;rea de Aprendizaje');

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].' '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Inicio');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();        
?>