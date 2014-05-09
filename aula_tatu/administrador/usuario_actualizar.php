<?php
require '../config.php';
require '../auth.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
// -------------------------------------------------
// -----------------CONTROLADOR---------------------
// -------------------------------------------------





// -------------------------------------------------
// -----------------VISTA---------------------------
// -------------------------------------------------

// Aqui se obtienen los Usuarios registrados en Sistema
$query='SELECT * FROM tbl_personas AS A, tbl_unidadeducativa AS B WHERE cedula="'.$_GET['cedula'].'" and A.id_escuela=B.id_colegio';
//echo $query; die();
$q0=mysql_query($query);
if(!$q0) die('Error de Comunicacion y Gestion con BD <br>'.mysql_error().'<br>Comunique al Administrador');
$total_personas=mysql_num_rows($q0);
$row_datos=mysql_fetch_assoc($q0);

p_set_rel_path('../');

$_contenido='
<h3 class="thin">  Actualizacion de Usuario</h3>
<div>
	<div align="center">Cedula<br><input type="text" name="cedula" class="input" id="cedula_id"></div>
	<br><br>
	<div align="center">
		<button type="submit" class="button glossy">
			<span class="button-icon"><span class="icon-tick"></span></span>
			Actualizar Clave
		</button>
		<button type="submit" class="button glossy">
			<span class="button-icon"><span class="icon-tick"></span></span>
			Actualizar Datos
		</button>
		<button type="submit" class="button glossy">
		<span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>Cancelar</a>
		</button>
	</div>
</div>';


p_contenido('centro',$_contenido);

p_css_agregar_archivo("../plantilla/css/styles/table_59edcbff.css");

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Gestor de Usuarios');

p_con_pizarra(false);

p_con_menu(true);
$meses=array(1=>'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago','Sep','Oct','Nov','Dic');
p_contenido('titulo_grande_2',$meses[(date('m')+0)].' <strong>'.date('d').'</strong>');
//p_contenido('titulo_pequeno','titulo_pequeno');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
p_shortcuts_agregar('Inicio','index.php');
p_shortcuts_set_activo('Inicio');

// Iconos de acceso (barra derecha)
p_bacceso_agregar_icono(1,'Bandeja de Entrada','icon-inbox');
p_bacceso_agregar_icono(4,'Salir','<img src="'.p_get_rel_path().'/images/salir.png" width="25" style="position: relative; top: 5px;"/>',p_get_rel_path().'logout.php');

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
