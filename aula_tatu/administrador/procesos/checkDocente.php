<?php
require '../../config.php';
//Busca la informacion de un instituto educativo
if (isset($_GET['cedula']) && ($_GET['cedula'] != "")){
$query='SELECT  COUNT(B.id_seccion) cant,
        COALESCE(NULL, (SELECT A.id_usuario FROM sist_usuario A
        WHERE A.cedula="'.$_GET['cedula'].'" AND A.tipo="PROFESOR")) as id
        FROM tbl_personas_seccion B WHERE B.id_persona="'.$_GET['cedula'].'"';
$q0=mysql_query($query);
if(!$q0){ die(mysql_error());   echo "0";}
if(mysql_num_rows($q0)>0){
        $qa0=mysql_fetch_assoc($q0);
        if (is_null($qa0["id"])){
            echo "<div style='color:red;'>La c&eacute;dula no se encuentra registrada en el sistema, o no pertenece a un Docente</div>";
        }
        else{
            if($qa0["cant"]==3){
                echo "<div style='color:red;'>El docente ya tiene 3 secciones</div>";
            }
            else{
                echo "<div style='color:green;'>Correcto</div>";
            }
        }
}
else{
	echo "<div style='color:red;'>Error al verificar la c&eacute;dula, recargue la p&aacute;gina e intente nuevamente</div>";
}

}
else{
echo "<div style='color:red;'>Error al enviar la c&eacute;dula, recargue la p&aacute;gina e intente nuevamente</div>";
}

?>
