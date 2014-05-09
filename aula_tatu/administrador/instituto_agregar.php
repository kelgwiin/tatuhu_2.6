<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');

$queryEst= 'SELECT id_estado, estado FROM sist_estado WHERE 1';
$qEst = mysql_query($queryEst); 
$estados = "<option></option>";
 while($qa0=mysql_fetch_assoc($qEst)){
     $estados.='<option value="'.$qa0['id_estado'].'">'.$qa0['estado'].'</option>';
}

p_contenido('centro','
    <div id="centro">
<div id="cprincipal">
<div class="infoOblig">Los Campos marcados con <span class="obligatorio">*</span> son obligatorios.</div>
<br> 
<div>
<form id="formulario" name="nuevoInst" action="post/nuevoInstituto.php">
<fieldset class="fieldset">
<legend class="legend">Datos del Instituto</legend>
<table>
    <tr><td>
        C&oacute;digo SINACOE <span class="obligatorio">*</span>
        <span class="info-spot">
        <span class="icon-info-round"></span>
        <span class="info-bubble">Es el C&oacute;digo de Representaci&oacute;n del Instituto</span>
        </span>
        <br>
        <input type="text" name="codigo_colegio" required maxlength="10" class="input" id="codigo_colegio" value="">
        <br>
        <div id="error-codigo_colegio" class="msjError"></div>
        </td>
        <td>
        Nombre del Instituto <span class="obligatorio">*</span><br>
        <input type="text" name="nombre_colegio" required class="input" id="nombre_colegio" value="">
        <br>
        <div id="error-nombre_colegio" class="msjError"></div>
        </td>
    <td>  
    Tipo <span class="obligatorio">*</span><br><select name="tipo" class="select">
        <label>Tipo</label>
        <option name="tipo" value="0">B&aacute;sica Media</option>
        <option name="tipo" value="1">B&aacute;sica Alta</option>
        <option name="tipo" value="2">Bachillerato</option>
        <option name="tipo" value="3">Otro</option>
    </select>
</td></tr>
</table>
</fieldset><br>
<fieldset class="fieldset">
<legend class="legend">Direcci&oacute;n del Instituto</legend><br>
<div style="display:none" id="cargandoInfo"><img src="../plantilla/img/standard/loaders/loading16.gif"> Cargando, por favor espere...</div>
<table>
    <tr>
        <td>Estado <span class="obligatorio">*</span></label><br>
        <select style="width:150px;" name="estado" class="select validate[required]" id="estado">
        '. $estados.'</select>
        </td>
        <td>Municipio <span class="obligatorio">*</span><br>
        <div id="sel1">
            <select class="select expandable-list replacement fixedWidth select-styled-list tracked" disabled style="width:150px"></select>
        </div>
        </td>
        <td>Parroquia <span class="obligatorio">*</span><br>
            <div id="sel2">
            <select class="select" disabled style="width:150px !important;">
            </select>
         </div>
        </td>
    </tr>

</table>
<label id="error-dir" class="error" style="margin-top:-15px"></label>
<br>
<table>
    <tr><td>Direcci&oacute;n<br>
    <textarea id="direccion" name="direccion" class="input" rows="4" cols="50"></textarea>
     </td>
    </tr>
</table>
<br>
</fieldset>
<fieldset class="fieldset">
<legend class="legend">Datos de Contacto </legend>
<table>
    <tr>
        <td style="max-width:150px;">
            Tel&eacute;fono<br>
            <input type="text" name="telefono" id="telefono" class="input" style="width:100px;">
            <br>
            <div id="error-telefono" class="msjError" style="max-width:150px;"></div>
        </td>
        <td>
            Correo<br>
            <input type="text" name="correo" id="correo" class="input">
            <br>
            <div id="error-correo" class="msjError"></div>
        </td>
        <td>
            Persona de Contacto<br>
            <input type="text" name="nombre_contacto" id="persona" class="input">
           <br>
            <div id="error-nombre_contacto" class="msjError"></div>
            </td>
        </td>
    </tr>
</table>
</fieldset>
<br>
<div align="center">
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
    Registrar Colegio
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
p_js_agregar_archivo('plantilla/js/libs/jquery.maskedinput.min.js');
p_js_agregar_archivo('plantilla/js/jsUsuarios/utilsForm.js');
p_js_agregar_archivo('plantilla/js/validator/validator_instituto.js');
p_js_agregar_archivo('plantilla/js/jsUsuarios/nuevoInstituto.js');

p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Crear Instituto Educativo');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Crear Instituto</a>');

p_con_pizarra(true);
p_contenido('pizarra','Registro de un nuevo Instituto Educativo');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
