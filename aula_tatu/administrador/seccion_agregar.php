<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');
$query='SELECT * FROM sist_grado WHERE activo="ACTIVO"';
$q0=mysql_query($query);
if(!$q0) die(mysql_error());
while($qa0=mysql_fetch_assoc($q0)){
        $opciones_grado.='<option value="'.$qa0['id_grado'].'" title="'.$qa0['grado'].'">'.$qa0['grado'].'</option>';		
}

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

p_contenido('centro','
<div id="centro"> 
<div>
<div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> 
Al crear una nueva secci&oacute;n se le asignar&aacute; al docente seleccionado.<br>
Cada docente puede tener un <strong>m&aacute;ximo de 3 secciones</strong>.
</div><br>
<div class="infoOblig">Los Campos marcados con <span class="obligatorio">*</span> son obligatorios.</div>
<br>    
<form method="POST" id="formulario" name="nuevoUser" method="POST" action="#">
<fieldset class="fieldset">
<legend class="legend">Datos de la Secci&oacute;n</legend>
<br>
<div style="display:none" id="cargandoInfo"><img src="../plantilla/img/standard/loaders/loading16.gif"> Cargando, por favor espere...</div>
<table>
        <tr>
            <td class="campoCompleto">
            <div class="campoForm">C&eacute;dula del Docente <span class="obligatorio">*</span><br>
            <input type="text" name="cedula" class="input" id="cedula_id" value=""><br>
            <div id="error-cedula" class="msjError"></div>
            </div>
            </td>
            <td>
            Instituto Educativo <span class="obligatorio">*</span><br>
            <select name="id_escuela" class="select expandable-list" id="escuelaE" style="max-width:150px;">
                    <option value=""></option>'.$opciones_planteles.'
            </select><br><label id="error-escuela" class="error"></label>
            </td><br>
        </tr>
        <tr>
            <td id="gradosE">
                Grado <span class="obligatorio">*</span><br>
                <div id="lista_grados"><select name="grado" class="select" id="gradoE" disabled></select></div>
                <label id="error-grado" class="error"></label>
            </td>
            <td>
                Nombre de la Secci&oacute;n<span class="obligatorio">*</span><br>
                <span id="nombreSecc"><select class="select disabled"></select></span>
               <br> <label id="error-seccion" class="error"></label>
            </td>
        </tr>
</table>
</fieldset>
<br>
<div align="center">
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
Agregar Secci&oacute;n
</button>
</div>
<br><br>
</form>
</div>
</div>
');

p_js_agregar_texto("
//select de grados como variable global
var grados = '".$opciones_grado."';
");

p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");
p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_js_agregar_archivo("plantilla/js/libs/jquery.blockUI.min.js");

p_js_agregar_archivo("plantilla/js/developr.input.js");
p_js_agregar_archivo("plantilla/js/jquery.validate.min.js"); 
p_js_agregar_archivo('plantilla/js/libs/jquery.maskedinput.min.js');       
p_js_agregar_archivo("plantilla/js/validator/validator_datos.js");   
p_js_agregar_archivo("plantilla/js/developr.modal.js");
p_js_agregar_archivo("plantilla/js/jsUsuarios/nuevaSeccion.js");    
            
p_js_agregar_texto("
//select de grados como variable global
var grados = '".$opciones_grado."';
//select de escuelas
var escuelas = '<option></option>".$opciones_planteles."'
");

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Crear Secci&oacute;n');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Crear Secci&oacute;n</a>');
p_con_pizarra(true);
p_contenido('pizarra','Registro de una nueva Secci&oacute;n');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();   

?>