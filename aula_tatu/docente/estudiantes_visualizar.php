<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'PROFESOR') die('No autorizado');
p_set_rel_path('../');

$cant_secciones = count($_SESSION["datos_educativos"]);
if ($cant_secciones >0){
    
$opciones_grado.='';
    foreach($_SESSION["datos_educativos"] as $qa1){
	    $opciones_grado.= '<option value="'.$qa1['id_seccion'].'">'.$qa1['nombre_grado'].' - '.$qa1['nombre_seccion'].' - '.$qa1['nombre_colegio'].'</option>';
            $secc[] = $qa1['id_seccion'];
    }
if ($cant_secciones > 1) {
    $query = "SELECT A.id_persona, B.nombre, B.apellido, B.fecha_nacimiento, A.id_seccion, D.id_grado
		  FROM tbl_personas_seccion AS A, tbl_personas AS B, sist_usuario AS C, tbl_seccion D
		  WHERE C.cedula = B.cedula AND C.activo='SI' AND
		  A.id_seccion IN(".implode(",",$secc).") AND A.id_persona = B.cedula 
                  AND A.id_seccion = D.id_seccion AND C.tipo = 'ESTUDIANTE' ORDER BY A.id_seccion";
    $q0=mysql_query($query);
    if ($q0){
        $cant = mysql_num_rows($q0);
        if ($cant > 0){
            $_contenido .= '<div id="areaProfesor">
			    <span class="info">Seleccione el Grado/Secci&oacute;n:</span><br><br>
			    <select class="select" name="grado" id="grado">
			    <option value="">Seleccione un grado</option>
				    '.$opciones_grado.'
			    </select><br><br>
                            <div class="error">Seleccione una secci&oacute;n para listar a los estudiantes</div>
                            <div id="estudiantes"></div>
                            </div>
                        <div id="contenido" style="display:none">
                        <table border="0" class="table responsive-table listado" id="tabla_visualizador_usuarios" >
                        <thead class="new-row-tablet four-columns six-columns-tablet twelve-columns-mobile-portrait table-header">
                        <tr><th scope="col">C&eacute;dula</th><th scope="col">Nombre y Apellido</th></tr>
                        </thead>
                        <tbody>';
                        while($data_persona=mysql_fetch_assoc($q0)){
                                $_contenido.='<tr class="'.$data_persona['id_seccion'].' oculto">
                                <td><a href="ver_estudiante.php?id='.$data_persona['id_persona'].'&grado='.$data_persona["id_grado"].'&id_seccion='.$data_persona['id_seccion'].'">'.$data_persona['id_persona'].'</a></td>
                                <td><a href="ver_estudiante.php?id='.$data_persona['id_persona'].'&grado='.$data_persona["id_grado"].'&id_seccion='.$data_persona['id_seccion'].'">'.$data_persona['nombre'].' '.$data_persona['apellido'].'</a></td>
                                 </tr>';
                        }
                $_contenido.='</tbody></table></div><br><div id="error" style="display:none; color:red;"><img src="../plantilla/img/standard/error.png"> Esta secci&oacute;n no tiene estudiantes asignados, consulte al administrador</div>';
        }
        else{
               $_contenido .= '<br><div id="areaProfesor">
		    <div style="color:red;"><img src="../plantilla/img/standard/error.png">  Error al consultar a los estudiantes de las secciones, consulte al administrador</div>
		    </div>';
        }
    }
    else{
        $_contenido .= '<br><div id="areaProfesor">
		    <div style="color:red;"><img src="../plantilla/img/standard/error.png">  Error al consultar a los estudiantes de las secciones, consulte al administrador</div>
		    </div>';
    }
}
else{
     $query = "SELECT A.id_persona, B.nombre, B.apellido, B.fecha_nacimiento, A.id_seccion, D.id_grado
		  FROM tbl_personas_seccion AS A, tbl_personas AS B, sist_usuario AS C, tbl_seccion D
		  WHERE C.cedula = B.cedula AND C.activo='SI' AND
		  A.id_seccion IN(".implode(",",$secc).") AND A.id_persona = B.cedula 
                  AND A.id_seccion = D.id_seccion AND C.tipo = 'ESTUDIANTE' ORDER BY A.id_seccion";
    $q0=mysql_query($query);
    if ($q0){
        $cant = mysql_num_rows($q0);
         $_contenido.=' Estudiantes de <strong>'.$_SESSION["datos_educativos"][0]["nombre_grado"].'-'.$_SESSION["datos_educativos"][0]["nombre_seccion"].'- '.$_SESSION["datos_educativos"][0]["nombre_colegio"].'</strong><br><br>';
        if ($cant>0){
            $_contenido.='<div id="contenido">   
                    <table border="0" class="table responsive-table listado" id="tabla_visualizador_usuarios" >
                    <thead class="new-row-tablet four-columns six-columns-tablet twelve-columns-mobile-portrait table-header">
                    <tr><th scope="col">C&eacute;dula</th><th scope="col">Nombre y Apellido</th></tr>
                    </thead>
                    <tbody>';
                    while($data_persona=mysql_fetch_assoc($q0)){
                            $_contenido.='<tr class="'.$data_persona['id_seccion'].'">
                            <td><a href="ver_estudiante.php?id='.$data_persona['id_persona'].'&grado='.$data_persona["id_grado"].'&id_seccion='.$data_persona['id_seccion'].'">'.$data_persona['id_persona'].'</a></td>
                            <td><a href="ver_estudiante.php?id='.$data_persona['id_persona'].'&grado='.$data_persona["id_grado"].'&id_seccion='.$data_persona['id_seccion'].'">'.$data_persona['nombre'].' '.$data_persona['apellido'].'</a></td>
                             </tr>';
                    }
            $_contenido.='</tbody></table></div><br><div id="error" style="display:none; color:red;"><img src="../plantilla/img/standard/error.png"> Esta secci&oacute;n no tiene estudiantes asignados, consulte al administrador</div>';
        }
        else{
            $_contenido.='<div id="error" style="color:red;"><img src="../plantilla/img/standard/error.png"> Esta secci&oacute;n no tiene estudiantes asignados, consulte al administrador</div>';
        }
    }
    else{
         $_contenido .= '<br><div id="areaProfesor">
		    <div style="color:red;"><img src="../plantilla/img/standard/error.png">  Error al consultar a los estudiantes de las secciones, consulte al administrador</div>
		    </div>';
    }
}
}

$_contenido = '<div id="centro">'.$_contenido.'</div>';
p_contenido('centro',$_contenido);

p_css_agregar_texto ('.oculto{display:none;}');

p_css_agregar_archivo("../plantilla/css/styles/table_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/tablas_tatu.css");
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/js/libs/DataTables/jquery.dataTables.css");
p_js_agregar_archivo("plantilla/js/developr.input.js");
p_js_agregar_archivo("plantilla/js/developr.table.js");
p_js_agregar_archivo("plantilla/js/libs/jquery.tablesorter.min.js");
p_js_agregar_archivo("plantilla/js/libs/DataTables/jquery.dataTables.min.js");
p_js_agregar_archivo("plantilla/js/jsUsuarios/verEstudiantes.js");

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Estudiantes');
p_contenido('migajas','<a href="index.php">Inicio</a>><a href="#">Estudiantes</a>');

p_con_pizarra(true);
p_contenido('pizarra','Visualizar estudiantes de sus secciones');
p_con_menu(true);

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

p_con_shortcuts(true);
require '_shortcuts.php';
p_shortcuts_set_activo('Estudiantes');

p_set_menu_archivo('menu_tatu.php');
p_dibujar();        

?>