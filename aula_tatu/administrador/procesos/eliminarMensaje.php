<?php
require '../../config.php';
//Cambia el estatus de una seccion
if (isset($_GET['id']) && $_GET['id'] != ""){
$query='DELETE FROM sist_int_mensajesvalores WHERE id="'.$_GET['id'].'"';
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
