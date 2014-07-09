<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');
// Construccion de las opciones GRADO
$query='SELECT * FROM sist_grado WHERE activo="ACTIVO"';
$q0=mysql_query($query);
if(!$q0) die(mysql_error());
while($qa0=mysql_fetch_assoc($q0)){
        $opciones_grado.='<option value="'.$qa0['id_grado'].'" title="'.$qa0['grado'].'">'.$qa0['grado'].'</option>';		
}
//Construccion de las opciones ESCUELAS
$query='SELECT id_colegio,nombre_colegio FROM tbl_unidadeducativa WHERE activo="ACTIVO"';
$q0=mysql_query($query);
if(!$q0) die(mysql_error());
while($qa0=mysql_fetch_assoc($q0)){
    if ($_POST['id_escuela']==$qa0['id_colegio']) {
        $opciones_planteles.='<option value="'.$qa0['id_colegio'].'" selected="selected">'.$qa0['nombre_colegio'].'</option>';
    }else{
        $opciones_planteles.='<option value="'.$qa0['id_colegio'].'">'.$qa0['nombre_colegio'].'</option>';
    }
}
  
//*****************Consulta de datos de usuario a modificar**********************
$query='SELECT A.*, DATE_FORMAT(fecha_nacimiento,"%d %m %Y") AS fecha FROM tbl_personas A WHERE cedula="'.$_GET['id'].'"';
$q0=mysql_query($query);
if(!$q0) die(mysql_error());
$qa0=mysql_fetch_assoc($q0);
if($qa0['sexo']=="FEMENINO") $select_f="selected=selected";
if($qa0['sexo']=="MASCULINO") $select_m="selected=selected";

p_contenido('centro','
<div id="centro"> 
<div>
<div class="infoOblig">Los Campos marcados con <span class="obligatorio">*</span> son obligatorios.</div>
<br>    
<form method="POST" method="POST" action="#">
	<fieldset class="fieldset">
		<legend class="legend">Datos Personales</legend>
		<div>C&eacute;dula <span class="obligatorio">*</span><br>
			<!--<input type="text" name="cedula" class="input" value="'.$qa0['cedula'].'"><br>-->
			<strong>'.$qa0['cedula'].'</strong>
		</div>
<table>
    <tr>
		<td>Nombre <span class="obligatorio">*</span><br>
		   <input type="text" id="nombre" name="nombre" class="input" value="'.$qa0['nombre'].'"><br>
		   <div id="error-nombre" class="msjError"></div>
		</td>
		<td>Apellido <span class="obligatorio">*</span><br>
			<input type="text" name="apellido" class="input" value="'.$qa0['apellido'].'"><br>
			<div id="error-apellido" class="msjError"></div>
		</td><br>
	</tr>
	<tr>
		<td>Fecha de Nacimiento <span class="obligatorio">*</span><br>
			<input type="text" name="fecha_nacimiento" class="input" id="fnac_id" value="'.$qa0['fecha'].'">
			 <div id="error-fecha_nacimiento" class="msjError"></div>
		</td>
		<td colspan="2" align="center">
			Sexo <span class="obligatorio">*</span><br>
			<select name="sexo" class="select">
				<option value="FEMENINO" '.$select_f.'>Femenino</option>
				<option value="MASCULINO" '.$select_m.'>Masculino</option>
			</select><br>
			<div id="error-sexo" class="msjError"></div>
		</td>
	</tr>
	<tr>
		<td>Tel&eacute;fono<br>
			<input type="text" name="telefono" class="input" id="" value="'.$qa0['telefono'].'">
			<br>
			<div id="error-telefono" class="msjError"></div>
		</td>
		<td>Correo<br>
			<input type="text" name="correo" class="input" value="'.$qa0['correo'].'">
			<br>
			<div id="error-correo" class="msjError"></div>
		</td>
	</tr>
</table>
</fieldset>
<fieldset class="fieldset">
    <legend class="legend">Datos de la Cuenta</legend>
    <table>
    <tr>
    <td>Nombre de Usuario <span class="obligatorio">*</span><br>
     <input type="text" id="nick" name="usuario" class="input" value=""><br>
     <div id="error-usuario" class="msjError"></div>
     </td>
    <td>Tipo de Usuario <span class="obligatorio">*</span><br>
     <select name="tipo" class="select" id="tipo_id">
       <option value=""></option>                                            
       <option value="ADMINISTRADOR">Administrador de Sistema</option>                                            
       <option value="ADMINISTRADOR DE ESCUELA">Administrador de Escuela</option>
       <option value="PROFESOR">Docente</option>                                            
       <option value="ESTUDIANTE">Estudiante</option>
    </select><br>
    <label id="error-tipo" class="error"></label>
    </td><br>
    </tr>
    </table>
</fieldset>
<fieldset id="datos-educativos" style="display:none;" class="fieldset">
<legend class="legend">Datos Educativos</legend>
    <table>
    <tr id="escuela" style="display:none;"><td >
        Instituto Educativo <span class="obligatorio">*</span><br>
        <select name="id_escuela" class="select expandable-list" id="escuelaE" style="max-width:300px;">
                <option value=""></option>'.$opciones_planteles.'
        </select><br><label id="error-escuela" class="error"></label>
    </td><td id="gradosE">
            Grado y Secci&oacute;n <span class="obligatorio">*</span><br>
            <div id="lista_grados"><select name="grado" class="select" id="gradoE" disabled></select></div>
    </td></tr>
    <tr id="seccion" style="display:none;"><td>
        <div id="seccionesE"></div>
    </td></tr>
    </table>
<div id="seccionesProf"  style=" display:none;"></div>
<div style="display:none" id="cargandoInfo"><img src="../plantilla/img/standard/loaders/loading16.gif"> Cargando, por favor espere...</div>
</fieldset>
<br>
<div align="center">
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
Actualizar Usuario
</button>
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
Eliminar Usuario
</button>
<button type="button" class="button glossy" href = "usuario_visualizar.php">
<span class="button-icon red-gradiente"><span class="icon-tick"></span></span>
Cancelar
</button>
</div>
<br><br>
</form>
</div>
</div>
');

p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");
p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_js_agregar_archivo("plantilla/js/libs/jquery.blockUI.min.js");

p_js_agregar_archivo("plantilla/js/developr.input.js");
p_js_agregar_archivo("plantilla/js/jquery.validate.min.js"); 
p_js_agregar_archivo('plantilla/js/libs/jquery.maskedinput.min.js');       
p_js_agregar_archivo("plantilla/js/validator/validator_datos.js");   
p_js_agregar_archivo("plantilla/js/developr.modal.js");
p_js_agregar_archivo("plantilla/js/jsUsuarios/nuevoUsuario.js");    
            
p_js_agregar_texto("
//select de grados como variable global
var grados = '".$opciones_grado."';
//select de escuelas
var escuelas = '<option></option>".$opciones_planteles."'
");

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Modificaci&oacute;n de Usuario');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Modificaci&oacute;n de Usuario</a>');

p_con_pizarra(true);
p_contenido('pizarra','Actualizaci&oacute;n de un Usuario');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
?>
