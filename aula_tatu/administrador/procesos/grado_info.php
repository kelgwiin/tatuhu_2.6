<?php
//Falta modificar este archivo - puede ser como usuario_info
if (isset($_GET['grado']) && ($_GET['grado'] != "")){
require '../../config.php';
$query='SELECT * FROM sist_grado WHERE id_grado="'.$_GET['grado'].'"';
$q0=mysql_query($query);
  if(!$q0){ die(mysql_error());   echo "0";}
  $grado =mysql_fetch_assoc($q0);
  $datos = "<strong>Grado: </strong>".$grado['grado']."<br>";
  echo $datos;
}
else{
    echo "-1";
}
?>