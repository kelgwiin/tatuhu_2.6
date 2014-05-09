<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'ESTUDIANTE') die('No autorizado');
p_set_rel_path('../');
if(isset($_GET["id_area"]) && isset($_GET["pos"]) && $_GET["id_area"]!="" && $_GET["pos"] != ""){

$area = $_SESSION["interfaz"]["areas"][$_GET["pos"]];
    
// Componentes del area seleccionada
$query='SELECT * FROM tbl_componente WHERE id_area="'.$_GET['id_area'].'" 
       AND id_grado="'.$_SESSION["datos_educativos"]["id_grado"].'" AND activo="SI"';
if(!($q0=mysql_query($query))) error(mysql_error());
$cant = mysql_num_rows($q0);
$contenido='<div id="centro"><p class="big-message '.get_random_color().'">
        <strong>'.$area['nombre_area'].'</strong>
        </p>';
if ($cant > 0){
	$contenido .='<div class="roundaboutContainer">
            <ul id="myRoundabout" class="roundabout-holder">';
        while(($componente=mysql_fetch_assoc($q0))){
            $contenido.= '<li>
                             <a href="contenido.php?id_area='.$componente['id_area'].'&pos='.$_GET["pos"].'&id_componente='.$componente['id_componente'].'&componente='.$componente['componente'].'">
                             <img alt="'.$componente['componente'].'" src="../uploadImages/COMP/'.$componente['imagen'].'">
                          </a>
                         </li>';
        }
        $contenido.='</ul></div>
	<div id="mensajesArea">
            <div class="izq"><a href="#" id="ant"><img src="../plantilla/img/menuAA/previous.png"></a></div>
            <span>Selecciona el Componente</span>
            <div class="der"><a href="#" id="sig"><img src="../plantilla/img/menuAA/next.png"></a></div>
            </div>
        </div>';
}
else{
    $contenido .= '<img src="../plantilla/img/standard/error.png" alt="no hay componentes"> <spam style="color:red;">Esta &aacute;rea no tiene componentes, intenta con otra &aacute;rea</spam>';
}


p_contenido('centro',$contenido);

p_js_agregar_archivo('plantilla/js/libs/fredhq-roundabout/jquery.roundabout.min.js');
p_css_agregar_archivo("../plantilla/css/stylesTatu/carrusel_tatu.css");
p_js_agregar_texto('
    $(document).ready(function() {
        $("#myRoundabout").roundabout({
                        autoplay:true,
			autoplayDuration: 4000,
			autoplayPauseOnHover:true,
			btnNext:"#sig",
			btnPrev: "#ant"
		});      
    })');

p_con_menu(true);

p_contenido('titulo_grande_1','Componentes');
p_contenido('migajas','<a href="index.php"> &Aacute;reas de Aprendizaje </a> &gt; <a href="componentes.php?id_area='.$_GET['id_area'].'&pos=0"> '.$area['nombre_area'].' </a>');

p_con_pizarra(true);
p_contenido('pizarra','<b>'.$_SESSION['persona']['nombre'].' '.$_SESSION['persona']['apellido'].'</b>');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].' '.$_SESSION['persona']['apellido']);


p_js_agregar_texto('
// function hoverAnim(elem,offset,duration) {
$("#sociedad_img_id").hover(function() {
    hoverAnim($("#sociedad_img_id"),10,1000);
})

$("#sociedad_img_id").mouseout(function() {
    hoverAnimStop($("#sociedad_img_id"),10,1000);
})

');

require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();
}
else {
    header("Location: index.php");
}
?>