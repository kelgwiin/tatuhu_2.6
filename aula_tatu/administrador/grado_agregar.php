<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');

p_contenido('centro','
    <div id="centro">
<div id="cprincipal">
<div class="infoOblig">Los Campos marcados con <span class="obligatorio">*</span> son obligatorios.<br><br>
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> El grado/a&ntilde;o debe ser desde "1" (1mer Grado) hasta "11" (5to A&ntilde;o)
</div>
<br> 
<div>
<form id="formulario" name="nuevoInst" action="post/nuevoGrado.php">
<fieldset class="fieldset">
<legend class="legend">Datos del Grado</legend>
<table>
    <tr><td>
        Grado <span class="obligatorio">*</span>
        <br>
        <p class="button-height">
        <span class="number input margin-right">
                <button type="button" id="down" class="button">-</button>
                <input type="text" name="grado" id="grado" value="1" size="2" class="input-unstyled" style="text-align:center;">
                <button type="button" id="up" class="button">+</button>
        </span>
        <div id="nombreGrado">1mer Grado</div>
        </p>
        <div id="error-grado" class="msjError"></div>
        </td>
        </tr>
</table>
</fieldset>
<br>
<div align="center">
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
    Registrar Grado
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
p_js_agregar_archivo('plantilla/js/jsUsuarios/nuevoGrado.js');

p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Crear Grado/A&ntilde;o');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Crear Grado/A&ntilde;o</a>');

p_con_pizarra(true);
p_contenido('pizarra','Registro de un nuevo Grado/A&ntilde;o');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
