<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');	
$query="SELECT DISTINCT A.id_actividad,A.nombre_actividad, A.usuario,B.nombre_sist,B.tipo_actividad,
        E.area_aprendizaje, F.grado
        FROM tbl_actividades A, sist_actividad B , tbl_contenido C, tbl_componente D, 
        tbl_areasaprendizaje E, sist_grado F
        WHERE A.tipo_actividad=B.id_tipo AND B.tipo_pedagogia='Juego' AND 
        A.id_contenido=C.id_contenido AND C.id_area=D.id_area AND D.id_area=E.id_area AND E.id_grado=F.id_grado";
$qa0=mysql_query($query);
if (!$qa0) die(mysql_error());
$num_grados=mysql_num_rows($qa0);
$contenido_centro='
<div id="centro">
    <div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede seleccionar una Actividad para ver y modificar su informaci&oacute;n<br>
</div><br>
    <div id="contenido">
            <table class="table responsive-table listado" id="tabla">
                    <thead>
                    <tr>
                            <th scope="col">Nombre de la Actividad</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">&Aacute;rea de Aprendizaje</th>
			    <th scope="col">Grado</th>
                    </tr>
                    </thead>
                    <tfoot><tr>
                         <td colspan="7" align="center"><b>'.$num_grados.'</b> Actividades en Total</td>
                     </tr> </tfoot>
                    <tbody>';
      while(($areas=mysql_fetch_assoc($qa0))!=false){
            $contenido_centro.='
            <tr>
                    <td class="area" id="'.$areas["id_actividad"].'-'.$areas["nombre_sist"].'">'.$areas["nombre_actividad"].'</td>
                    <td class="area" id="'.$areas["id_actividad"].'-'.$areas["nombre_sist"].'">'.$areas["tipo_actividad"].'</td>
                    <td class="area" id="'.$areas["id_actividad"].'-'.$areas["nombre_sist"].'">'.$areas["area_aprendizaje"].'</td>
                    <td class="area" id="'.$areas["id_actividad"].'-'.$areas["nombre_sist"].'">'.$areas["grado"].'</td>
            </tr>';
      }
    $contenido_centro.='</tbody></table></div></div>';

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
p_js_agregar_archivo("plantilla/js/jsUsuarios/verActividadesAd.js");

p_contenido('centro',$contenido_centro);

p_contenido('titulo_grande_1','Ver y Modificar Actividades');

p_con_pizarra(true);
p_contenido('pizarra','Seleccione la Actividad a visualizar/modificar');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Ver y Modificar Actividades</a>');

p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');

p_dibujar();

?>