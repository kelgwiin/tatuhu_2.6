<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'ESTUDIANTE') die('No autorizado');
p_set_rel_path('../');
if(isset($_GET["id_area"]) && $_GET["id_area"]!="" && isset($_GET["pos"]) && $_GET["pos"]!="" &&
   isset($_GET["id_componente"]) && isset($_GET["componente"]) && $_GET["id_componente"]!="" && $_GET["componente"] != ""){

$area = $_SESSION["interfaz"]["areas"][$_GET["pos"]];
/*
 * Se obtienen los datos de los contenidos del componente seleccionado Adicionalmente se cuenta la cantidad total de actividades de cada contenido
 * y las realizadas por el estudiante
 */
$query='SELECT A.id_contenido, A.contenido, A.id_componente, A.orden, 
    COUNT(DISTINCT B.id_actividad) cantTotal, COUNT(DISTINCT C.id_actividad) cantEst
FROM tbl_contenido A 
LEFT JOIN tbl_actividades B ON A.id_contenido = B.id_contenido AND B.usuario="ESTUDIANTE"
LEFT JOIN tbl_persona_actividad C ON C.id_persona = "'.$_SESSION['persona']['cedula'].'" 
AND C.id_actividad=B.id_actividad AND C.completada="SI"
 WHERE A.id_componente="'.$_GET['id_componente'].'" GROUP BY 1 ORDER BY A.orden';
$q0=mysql_query($query);
if(!$q0) die('Error en la consulta de los Contenidos <br><b>'.mysql_error().'</b><br> Consulte al Administrador del Sistema');
$contenido='
<div id="centro">
<div class="columns">
<div class="tatuPresentando new-row three-columns"><img src="../plantilla/img/tatupieGrande.png"></div>  
    <div class="eight-columns" style="margin-top:25px;">
        <p class="big-message '.get_random_color().'">
        <strong>Area: '.$area["nombre_area"].'</strong><br><br>
       <span style="color:#000;"><b>Componente: '.$_GET["componente"].'</b><br>
        </span>
        </p>
    </div>
</div>';

if(mysql_num_rows($q0)>0){
$contenidos = array();
while($data=mysql_fetch_assoc($q0)){
        $contenidos[] = $data;
}
$cant_contenidos = count($contenidos);
if ($cant_contenidos>0 && $contenidos[0]['cantTotal']>0){
$contenido.= '<audio id="hover" preload="auto"><source src="../plantilla/sound/menu_hover.ogg" type="audio/ogg"></audio> 
    <div class="listado-contenidos ">
        <ul class="message-menu contenidos">';
    for($i=0; $i<$cant_contenidos; $i++){
        if ($contenidos[$i]['cantTotal']>0){
        $class="enabled with-right-arrow";
        $message = ($contenidos[$i]['cantEst']>0)? "Clic en la <strong>Estrella</strong> para ver tus recompensas": "No tienes recompensas en este contenido";
        $href = "href='contenido_seleccionado.php?id_contenido=".$contenidos[$i]['id_contenido']."&id_area=".$_GET['id_area']."&pos=".$_GET['pos']."&id_componente=".$_GET['id_componente']."'";
        if ($contenidos[$i]['cantEst'] > 0){
            $star ='starred';
            $title = 'Clic para ver tus recompensas';
            $rec = "href='recompensas.php?id_contenido=".$contenidos[$i]['id_contenido']."&contenido=".$contenidos[$i]['contenido']."'";
        }
        else{
            $star = "unstarred";
            $title = "";
            if($i!=0) 
            $rec = "";
        }
        if ($i>0){
            if ($contenidos[$i-1]['cantTotal']>0 && ($contenidos[$i-1]['cantEst']/$contenidos[$i-1]['cantTotal'])>0.5 && $class!="disabled"){
                $class = "enabled with-right-arrow";
            }
            else{
                $class = "disabled"; $href="";
            }
        }
        $contenido.= '<li class="'.$class.' ">
                <span class="message-status children-tooltip tooltip-left">
                        <a '.$rec.' class="'.$star.'" title="'.$title.'"></a>
                </span>
                <a '.$href.'>
                        '.$contenidos[$i]["contenido"].'<br><br>
                        <span>'.$message.'</span>
                </a></li>';
     }
     else{
          $contenido.= '<li class="disabled "><a>'.$contenidos[$i]["contenido"].'<br><br>
                        <span><img src="../plantilla/img/standard/error.png" alt="no hay actividades"> No hay actividades en este Contenido</span>
                </a></li>';
     }
    }
$contenido.= '</ul>';
}
else{
    $contenido .= '<img src="../plantilla/img/standard/error.png" alt="no hay actividades"> <spam style="color:red;">Este componente no tiene actividades, intenta con otro componente</spam>';
}
 
}
else{
    $contenido .= '<img src="../plantilla/img/standard/error.png" alt="no hay actividades"> <spam style="color:red;">Este componente no tiene temas, intenta con otro componente</spam>';
}
$contenido.= '</div></div>';
p_contenido('centro',$contenido);

p_con_menu(true);

p_js_agregar_archivo('plantilla/js/jsUsuarios/playSound.js');
p_js_agregar_texto(' playOnHover("hover",".contenidos li.enabled");');

p_css_agregar_texto('
.listado-contenidos{margin:0 auto; max-width:600px; height:}
.columns{margin:0 auto; max-width:600px; height:}
.contenidos{text-align:left;  }
.contenidos li a{color:#fff;}
.contenidos li a span{font-weight:normal !important; text-shadow: none !important;}

.contenidos li:nth-of-type(1){
	background: #f9971b;
}

.contenidos li:nth-of-type(2){
	background: #00a859;
}

.contenidos li:nth-of-type(3){
	background: #ed3237;
}

.contenidos li:nth-of-type(4){
	background: #3e4095;
}

.contenidos li:nth-of-type(5){
	background: #e30876;
}

.contenidos li:nth-of-type(6){
	background: #8682ab;
}

.contenidos li:nth-of-type(7){
	background: #cab400;
}

.contenidos li:nth-of-type(8){
	background: #f9971b;
}

.contenidos li:nth-of-type(9){
	background: #00a859;
}

.contenidos li:nth-of-type(10){
	background: #ed3237;
}

.contenidos li:nth-of-type(11){
	background: #3e4095;
}

.contenidos li:nth-of-type(12){
	background: #e30876;
}

.contenidos li:nth-of-type(13){
	background: #8682ab;
}

.contenidos li:nth-of-type(14){
	background: #cab400;
}

.contenidos li.disabled{ background: #9E9E9E;}
');

p_contenido('titulo_grande_1','Contenidos');
p_contenido('migajas','<a href="index.php"> &Aacute;reas de Aprendizaje </a> &gt; <a href="componentes.php?id_area='.$_GET['id_area'].'&pos=0">'.$area["nombre_area"].'</a> &gt; <a href="contenido.php?id_area='.$_GET['id_area'].'&area='.$_GET['area'].'&pos=0&id_componente='.$_GET['id_componente'].'&componente='.$_GET['componente'].'">'.$_GET['componente'].'</a>');

p_con_pizarra(true);
p_contenido('pizarra','<b>'.$_SESSION['persona']['nombre'].' '.$_SESSION['persona']['apellido'].'</b>');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].' '.$_SESSION['persona']['apellido']);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');

p_dibujar();   
}
else{
    header("location: index.php");
}
?>