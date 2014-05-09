<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');	
$query="SELECT codigo_colegio, nombre_colegio,tipo,activo FROM tbl_unidadeducativa";
$qa0=mysql_query($query);
if (!$qa0) die(mysql_error());
$_num_institutos=mysql_num_rows($qa0);

$contenido_centro='
<div id="centro">
    <div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede seleccionar un instituto para ver y modificar su informaci&oacute;n<br>
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede desactivar un instituto haciendo clic en el switch correspondiente en "Estatus"
</div><br>
    <div id="contenido">
            <table class="table responsive-table listado" id="tabla">
                    <thead>
                    <tr>
                            <th scope="col">C&oacute;digo SINACOE</th>
                            <th scope="col">Nombre del Instituto</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Estatus</th>
                    </tr>
                    </thead>
                    <tfoot><tr>
                         <td colspan="7" align="center"><b>'.$_num_institutos.'</b> Institutos en Total</td>
                     </tr> </tfoot>
                    <tbody>';
      while(($instituto=mysql_fetch_assoc($qa0))!=false){
                    $contenido_centro.='
                    <tr>
                            <td class="instituto" id="'.$instituto["codigo_colegio"].'">'.$instituto["codigo_colegio"].'</td>
                            <td class="instituto" id="'.$instituto["codigo_colegio"].'">'.$instituto["nombre_colegio"].'</td>
                            <td class="instituto" id="'.$instituto["codigo_colegio"].'">'.$instituto["tipo"].'</td>
                            <td>
                            <input type="checkbox" name="act_des" id="'.$instituto["codigo_colegio"].'/'.$instituto["nombre_colegio"].'" class="switch medium mid-margin-left replacement with-tooltip tooltip-right" 
                                value="'.(($instituto["activo"]=='ACTIVO')?'1':'0').'title="Tooltip on the right"" 
                            '.(($instituto["activo"]=='ACTIVO')?'checked':'').' data-text-on="Activo" data-text-off="Inactivo" title="Haz click para '.(($instituto["activo"]=='ACTIVO')?'desactivar':'activar').' al Instituto">
                            </td>
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
p_js_agregar_archivo("plantilla/js/jsUsuarios/verInstitutos.js");

p_contenido('centro',$contenido_centro);

p_contenido('titulo_grande_1','Ver y Modificar Institutos');

p_con_pizarra(true);
p_contenido('pizarra','Seleccione el Instituto a visualizar/modificar');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Ver y Modificar Institutos</a>');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');

p_dibujar();

?>