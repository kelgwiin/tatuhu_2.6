<?php
require '../config.php';
require '../auth.php';
if($_SESSION['usuario']['tipo'] != 'ESTUDIANTE') die('No autorizado');
p_set_rel_path('../');

if (isset($_POST["imagen_seleccionada"]) && $_POST["imagen_seleccionada"] != ""){
	$id = split('-', $_POST['imagen_seleccionada'])[0];
	$ruta = split('-', $_POST['imagen_seleccionada'])[1];
	$query='UPDATE sist_usuario SET id_avatar="'.$_POST['imagen_seleccionada'].'" WHERE cedula="'.$_SESSION['usuario']['cedula'].'" AND activo="SI"';
	$q0=mysql_query($query);
	if(!$q0){
		$tab2='<div align="center">
					<img src="../plantilla/img/standard/error.png" alt="no hay actividades"> <spam style="color:red;"> No se pudo cambiar tu avatar, intenta nuevamente e informa al administrador del sistema</span>
				</div>';
	}
	else{
		$_SESSION['persona']['ruta_imagen'] = $ruta;
		$tab2='<div align="center">
								Tu Avatar ha sido cambiado exitosamente! 
								<br>
								<img heigth="50%" src="../'.$ruta.'">
							</div>';
	}
	$litab2='<li class="active"><a href="#sidetab-2" class="1"><img src="../plantilla/img/icons_docente/star.png" alt="rendimiento"> Actualizaci&oacute;n de Datos</a></li>';
	$boton = '<a class="button" href="perfil_ver.php">
							<span class="button-icon"><span class="icon-star"></span></span>
							Nueva Actualizaci&oacute;n 
						</a>';
}
else{
		$tipo = $_SESSION['usuario']['tipo'];
		$query='SELECT ruta_imagen, id_imagen FROM tbl_avatar
				WHERE usuario_tipo="'.$tipo.'" AND usuario_sexo="'.$_SESSION['persona']['sexo'].'"';
		$q0=mysql_query($query);
		if(!$q0) die(mysql_error());
		$tab2='';
		while($qa0=mysql_fetch_assoc($q0)){
			$tab2.='<li>
				<span class="stack rotated-left">
					<img src="../'.$qa0['ruta_imagen'].'" onclick="clickImagen(this)" class="imgavatar" id="'.$qa0['id_imagen'].'">
				</span>
				<input type="radio" name="imagen_seleccionada" value="'.$qa0['id_imagen'].'-'.$qa0['ruta_imagen'].'">
			</li>';
		}
			$litab2='<li><a href="#sidetab-2" class="1"><img src="../plantilla/img/icons_docente/star.png" alt="rendimiento"> Actualizaci&oacute;n de Datos</a></li>';
			$boton='<input type="submit" class="button blue-gradient glossy" value="Actualizar">';
}
//**************** CALCULO DE LA EDAD ****************//
$dia=date(j);$mes=date(n);$ano=date(Y);
//Fecha de nacimiento del Estudiante
list($anonaz,$mesnaz,$dianaz) = explode("-",$_SESSION['persona']['fecha_nacimiento']);
if (($mesnaz == $mes) && ($dianaz > $dia)) $ano=($ano-1);
if ($mesnaz > $mes) $ano=($ano-1);
$edad=($ano-$anonaz);
//************** FIN CALCULO DE LA EDAD ***************// 

/***************************************************************
 *   Informacion del Usuario                                   *
 ***************************************************************/
$query='SELECT *
	FROM sist_usuario AS A, tbl_avatar AS B, tbl_personas_seccion AS C, tbl_seccion AS D,
	tbl_unidadeducativa AS E
        WHERE A.cedula ="'.$_SESSION['persona']['cedula'].'" AND B.id_imagen=A.id_avatar
	AND C.id_persona = A.cedula AND C.id_seccion = D.id_seccion
	AND D.id_colegio = E.id_colegio';
if(!($q1=mysql_query($query))) error(mysql_error());
$datos_usuario = mysql_fetch_assoc($q1);
//**************************************************************/



/*p_js_agregar_texto('
	function clickImagen(obj) {
		var activado=$(obj).css("border")=="solid 2px red";
		$(".imgavatar").css("border","");
		if(activado){
			$(obj).css("border","");
		}else{
			$(obj).css("border","solid 2px red");
		}
	}
');*/

p_contenido('centro','  
<div id="centro">	
	<div id="areaProfesor">
	<h3 class="thin"><span class="info">Mi Perfil </span>'.$datos_estudiante['nombre'].' '.$datos_estudiante['apellido'].'</h3>
		<div class="side-tabs same-height margin-bottom" style="clear:both;">
			<ul class="tabs">
				<li><a href="#sidetab-1" class="1"><img src="../plantilla/img/icons_docente/user_go.png" alt="datos estudiante"> Datos Personales</a></li>
				'.$litab2.'
			</ul>
			<div class="tabs-content">
				<div id="sidetab-1" class="1">
					<div style="margin:20px;">
						<!--<h5>Datos personales del Usuario</h5><br>-->
						<table class="info-usuario">
							<tr>
								<td style="width:70%; padding:10px;">
									<p class="big-message" style="text-align:left;">
											<strong> '.$_SESSION['persona']['cedula'].'</strong></br>
											C&eacute;dula</br></br>
											<strong> '.$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido'].'</strong></br>
											Nombre y Apellido</br></br>
											<strong> '.$_SESSION['persona']['fecha_nacimiento'].'</strong></br>
											Fecha de Nacimiento  </br></br>
											<strong> '.$edad.' años</strong></br>
											Edad </br></br>
											<strong> '.$_SESSION['persona']['sexo'].'</strong></br>
											Sexo </br></br>
											<strong> '.$datos_usuario['nombre_colegio'].'</strong></br>
											Instituto Educativo</br></br>
											<strong> '.$_SESSION['usuario']['tipo'].'</strong></br>
											Tipo de Usuario</br></br>
									</p>
								</td>
								<td style="width:30%;">
										<br><br><br><br><img src="../'.$_SESSION['persona']['ruta_imagen'].'">
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div id="sidetab-2" class="1" style="margin:0 auto; text-align:center;">
					<br><br>
					<h4>Cambiar imagen: </h4>
					<form method="POST" action="#" id="_imagenes">
						<span id="avatares">
						<br>
							<ul class="gallery" id="demo-gallery">
								'.$tab2.'
							</ul>
						</span>
						<br><br>
						'.$boton.'
					</form>
				</div>
			</div>
		</div>
	</div>
    ');

p_js_agregar_texto('');
//p_css_agregar_archivo("../plantilla/css/styles/progress-slider_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/files_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/perfilVer_tatu.css");

p_js_agregar_archivo("plantilla/js/developr.input.js");
p_js_agregar_archivo("plantilla/js/developr.tabs.js");


p_con_shortcuts(true);
p_con_menu(true);

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');

p_con_pizarra(true);
p_contenido('pizarra','Perfil de Usuario');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Perfil');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();  

?>
