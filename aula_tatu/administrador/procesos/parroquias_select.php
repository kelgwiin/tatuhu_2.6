<?php
require '../../config.php';

//Busca en la BD los municipios de un estado y los coloca en formato de select

if (isset($_GET['municipio']) && ($_GET['municipio'] != "")){

$query='SELECT id_parroquia, parroquia FROM sist_parroquia WHERE id_municipio="'.$_GET['municipio'].'"';
$q0=mysql_query($query);
  if(!$q0){ die(mysql_error());   echo "0";}
  $i = 0;
   while($qa0=mysql_fetch_assoc($q0)){
	 if($i==0)
       $municipios.='<option value="'.$qa0['id_parroquia'].'" selected>'.$qa0['parroquia'].'</option>';
	  else
	     $municipios.='<option value="'.$qa0['id_parroquia'].'">'.$qa0['parroquia'].'</option>'; 
	$i++;
  }
  echo $municipios;
}

?>