<?php
//Falta modificar este archivo - puede ser como usuario_info
if (isset($_GET['instituto']) && ($_GET['instituto'] != "")){
require '../../config.php';
$query='SELECT tbl_unidadeducativa.*, sist_estado.estado, sist_municipio.municipio, sist_parroquia.parroquia FROM tbl_unidadeducativa, sist_estado, sist_municipio, sist_parroquia WHERE tbl_unidadeducativa.codigo_colegio="'.$_GET['instituto'].'" AND tbl_unidadeducativa.id_estado = sist_estado.id_estado AND tbl_unidadeducativa.id_municipio = sist_municipio.id_municipio AND tbl_unidadeducativa.id_parroquia = sist_parroquia.id_parroquia';
$q0=mysql_query($query);
  if(!$q0){ die(mysql_error());   echo "0";}
  $instituto =mysql_fetch_assoc($q0);
  $datos = "<strong>C&oacute;digo del Instituto: </strong>".$instituto['codigo_colegio']."<br>";
  $datos .= "<strong>Nombre del Instituto: </strong>".$instituto['nombre_colegio']."<br>";
  $datos .= "<strong>Tipo: </strong>".$instituto['tipo']."<br>";
  $datos .= "<strong>: </strong>".$instituto['activo']."<br><br>";
  
  $datos .= "<strong>Estado: </strong>".$instituto['estado']."<br>"; 
  $datos .= "<strong>Municipio: </strong>".$instituto['municipio']."<br>";
 
  $datos .= "<strong>Persona de Contacto: </strong>".$instituto['nombre_contacto']."<br><br>";
  $datos .= "<strong>Tel&eacute;fono: </strong>".$instituto['telefono']."<br>";
  $datos .= "<strong>Correo: </strong>".$instituto['correo']."<br>";
  echo $datos;
}
else{
    echo "-1";
}
?>