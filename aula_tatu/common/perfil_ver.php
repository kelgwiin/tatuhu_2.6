<?php
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

/***************************************************************
 *   Cantidad de actividades completadas por el estudiante      *
 ***************************************************************/
/*$query = 'SELECT COUNT(A.id_actividad)
            FROM tbl_persona_actividad AS A
            WHERE A.id_persona ="'.$_GET['id'].'" AND A.completada = "SI"';
if(!($q1=mysql_query($query))) error(mysql_error());
$cant_actEst = mysql_fetch_assoc($q1);*/

p_js_agregar_texto('
	function clickImagen(obj) {
		var activado=$(obj).css("border")=="solid 2px red";
		
		$(".imgavatar").css("border","");
		if(activado){
			$(obj).css("border","");
		}else{
			$(obj).css("border","solid 2px red");
		}
	}
');
//Usando las mismas imagenes para administrador y profesor
if ($_SESSION['usuario']['tipo'] == "ADMINISTRADOR" || $_SESSION['usuario']['tipo'] == "PROFESOR")
    $tipo = "PROFESOR";
$query='SELECT ruta_imagen, id_imagen FROM tbl_avatar
		WHERE usuario_tipo="'.$tipo.'" AND usuario_sexo="'.$_SESSION['persona']['sexo'].'"';
$q0=mysql_query($query);
if(!$q0) die(mysql_error());
$imagenes='';
while($qa0=mysql_fetch_assoc($q0)){
	$imagenes.='<li>
		<span class="stack rotated-left">
			<img src="../'.$qa0['ruta_imagen'].'" onclick="clickImagen(this)" class="imgavatar">
		</span>
	</li>';
}

p_contenido('centro','  
<div id="centro">	
<div id="areaProfesor">
<h3 class="thin"><span class="info">Datos de Perfil </span>'.$datos_estudiante['nombre'].' '.$datos_estudiante['apellido'].'</h3>
<div class="side-tabs same-height margin-bottom" style="clear:both;">
<ul class="tabs">
<li><a href="#sidetab-1" class="1"><img src="../plantilla/img/icons_docente/user_go.png" alt="datos estudiante"> Datos Personales</a></li>
<li><a href="#sidetab-2" class="1"><img src="../plantilla/img/icons_docente/award_star_gold_3.png" alt="rendimiento"> Rendimiento General</a></li>
<li><a href="#sidetab-3" class="1"><img src="../plantilla/img/icons_docente/star.png" alt="rendimiento"> Actualizaci&oacute;n de Datos</a></li>
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
                                        <strong> '.$_SESSION['persona']['edad'].'</strong></br>
                                        Edad </br></br>
                                        <strong> '.$_SESSION['persona']['sexo'].'</strong></br>
                                        Sexo </br></br>
                                        <strong> '.$datos_usuario['nombre_colegio'].'</strong></br>
                                        Instituto Educativo</br></br>
                                        <strong> '.$_SESSION['usuario']['tipo'].'</strong></br>
                                        Tipo de Usuario</br></br>
                                </p><br>
                                </td>
                                <td style="width:30%;">
                                        <img src="../'.$_SESSION['persona']['ruta_imagen'].'">
                                </td>
                        </tr>
                </table>
        </div>
</div>
<div id="sidetab-2" class="1">
        <div style="margin:20px;">
                <p>
                        Rendimiento General del Estudiante
                        <span class="info-spot">
                                <span class="icon-info-round"></span>
                                <span class="info-bubble">
                                                Este rendimiento representa una comparaci&oacute;n entre el n&uacute;mero
                                                de actividades que ha realizado el estudiante y la cantidad total de
                                                actividades que hay en su grado.
                                </span>
                        </span>
                </p>
                <br><br>
                <p><span class="demo-progress" data-progress-options=\'{"size":false,"barClasses":["blue-gradient","glossy"],"innerMarks":25,"topMarks":25,"topLabel":"[value]%","bottomMarks":[{"value":0,"label":"Ninguno"},{"value":25,"label":"Minimo"},{"value":50,"label":"Medio"},{"value":75,"label":"Bien"},{"value":100,"label":"Excelente"}],"insetExtremes":true}\'>'.$porc.'%</span>
                </p>
                <br><br>
                <p>Has realizado <span class="tip">'.$cant_actEst["COUNT(A.id_actividad)"].'</span> actividades de
                un total de <span class="tip">'.$cant_actSist["COUNT(A.id_actividad)"].'</span>. 
                </p>
        </div>
</div>
<div id="sidetab-3" class="1">
        <h5>Actualizacion de Usuario: </h5>

<script>
function show_hide_card(which) {

   $(".act_usr_btn").removeClass("active");
   if (which=="datos_personales") {
      $("#avatares").hide();
      $("#fieldset_datospersonales").fadeIn();
      $(".act_usr_btn_dp").addClass("active");
   }

   if (which=="imagen_perfil") {
      $("#fieldset_datospersonales").hide();
      $("#avatares").fadeIn();
      $(".act_usr_btn_ip").addClass("active");
   }


}
</script>
        <span class="button-group" style="margin:0 auto;">
                <a class="act_usr_btn act_usr_btn_dp button icon-card" href="javascript:show_hide_card(\'datos_personales\')">Datos Personales</a>
                <a class="act_usr_btn act_usr_btn_ip button icon-pictures" href="javascript:show_hide_card(\'imagen_perfil\')">Imagen de Perfil</a>
                <a class="act_usr_btn act_usr_btn_dc button icon-user" href="javascript:show_hide_card(\'datos_cuenta\')">Datos de la cuenta</a>
        </span>
        <!--<p class="wrapped button-height">
                Cambiar el tamaño: <span id="gallery-slider"></span>
        </p>-->
        <br><br>
<span id="fieldset_datospersonales" style="display:none;">
        <fieldset class="fieldset perfil">
<!-- <legend class="legend">Datos Personales</legend> -->
<table class="datos-perfil">
                        <tr>
<td>Nombre<br><input type="text" name="nombre" class="input" value="'.$_POST['nombre'].'"></td>
<td>Apellido<br><input type="text" name="apellido" class="input" value="'.$_POST['apellido'].'"></td>
</tr>
                        <tr>
<td>Edad<br><input type="text" name="edad" class="input" id="edad_id" value="'.$_POST['edad'].'"></td>
<td>Fecha de Nacimiento<br><input type="text" name="fecha_nacimiento" class="input" id="fnac_id" value="'.$_POST['fecha_nacimiento'].'"></td>
                        </tr>
                        <tr>
<td>Tel&eacute;fono<br><input type="text" name="telefono" class="input" id="tlf_id" value="'.$_POST['telefono'].'"></td>
<td>Correo<br><input type="text" name="correo" class="input" value="'.$_POST['correo'].'"></td>
                        </tr>
                        <tr>
<td colspan="2" align="center">
'.(isset($error['sexo'])?'<span style="color: red;">'.$error['sexo'].'</span><br>':'').'Sexo<br>
<select name="sexo" class="select">
<option name="sexo" value="FEMENINO"'.($_SESSION['persona']['sexo']=='FEMENINO'?' selected="selected"':'').'>FEMENINO</option>
<option name="sexo" value="MASCULINO"'.($_SESSION['persona']['sexo']=='MASCULINO'?' selected="selected"':'').'>MASCULINO</option>
</select>
</td>
                        </tr>                                        
                </table>
        </fieldset>
</span>

        <span id="avatares" style="display:none;">
        <br>
        <ul class="gallery" id="demo-gallery">
                '.$imagenes.'
        </ul>
        </span>
<br>
        <a class="button" href="javascript:void(0)">
                <span class="button-icon">
                        <span class="icon-star"></span>
                </span>
                Actualizar
        </a>

        Actualizaci&oacute;n de Clave

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

?>
