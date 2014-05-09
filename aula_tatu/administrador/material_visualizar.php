<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');
if (isset($_GET['idA']) && $_GET['idA']!= ""){

$query= 'SELECT C.enlace FROM tbl_actividades B, sist_actividad C
WHERE B.id_actividad="'.$_GET['idA'].'" AND B.tipo_actividad = C.id_tipo';
if(!($q0=mysql_query($query))) error(mysql_error());
$material = mysql_fetch_assoc($q0);
$funcionalidad = "../".$material["enlace"];
$scriptData .='<iframe width="100%" height="600" class="iframe" frameborder="0" src="'.$funcionalidad.'?idLibro='.$_GET['idA'].'"></iframe>';
if (!isset($_GET["add"]))
    $atras = '<td>
                <div style="text-align:center; width:150px; height:120px; margin: 0 auto;">
                <a href="materiales_visualizar.php">
                    <img src="../plantilla/img/menuAA/previous.png" style="top:20px;"> 
                    <br>Seleccionar otro Material</a></div>
                </td>';
else
    $atras = '<td>
                <div style="text-align:center; width:150px; height:120px; margin: 0 auto;">
                <a href="material_agregar.php">
                    <img src="../plantilla/img/menuAA/previous.png" style="top:20px;"> 
                    <br>Agregar otro Material</a></div>
                </td>';
p_contenido('centro','<div id="centro">
	<div id="areaProfesor">
	<table style="margin:0 auto;"><tr>
        '.$atras.'
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
p_contenido('titulo_grande_1','Vizualizar Material');
p_con_pizarra(true);
p_contenido('pizarra','Vizualizando el material seleccionado');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);
//Botones Izquierda
require '_shortcuts.php';
//p_shortcuts_set_activo('Contenidos');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();
      

}

?>