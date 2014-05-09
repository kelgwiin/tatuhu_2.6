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
<form id="formulario" name="nuevaArea" action="post/nuevoInstituto.php">
<fieldset class="fieldset">
<legend class="legend">Datos del Componente</legend>
<div class="campoForm"> Nombre del Componente<span class="obligatorio">*</span><br>
<input type="text" name="nombre_componente" class="input" id="nombre_componente" value="" maxlength="60"><br>
<div id="error-nombre_componente" class="msjError"></div>
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
     Imagen del Componente<span class="obligatorio">*</span><span class="info-spot">
        <span class="icon-info-round"></span>
        <span class="info-bubble">Una imagen que permita a los usuarios identificar f&aacute;cilmente el 
        componente. Ejemplo:<br> <img src="../plantilla/img/ejemploIMGAA.png"></span>
        </span><br>
    <input type="file" name="imagen_componente" id="imagen" value="" class="file withClearFunctions"><br>
    <div id="error-imagen_componente" class="msjError"></div><br>
    <div>La imagen debe ser del tipo PNG y debe tener un tama&ntilde;o m&aacute;ximo de 120KB<br>
         Las dimensi&oacute;n m&iacute;nima permitida es de 250X250px, y m&aacute;xima 400X400px </div>
</fieldset><br>
<fieldset class="fieldset">
<legend class="legend">Relaci&oacute;n con un &Aacute;rea</legend>
Selecciona el grado y el &aacute;rea de aprendizaje al que pertenece el componente:<br><br>
<div style="display:none" id="cargandoInfo"><img src="../plantilla/img/standard/loaders/loading16.gif"> Cargando, por favor espere...</div>
<table>
    <tr><td>
        Grado <span class="obligatorio">*</span><br>
        <select class="select" name="grado" id="grado"><option></option>'.$opciones_grado.'</select>
        <br>
        <div id="error-grado" class="msjError"></div><br>
        </td>
        <td>
        &Aacute;rea de Aprendizaje <span class="obligatorio">*</span><br>
        <span id="contComp"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="area" id="area" style="width:150px;"></select></span>
        <br>
        <div id="error-area" class="msjError"></div>
        </td>
   </tr>
</table>
</fieldset>
<br>
<div align="center">
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
    Registrar Componente
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
p_js_agregar_archivo('plantilla/js/jsUsuarios/nuevoComponente.js');

p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");

p_contenido('titulo_grande_1','Crear Componente');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Crear Componente</a>');

p_con_pizarra(true);
p_contenido('pizarra','Registro de un nuevo Componente');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

//p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
