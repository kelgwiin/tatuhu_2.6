<?php
require '../../config.php';
//Cambia el estatus de un instituto
if (isset($_GET['id']) && $_GET['id'] != "" && isset($_GET['mode']) && $_GET['mode'] != ""  ){
$query='UPDATE tbl_unidadeducativa SET activo="'.$_GET['mode'].'" WHERE codigo_colegio="'.$_GET['id'].'"';
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
