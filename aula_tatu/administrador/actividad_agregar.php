<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');
//Areas de Aprendizaje
$query= 'SELECT A.id_area,A.area_aprendizaje,A.id_grado, B.grado 
        FROM tbl_areasaprendizaje A, sist_grado B 
        WHERE A.activo="SI" AND A.id_grado=B.id_grado AND B.activo="ACTIVO" ORDER BY id_grado';
$q0 = mysql_query($query); 
$areas = "<option></option>";
 while($qa0=mysql_fetch_assoc($q0)){
     $areas.='<option value="'.$qa0['id_area'].'">'.$qa0['area_aprendizaje'].' ('.$qa0['grado'].')</option>';
}
//Tipos de Materiales - Pedagogia: Lectura
$query= 'SELECT id_tipo, tipo_actividad, nombre_sist FROM sist_actividad WHERE tipo_pedagogia="Juego"';
$q0 = mysql_query($query); 
$tipos = "<option></option>";
 while($qa0=mysql_fetch_assoc($q0)){
     $tipos.='<option value="'.$qa0['id_tipo'].'-'.$qa0['nombre_sist'].'-'.$qa0['tipo_actividad'].'">'.$qa0['tipo_actividad'].'</option>';
}

p_contenido('centro','
    <div id="centro">
<div id="cprincipal">
<div class="infoOblig">Los Campos marcados con <span class="obligatorio">*</span> son obligatorios.</div>
<br> 
<div>
<form id="formulario" name="nuevaActividad" action="">
<fieldset class="fieldset">
<legend class="legend">Datos de la Actividad</legend>
<table>
   <tr> 
   <td>
        Nombre de la Actividad<span class="obligatorio">*</span><br>
        <input type="text" class="input" name="nombre_actividad" id="nombre_actividad" maxlength="60"><br>
        <div id="error-nombre_actividad" class="msjError"></div>
   </td>
    <td>
        Retroalimentaci&oacute;n<span class="obligatorio">*</span><br>
        <textarea class="input" name="retroalimentacion" id="retroalimentacion" rows="4" cols="30"></textarea><br>
        <div id="error-retroalimentacion" class="msjError"></div><br>
        </td>   
   </tr>
   <tr>
    <td>
         Tipo de Actividad <span class="obligatorio">*</span><br>
        <select class="select expandable-list" style="max-width:150px;" id="tipo" name="tipo">
            '.$tipos.'
        </select>
        <br>
        <div id="error-tipo" class="msjError"></div>
    </td>
   </tr>
</table>
</fieldset><br>
<fieldset class="fieldset">
<legend class="legend">Actividad</legend>
<div id="materialTipo">
<div id="tip"><img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Seleccione primero el tipo de Material</div>

</div>
</fieldset>
<fieldset class="fieldset">
<legend class="legend">Relaci&oacute;n con un &Aacute;rea, Componente y Tema</legend>
Seleccione el &aacute;rea de aprendizaje, componente y el tema al que pertenece el material:<br><br>
<div style="display:none" id="cargandoInfo"><img src="../plantilla/img/standard/loaders/loading16.gif"> Cargando, por favor espere...</div>
<table>
    <tr><td>
        &Aacute;rea de Aprendizaje <span class="obligatorio">*</span><br>
        <select class="select expandable-list" style="max-width:150px;" id="area" name="area">'.$areas.'</select>
        <br>
        <div id="error-area" class="msjError"></div>
        </td>
        <td>
        Componente <span class="obligatorio">*</span><br>
        <span id="contComp"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="componente" id="componente" style="width:150px;"></select></span>
        <br>
        <div id="error-componente" class="msjError"></div><br>
        </td>
</table>
        Tema <span class="obligatorio">*</span><br>
        <span id="contTem"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="tema" id="tema" style="width:150px;"></select></span>
        <br>
        <div id="error-tema" class="msjError"></div><br>
</fieldset>
<br>
<div align="center">
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
    Agregar Actividad
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
p_js_agregar_archivo('plantilla/js/jsUsuarios/nuevaActividad.js');

p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");

p_contenido('titulo_grande_1','Crear Actividad');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Crear Actividad</a>');

p_con_pizarra(true);
p_contenido('pizarra','Registro de una nueva Actividad');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
