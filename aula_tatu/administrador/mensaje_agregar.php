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
<div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> 
Un mensaje de Tatu H&uacute; es una frase que se muestra en 
la interfaz del estudiante y que est&aacute; relacionado con 
<strong>valores y &eacute;tica</strong>. Se cargar&aacute; un mensaje distinto 
cada vez que el estudiante ingrese al aula.
</div><br>
<div class="infoOblig">Los Campos marcados con <span class="obligatorio">*</span> son obligatorios.</div>
<br> 
<div>
<form id="formulario" name="nuevaArea" action="post/nuevoMensaje.php" enctype="multipart/form-data">
<fieldset class="fieldset">
<legend class="legend">Datos del Mensaje</legend>
<div class="campoForm"> Mensaje<span class="obligatorio">*</span><br>
<textarea class="input" name="mensaje" id="mensaje" rows="4" cols="30"></textarea><br>
<div id="error-mensaje" class="msjError"></div>
</fieldset><br>
<div align="center">
<button type="submit" class="button glossy">
<span class="button-icon"><span class="icon-tick"></span></span>
    Agregar Mensaje
</button>
</div>
</form>
</div>

</div>

');

p_js_agregar_archivo("plantilla/js/libs/jquery.blockUI.min.js");
p_js_agregar_archivo("plantilla/js/developr.modal.js");
p_js_agregar_archivo("plantilla/js/developr.input.js");
p_js_agregar_archivo('plantilla/js/jquery.validate.min.js');
p_js_agregar_archivo('plantilla/js/validator/validator_archivos.js');

p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");

p_js_agregar_texto('
$("#formulario").validate({ //reglas de validacion del formulario - jquery validate
    rules:{ mensaje: { required:true},},
    messages:{mensaje: {required: "Debe ingresar un mensaje" },},
    errorPlacement: 
    function(error, element) {error.appendTo("#error-" + element.attr("name"));},
    submitHandler: function(){
    $.blockUI({ message: \'<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando el mensaje, por favor espere...</h4>\' });
    $.ajax({
    type: "POST",
    url: "post/nuevoMensaje.php",
    data: $("form").serialize(),
    success: function(data){
            $.unblockUI();
            $.modal.alert(
            data,
                {buttons: {
                        \'Cerrar\':{classes :\'blue-gradient glossy big full-width\', click:function(modal) { 
                                modal.closeModal(); 
                                if (data.indexOf("<img src=\'../plantilla/img/standard/error.png\'>") === -1)
                                    window.location.reload(); 
                            }}}
                ,width:300,resizable:false});
              }
            });
        }
    });
');

p_contenido('titulo_grande_1','Crear Mensaje Tatu H&uacute;');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Crear Mensaje Tatu H&uacute;</a>');

p_con_pizarra(true);
p_contenido('pizarra','Registro de un nuevo mensaje de Tatu H&uacute;');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
