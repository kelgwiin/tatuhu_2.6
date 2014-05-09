<?php
require '../../config.php';
if (isset($_GET['id']) && $_GET['id'] != ""){
    $query= "SELECT A.ruta, A.tipo, B.nombre_actividad, C.enlace
	    FROM tbl_act_material AS A, tbl_actividades AS B, sist_actividad AS C
	    WHERE A.id_material ='".$_GET['id']."' AND
	    A.id_actividad = B.id_actividad AND C.id_tipo = B.tipo_actividad";
    if(!($q0=mysql_query($query))) error(mysql_error());
    $material = mysql_fetch_assoc($q0);
    $scriptData = '<div style="text-align:center">'.$material["nombre_actividad"].'</div><br>';
	$funcionalidad = "../".$material["enlace"];
	$scriptData .='<iframe width="100%" height="500" frameborder="0" src="'.$funcionalidad.'?libro='.$material["ruta"].'" class="modal-iframe"></iframe>';
    echo $scriptData;
}

?>