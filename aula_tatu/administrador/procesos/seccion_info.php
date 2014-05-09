<?php
//Falta modificar este archivo - puede ser como usuario_info
if (isset($_GET['seccion']) && ($_GET['seccion'] != "")){
require '../../config.php';

$query="SELECT A.*,B.nombre_colegio,C.grado,D.nombre,D.apellido 
        FROM tbl_seccion A, tbl_unidadeducativa B, sist_grado C, tbl_personas D, tbl_personas_seccion E,
        sist_usuario F
        WHERE A.id_seccion='".$_GET['seccion']."' AND A.id_colegio=B.id_colegio AND A.id_grado=C.id_grado AND E.id_seccion=A.id_seccion AND 
        E.id_persona=D.cedula AND D.cedula=F.cedula AND F.tipo='PROFESOR'";

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