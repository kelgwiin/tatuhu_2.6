<?php
require '../config.php';
require '../auth.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
p_set_rel_path('../');
// Usuarios registrados en Sistema (menos el actual)
$query='SELECT A.cedula, A.nombre, A.apellido, B.id_usuario, B.usuario, B.tipo, B.activo
        FROM tbl_personas A, sist_usuario B WHERE A.cedula = B.cedula AND A.cedula!= "'.$_SESSION['usuario']['cedula'].'"';
$q0=mysql_query($query);
if(!$q0) die('Error de Comunicacion y Gestion con BD <br>'.mysql_error().'');
$total_personas=mysql_num_rows($q0);

$_contenido='<div id="centro">
<div class="infoOblig">
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede seleccionar a un usuario para ver y modificar su informaci&oacute;n<br>
<img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Puede desactivar a un usuario para bloquear su acceso al sistema haciendo clic en el switch correspondiente en "Estatus"
</div><br>
        <div id="contenido">
        <table border="0" class="table responsive-table listado" id="tabla_visualizador_usuarios">
        <thead class="new-row-tablet four-columns six-columns-tablet twelve-columns-mobile-portrait table-header">
        <tr>
                <th scope="col">C&eacute;dula</th>
                <th scope="col">Nombre y Apellido</th>
                <th scope="col">Nombre de Usuario</th>
                <th scope="col">Tipo</th>
                <th scope="col">Estatus</th>
        </tr>
        </thead>
        <tfoot><tr><td colspan="7" align="center">'.$total_personas.' Personas en Total</td></tr></tfoot>
        <tbody>';
        while($data_persona=mysql_fetch_assoc($q0)){
                $_contenido.='<tr >
                <td><a class="persona" id="'.$data_persona['cedula'].'">'.$data_persona['cedula'].'</a></td>
                <td><a class="persona" id="'.$data_persona['cedula'].'">'.$data_persona['nombre'].' '.$data_persona['apellido'].'</a></td>
                <td><a class="persona" id="'.$data_persona['cedula'].'">'.$data_persona['usuario'].'</a></td>
                <td><a class="persona" id="'.$data_persona['cedula'].'">'.$data_persona['tipo'].'</a></td>
                <td><input type="checkbox" name="act_des" id="'.$data_persona['cedula'].'/'.$data_persona['nombre'].' '.$data_persona['apellido'].'" class="switch medium mid-margin-left replacement with-tooltip tooltip-right" 
                     value="'.(($data_persona["activo"]=='SI')?'1':'0').'title="Tooltip on the right"
                     '.(($data_persona["activo"]=='SI')?'checked':'').' data-text-on="Activo" data-text-off="Inactivo" title="Haz click para '.(($data_persona["activo"]=='NO')?'desactivar':'activar').' al Usuario">       
                 </tr>';
        }
$_contenido.='</tbody></table></div></div>';
p_contenido('centro',$_contenido);

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
p_js_agregar_archivo("plantilla/js/jsUsuarios/verUsuarios.js");

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Ver y Modificar Usuarios');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Ver y Modificar Usuarios</a>');

p_con_pizarra(true);
p_contenido('pizarra','Seleccione el Usuario a visualizar/modificar');
p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        
