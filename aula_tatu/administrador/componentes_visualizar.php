<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');	
$query="SELECT A.*, C.grado, B.area_aprendizaje FROM tbl_componente A, tbl_areasaprendizaje B, sist_grado C 
        WHERE A.id_area = B.id_area AND A.id_grado=C.id_grado";
$qa0=mysql_query($query);
if (!$qa0) die(mysql_error());
$num_grados=mysql_num_rows($qa0);

$contenido_centro='
<div id="centro">
    <div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede seleccionar un Componente para ver y modificar su informaci&oacute;n<br>
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede desactivar un Componente haciendo clic en el switch correspondiente en "Estatus"
</div><br>
    <div id="contenido">
            <table class="table responsive-table listado" id="tabla">
                    <thead>
                    <tr>
                            <th scope="col">Componente</th>
                            <th scope="col">&Aacute;rea de Aprendizaje</th>
                            <th scope="col">Grado/A&ntilde;o</th>
                            <th scope="col">Estatus</th>
                    </tr>
                    </thead>
                    <tfoot><tr>
                         <td colspan="7" align="center"><b>'.$num_grados.'</b> Componentes en Total</td>
                     </tr> </tfoot>
                    <tbody>';
      while(($areas=mysql_fetch_assoc($qa0))!=false){
                    $contenido_centro.='
                    <tr>
                            <td class="area" id="'.$areas["id_componente"].'">'.$areas["componente"].'</td>
                            <td class="area" id="'.$areas["id_componente"].'">'.$areas["area_aprendizaje"].'</td>
                            <td class="area" id="'.$areas["id_componente"].'">'.$areas["grado"].'</td>
                            <td>
                            <input type="checkbox" name="act_des" id="'.$areas["id_componente"].'/'.$areas["componente"].'" class="switch medium mid-margin-left replacement with-tooltip tooltip-right" 
                                value="'.(($areas["activo"]=='SI')?'1':'0').'title="Tooltip on$areas["id_area"] the right"" 
                            '.(($areas["activo"]=='SI')?'checked':'').' data-text-on="Activo" data-text-off="Inactivo" title="Haz click para '.(($areas["activo"]=='SI')?'desactivar':'activar').' el Componente">
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
p_js_agregar_archivo("plantilla/js/jsUsuarios/verComponentes.js");

p_contenido('centro',$contenido_centro);

p_contenido('titulo_grande_1','Ver y Modificar Componentes');

p_con_pizarra(true);
p_contenido('pizarra','Seleccione el Componente a visualizar/modificar');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Ver y Modificar Componentes</a>');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');

p_dibujar();

?>