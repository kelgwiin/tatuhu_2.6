<?php
if (isset($_GET['id']) && $_GET['id']){
require '../../config.php';
$query="SELECT COUNT(id_actividad) AS cant FROM tbl_actividades 
        WHERE id_contenido='".$_GET["id"]."'";
 $q0 = mysql_query($query); 
if(!$q0){echo "0"; die(mysql_error());   }
    else{
        $cant=mysql_fetch_assoc($q0);
        if($cant['cant']>=10) echo "1";
        else echo "-1";
    }
}
else{
    echo "0";
}
?>