<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');	
$query="SELECT * FROM sist_int_mensajesvalores";
$qa0=mysql_query($query);
if (!$qa0) die(mysql_error());
$num=mysql_num_rows($qa0);

$contenido_centro='
<div id="centro">
    <div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede seleccionar un Mensaje para ver y modificar su informaci&oacute;n<br>
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede eliminar un Mensaje haciendo clic en "Eliminar"
</div><br>
    <div id="contenido">
            <table class="table responsive-table listado" id="tabla">
                    <thead>
                    <tr>
                            <th scope="col">Mensaje</th>
                            <th scope="col">Eliminar</th>
                    </tr>
                    </thead>
                    <tfoot><tr>
                         <td colspan="7" align="center"><b>'.$num.'</b> Mensajes en Total</td>
                     </tr> </tfoot>
                    <tbody>';
      while(($msj=mysql_fetch_assoc($qa0))!=false){
            $contenido_centro.='
            <tr>
                    <td class="area" id="'.$msj["id"].'-'.$msj["mensaje"].'">'.$msj["mensaje"].'</td>
                    <td><a class="eliminar" id="'.$msj["id"].'">Eliminar</a></td>
            </tr>';
      }

    $contenido_centro.='
                    </tbody>
            </table>
    </div></div>              
';

p_css_agregar_archivo("../plantilla/css/styles/table_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/tablas_tatu.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/switches_59edcbff.css");
p_css_agregar_archivo("../plantilla/js/libs/DataTables/jquery.dataTables.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/formularios_tatu.css");

p_js_agregar_archivo("plantilla/js/libs/jquery.blockUI.min.js");
p_js_agregar_archivo("plantilla/js/developr.input.js");
p_js_agregar_archivo("plantilla/js/developr.table.js");
p_js_agregar_archivo("plantilla/js/libs/jquery.tablesorter.min.js");
p_js_agregar_archivo("plantilla/js/libs/DataTables/jquery.dataTables.min.js");
p_js_agregar_archivo("plantilla/js/developr.modal.js");
p_js_agregar_archivo("plantilla/js/jsUsuarios/verMensajes.js");

p_contenido('centro',$contenido_centro);

p_contenido('titulo_grande_1','Ver y Modificar Mensajes');

p_con_pizarra(true);
p_contenido('pizarra','Seleccione el Mensaje a visualizar/modificar');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Ver y Modificar Mensajes</a>');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');

p_dibujar();

?>