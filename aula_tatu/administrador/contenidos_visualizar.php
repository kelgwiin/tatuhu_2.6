<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');	
$query="SELECT A.*, B.area_aprendizaje, C.componente, D.grado
        FROM tbl_contenido A, tbl_componente C, tbl_areasaprendizaje B, sist_grado D
        WHERE A.id_componente=C.id_componente AND A.id_area= B.id_area AND B.id_grado=D.id_grado
        ORDER BY A.id_area";
$qa0=mysql_query($query);
if (!$qa0) die(mysql_error());
$num_grados=mysql_num_rows($qa0);

$contenido_centro='
<div id="centro">
    <div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede seleccionar un Tema para ver y modificar su informaci&oacute;n<br>
</div><br>
    <div id="contenido">
            <table class="table responsive-table listado" id="tabla">
                    <thead>
                    <tr>
                            <th scope="col">Contenido</th>
                            <th scope="col">&Aacute;rea de Aprendizaje</th>
                            <th scope="col">Componente</th>
                            <th scope="col">Grado</th>
                    </tr>
                    </thead>
                    <tfoot><tr>
                         <td colspan="7" align="center"><b>'.$num_grados.'</b> Componentes en Total</td>
                     </tr> </tfoot>
                    <tbody>';
      while(($areas=mysql_fetch_assoc($qa0))!=false){
                    $contenido_centro.='
                    <tr>
                            <td class="area" id="'.$areas["id_contenido"].'">'.$areas["contenido"].'</td>
                            <td class="area" id="'.$areas["id_contenido"].'">'.$areas["area_aprendizaje"].'</td>
                            <td class="area" id="'.$areas["id_contenido"].'">'.$areas["componente"].'</td>
                            <td class="area" id="'.$areas["id_contenido"].'">'.$areas["grado"].'</td>
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
p_js_agregar_archivo("plantilla/js/jsUsuarios/verContenidos.js");

p_contenido('centro',$contenido_centro);

p_contenido('titulo_grande_1','Ver y Modificar Temas');

p_con_pizarra(true);
p_contenido('pizarra','Seleccione el Tema a visualizar/modificar');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Ver y Modificar Temas</a>');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');

p_dibujar();

?>