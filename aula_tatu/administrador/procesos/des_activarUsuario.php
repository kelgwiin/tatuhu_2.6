<?php
require '../../config.php';
//Cambia el estatus de un usuario
if (isset($_GET['cedula']) && $_GET['cedula'] != "" && isset($_GET['mode']) && $_GET['mode'] != ""  ){
$query='UPDATE sist_usuario SET activo="'.$_GET['mode'].'" WHERE cedula="'.$_GET['cedula'].'"';
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
