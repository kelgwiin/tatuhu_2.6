<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');	
$query="SELECT A.*,B.nombre_colegio,C.grado,D.nombre,D.apellido 
        FROM tbl_seccion A, tbl_unidadeducativa B, sist_grado C, tbl_personas D, tbl_personas_seccion E,
        sist_usuario F
        WHERE A.id_colegio=B.id_colegio AND A.id_grado=C.id_grado AND E.id_seccion=A.id_seccion AND 
        E.id_persona=D.cedula AND D.cedula=F.cedula AND F.tipo='PROFESOR'";
$qa0=mysql_query($query);
if (!$qa0) die(mysql_error());
$num_seccion=mysql_num_rows($qa0);

$contenido_centro='
<div id="centro">
    <div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede seleccionar una Secci&oacute;n para ver y modificar su informaci&oacute;n<br>
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede desactivar una Secci&oacute;n haciendo clic en el switch correspondiente en "Estatus"
</div><br>
    <div id="contenido">
            <table class="table responsive-table listado" id="tabla">
                    <thead>
                    <tr>
                            <th scope="col">Seccion</th>
                            <th scope="col">Grado</th>
                            <th scope="col">Colegio</th>
                            <th scope="col">Docente</th>
                            <th scope="col">Estatus</th>
                    </tr>
                    </thead>
                    <tfoot><tr>
                         <td colspan="7" align="center"><b>'.$num_seccion.'</b> Secciones en Total</td>
                     </tr> </tfoot>
                    <tbody>';
      while(($seccion=mysql_fetch_assoc($qa0))!=false){
                    $contenido_centro.='
                    <tr>
                            <td class="seccion" id="'.$seccion["id_seccion"].'">'.$seccion["grado"].'-'.$seccion["seccion"].'</td>
                            <td class="seccion" id="'.$seccion["id_seccion"].'">'.$seccion["seccion"].'</td>
                            <td class="seccion" id="'.$seccion["id_seccion"].'">'.$seccion["nombre_colegio"].'</td>
                            <td class="seccion" id="'.$seccion["id_seccion"].'">'.$seccion["nombre"].' '.$seccion["apellido"].'</td>
                            <td>
                            <input type="checkbox" name="act_des" id="'.$seccion["id_seccion"].'/'.$seccion["grado"].'-'.$seccion["seccion"].'/'.$seccion["nombre_colegio"].'" class="switch medium mid-margin-left replacement with-tooltip tooltip-right" 
                                value="'.(($seccion["activa"]=='SI')?'1':'0').'title="Tooltip on the right"" 
                            '.(($seccion["activa"]=='SI')?'checked':'').' data-text-on="Activo" data-text-off="Inactivo" title="Haz click para '.(($seccion["activa"]=='SI')?'desactivar':'activar').' la Secci&oacute;n">
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
p_js_agregar_archivo("plantilla/js/jsUsuarios/verSecciones.js");

p_contenido('centro',$contenido_centro);

p_contenido('titulo_grande_1','Ver y Modificar Secciones');

p_con_pizarra(true);
p_contenido('pizarra','Seleccione la Secci&oacute;n a visualizar/modificar');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Ver y Modificar Secciones</a>');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');

p_dibujar();

?>
