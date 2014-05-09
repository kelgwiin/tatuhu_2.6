<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'PROFESOR') die('No autorizado');
p_set_rel_path('../');
if (isset($_GET["id"]) && $_GET["id"] != ""){


$query = "SELECT A.ruta, B.enlace, C.nombre_actividad
	 FROM tbl_act_material AS A, sist_actividad B, tbl_actividades AS C
	 WHERE A.id_material = '".$_GET["id"]."' AND A.id_actividad = C.id_actividad
	 AND C.tipo_actividad = B.id_tipo";
if(!($q0=mysql_query($query))) error(mysql_error());
$libro = mysql_fetch_assoc($q0);

$funcionalidad = p_get_rel_path().$libro["enlace"];

p_contenido('centro','
<div id="centro">	
	<div id="areaProfesor">'.$libro["nombre_actividad"].'<br>
		<iframe width="97%" height="800" frameborder="0" src="'.$funcionalidad.'?libro='.$libro["ruta"].'" class="modal-iframe"></iframe>
	</div>
</div>

');

p_css_agregar_texto(' 
	#centro{
		padding:20px;
	}
	#areaProfesor{ width: 100%; margin: 0 auto; text-align:center; }
	.imgarea{width:130px; height:130px; margin:10px; opacity: 0.5;}
	.imgarea:hover{opacity: 1;}
	.info{font-weight:bold;}
	#componentes{text-align:center;}
	.error{display:none; color:red;}
');

p_con_shortcuts(true);
p_con_menu(true);

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');

$meses=array(1=>'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago','Sep','Oct','Nov','Dic');
p_contenido('titulo_grande_2',$meses[(date('m')+0)].' <strong>'.date('d').'</strong>');
p_con_pizarra(true);
p_contenido('pizarra','Contenidos por &Aacute;rea de Aprendizaje');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Inicio');


p_set_menu_archivo('menu_tatu.php');

p_bacceso_agregar_icono(1,'Bandeja de Entrada','icon-inbox');
p_bacceso_agregar_icono(4,'Salir','<img src="'.p_get_rel_path().'/images/salir.png" width="25" style="position: relative; top: 5px;"/>',p_get_rel_path().'logout.php');


p_dibujar();  
}
?>