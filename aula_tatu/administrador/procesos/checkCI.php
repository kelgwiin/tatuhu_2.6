<?php
require '../../config.php';
//Busca la informacion de un instituto educativo
if (isset($_GET['cedula']) && ($_GET['cedula'] != "")){
$query='SELECT id_usuario FROM sist_usuario WHERE cedula="'.$_GET['cedula'].'"';
$q0=mysql_query($query);
if(!$q0){ die(mysql_error());   echo "0";}
if(mysql_num_rows($q0)>0){
	echo "0";
}
else{
	echo "1";
}

}
else{
echo "-1";
}

?>
