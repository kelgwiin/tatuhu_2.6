<?php
require '../../config.php';
//Cambia el estatus de una seccion
if (isset($_GET['id']) && $_GET['id'] != "" && isset($_GET['mode']) && $_GET['mode'] != ""  ){
$query='UPDATE tbl_seccion SET activa="'.$_GET['mode'].'" WHERE id_seccion="'.$_GET['id'].'"';
$q0=mysql_query($query);
if(!$q0){ echo "0";}
else{
	echo "1";
}
}
else{
echo "-1";
}

?>
