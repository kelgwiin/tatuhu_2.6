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

p_contenido('centro','
    <div id="centro">
<div id="cprincipal">
<div class="infoOblig">Los Campos marcados con <span class="obligatorio">*</span> son obligatorios.</div>
<br> 
<div>
<form id="formulario" name="nuevaArea" action="post/nuevaArea.php" enctype="multipart/form-data">
<fieldset class="fieldset">
<legend class="legend">Datos del &Aacute;rea</legend>
<div class="campoForm"> Nombre del &Aacute;rea de Aprendizaje<span class="obligatorio">*</span><br>
<input type="text" name="nombre_area" class="input" id="nombre_area" value="" maxlength="60"><br>
<div id="error-nombre_area" class="msjError"></div>
</div><br>
<table>
    <tr>
        <td>
        Descripci&oacute;n <span class="obligatorio">*</span><br>
        <textarea class="input" name="descripcion" id="descripcion" rows="4" cols="30"></textarea><br>
        <div id="error-descripcion" class="msjError"></div><br>
        </td>
   </tr>
</table>
<br>
    Imagen del &Aacute;rea <span class="obligatorio">*</span><span class="info-spot">
        <span class="icon-info-round"></span>
        <span class="info-bubble">Una imagen que permita a los usuarios identificar f&aacute;cilmente el 
        &aacute;rea. Ejemplo:<br> <img src="../plantilla/img/ejemploIMGAA.png"></span>
        </span><br>
    <input type="file" name="imagen_area" id="imagen" value="" class="file withClearFunctions"><br>
    <div id="error-imagen_area" class="msjError"></div><br>
    <div>La imagen debe ser del tipo PNG y debe tener un tama&ntilde;o m&aacute;ximo de 120KB<br>
         Las dimensi&oacute;n m&iacute;nima permitida es de 250X250px, y m&aacute;xima 400X400px </div>

</fieldset><br>
<fieldset class="fieldset">
<legend class="legend">Relaci&oacute;n con un Grado</legend>
Grado al que pertenece el &aacute;rea <span class="obligatorio">*</span><br>
<select class="select" name="grado" id="grado">'.$opciones_grado.'</select><br>
<div id="error-grado" class="msjError"></div><br>
</fieldset>
<br>
<div align="center">
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
    Registrar &Aacute;rea
</button>
</div>
</form>
</div>
</div>
</div>
');

p_js_agregar_archivo("plantilla/js/libs/jquery.blockUI.min.js");
p_js_agregar_archivo("plantilla/js/developr.modal.js");
p_js_agregar_archivo("plantilla/js/developr.input.js");
p_js_agregar_archivo('plantilla/js/jquery.validate.min.js');
p_js_agregar_archivo('plantilla/js/validator/validator_archivos.js');
p_js_agregar_archivo('plantilla/js/jsUsuarios/nuevaArea.js');

p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");

p_contenido('titulo_grande_1','Crear &Aacute;rea de Aprendizaje');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Crear &Aacute;rea de Aprendizaje</a>');

p_con_pizarra(true);
p_contenido('pizarra','Registro de una nueva &Aacute;rea de Aprendizaje');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
