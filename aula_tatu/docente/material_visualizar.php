<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'PROFESOR') die('No autorizado');
p_set_rel_path('../');
if (isset($_GET['id']) && $_GET['id']!= "" && isset($_GET['componente']) && $_GET['componente']!= "" &&
    isset($_GET['grado']) && $_GET['grado']!= "" && isset($_GET['nombre']) && $_GET['nombre']!= "" &&
    isset($_GET['idA']) && $_GET['idA']!= ""){

$query= 'SELECT C.enlace FROM tbl_actividades B, sist_actividad C
WHERE B.id_actividad="'.$_GET['idA'].'" AND B.tipo_actividad = C.id_tipo';
if(!($q0=mysql_query($query))) error(mysql_error());
$material = mysql_fetch_assoc($q0);
$funcionalidad = "../".$material["enlace"];
$scriptData .='<iframe width="100%" height="600" class="iframe" frameborder="0" src="'.$funcionalidad.'?idLibro='.$_GET['id'].'"></iframe>';
p_contenido('centro','<div id="centro">
	<div id="areaProfesor">
	<table style="margin:0 auto;"><tr>
	    <td>
	    <div style="text-align:center; width:150px; height:120px; margin: 0 auto;">
            <a href="contenidos_visualizar.php?id='.$_GET["componente"].'&grado='.$_GET["grado"].'">
                <img src="../plantilla/img/menuAA/previous.png" style="top:20px;"> 
                <br>Seleccionar otro Contenido</a></div>
	    </td>
       	    <td width="80%" align="center">
		<h3 class="thin"><span class="info">Material: </span>'.$_GET["nombre"].'</h3>
	    </td>
	</tr></table>
	'.$scriptData.'
	</div>
</div>

');
p_con_shortcuts(true);
p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');
p_con_pizarra(true);
p_contenido('pizarra','Contenidos por &Aacute;rea de Aprendizaje');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);
//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Contenidos');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();
}

?>