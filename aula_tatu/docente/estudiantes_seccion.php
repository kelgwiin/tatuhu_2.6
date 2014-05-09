<?php
require '../../config.php';
p_set_rel_path('../');

if (isset($_GET["seccion"]) && $_GET["seccion"] != "" && isset($_GET["grado"])
    && $_GET["grado"] != "" && isset($_GET["nombre"]) && $_GET["nombre"] != ""
    && isset($_GET["id_grado"]) && $_GET["id_grado"] != ""){
	
	$query = "SELECT A.id_persona, B.nombre, B.apellido, B.fecha_nacimiento  
		  FROM tbl_personas_seccion AS A, tbl_personas AS B, sist_usuario AS C
		  WHERE C.cedula = B.cedula AND C.activo='SI' AND
		  A.id_seccion='".$_GET["seccion"]."' AND A.id_persona = B.cedula
		  AND C.tipo = 'ESTUDIANTE'";
	$q0=mysql_query($query);
	if(!$q0){ die(mysql_error());   echo "0";}
	$total_personas = mysql_num_rows($q0);
	if ($total_personas > 0){
        $aux = ($total_personas == 1)? 'Estudiante' : 'Estudiantes';
	$estudiantes= '<div>Estudiantes de '.$_GET["grado"].' - '.$_GET["nombre"].'</div>
            <span class="info">Seleccione un estudiante para ver su informaci&oacute;n:</span><br><br>
				   <table border="0" class="table responsive-table" id="tabla_visualizador_usuarios">
				   	<thead class="new-row-tablet four-columns six-columns-tablet twelve-columns-mobile-portrait table-header">
				<tr>
					<th scope="col">C&eacute;dula</th>
					<th scope="col">Nombre y Apellido</th>
				</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="7" align="center">
							'.$total_personas.' '.$aux.'
						</td>
					</tr>
				</tfoot>';
	 while($data_persona=mysql_fetch_assoc($q0)){
	    $estudiantes.= '<tr><td><a class="persona" href="ver_estudiante.php?id='.$data_persona['id_persona'].'&grado='.$_GET["id_grado"].'&nombre='.$_GET["grado"].'&seccion='.$_GET["nombre"].'">'.$data_persona['id_persona'].'</a></td>';
	    $estudiantes.= '<td><a class="persona" href="ver_estudiante.php?id='.$data_persona['id_persona'].'&grado='.$_GET["id_grado"].'&nombre='.$_GET["grado"].'&seccion='.$_GET["nombre"].'">'.$data_persona['nombre'].', '.$data_persona['apellido'].'</a></td></tr>';
	 }
	 $estudiante .= '</table>';
	 echo $estudiantes; 
?>
<script>
    $("#tabla_visualizador_usuarios").dataTable({
            "oLanguage":{
                 "sProcessing":     "Procesando...",
                 "sLengthMenu":     "Mostrar _MENU_ registros",
                 "sZeroRecords":    "No se encontraron resultados",
                 "sEmptyTable":     "Ningún dato disponible en esta tabla",
                 "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                 "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                 "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                 "sInfoPostFix":    "",
                 "sSearch":         "Buscar:",
                 "sUrl":            "",
                 "sInfoThousands":  ",",
                 "sLoadingRecords": "Cargando...",
                 "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "&Uacute;ltimo",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                  },
                    "oAria": {
                       "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                  
            },
            "sPaginationType": "full_numbers",
            "sDom": '<"top"lfp>rt<"bottom"ip>'
    });       
</script>
<?php
    }
	else{
		echo '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay estudiantes registrados en la secci&oacute;n seleccionada</div>';
	}
}
?>