<?php
require '../../config.php';

//Busca en la BD los municipios de un estado y los coloca en formato de select
if (isset($_GET['estado']) && ($_GET['estado'] != "")){

$query='SELECT id_municipio, municipio FROM sist_municipio WHERE id_estado="'.$_GET['estado'].'"';
$q0=mysql_query($query);
  if(!$q0){ die(mysql_error());   echo "0";}
  $municipios = "<option></option>";
   while($qa0=mysql_fetch_assoc($q0)){
	     $municipios.='<option value="'.$qa0['id_municipio'].'">'.$qa0['municipio'].'</option>'; 
  }
  echo $municipios;
}

?>