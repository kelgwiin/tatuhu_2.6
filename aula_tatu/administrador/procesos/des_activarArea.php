<?php
require '../../config.php';
//Cambia el estatus de un grado
if (isset($_GET['id']) && $_GET['id'] != "" && isset($_GET['mode']) && $_GET['mode'] != ""  ){
    $query='UPDATE tbl_areasaprendizaje SET activo="'.$_GET['mode'].'" WHERE id_area="'.$_GET['id'].'"';
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