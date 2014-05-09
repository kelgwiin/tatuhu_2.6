<?php
require '../../config.php';
p_set_rel_path('../');
if (isset($_GET["id"]) && $_GET["id"] != ""){
    $query =
     "SELECT A.nombre_actividad, C.tipo, A.usuario, C.id_material
	 FROM tbl_actividades AS A, sist_actividad AS B, tbl_act_material AS C
	 WHERE C.id_actividad = A.id_actividad 
	 AND A.id_contenido='".$_GET["id"]."'
	 AND A.tipo_actividad = B.id_tipo
	 AND (B.tipo_actividad='Material_PDF' OR B.tipo_actividad='Libro Interactivo')";
$sides = "";
$j = 1;
if(!($q0=mysql_query($query))) error(mysql_error());
if (mysql_numrows($q0) == 0)
    echo "<div style='color:red;'>El contenido seleccionado no tiene materiales de lectura</div>";
else{
while ($i = mysql_fetch_assoc($q0)){
	$i["usuario"] = $i["usuario"] == "PROFESOR" ? "Profesor" : "Estudiante";
	$a = '<a href="" id="'.$i['id_material'].'" class="material">'.$i["nombre_actividad"].'</a>';
	$sides .= '<div style="heigth:15px; margin:0 auto; width:300px; color: #146684;" id="mensaje"> </div>
				<table class="table responsible-table">
			    <thead class="table-header">
				<tr>
					<th>Nombre</th>
					<th>Dirigido a</th>
					<th>Tipo</th>
				</tr>
			    </thead>
			    <tbody>
				<tr>
				    <td id="'.$i['id_material'].'">'.$a.'</td>
				    <td>'.$i["usuario"].'</td>
				    <td>'.$i["tipo"].'</td>
				</tr>
			    </tbody>
		    </table>';
	$j++;
    }
	$ruta = p_get_rel_path()."plantilla/img/standard/loaders/loading16.gif";
    $sides .= '
    <script>
    function visualizarMaterial(data){
		$("#mensaje").html(" ");
			$.modal({
				content: data,
				title: "",
				width: 800,
				height: 600,
				scrolling: false,
				actions: {
					"Cerrar" : {
						color: "red",
						click: function(win) { win.closeModal(); }
					}
				},
				buttons: {
					"Cerrar": {
						classes:"huge blue-gradient glossy full-width",
						click:	function(win) { win.closeModal(); }
					}
				},
				buttonsLowPadding: true
			});
		};

      $(document).ready(function() {
		$(".material").click(function(event){
			    event.preventDefault();
					var cod = $(this).attr("id"); 
					
					if(cod != ""){
				    $("#mensaje").html("<img src=\"'.$ruta.'\" alt=\"cargando\"> Cargando material, por favor espere.");
						$.get("procesos/material_visualizar.php", { id: cod})
						.done(function(data) {
						  if (data != "0"){
							visualizarMaterial(data);
						 }
						});
					  }
				});
            });
    </script>
    ';
    echo $sides;
}
}
    else{
	echo "0";
    }
?>