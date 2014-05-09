<?php
require '../../config.php';
p_set_rel_path('../');
    if (isset($_GET["id_area"]) && $_GET["id_area"] != "" && isset($_GET["nombre"]) && $_GET["nombre"] != "" && isset($_GET["grado"]) && $_GET["grado"] != "" && $_GET['paso'] != ""){
	$query = "SELECT * FROM tbl_componente WHERE id_area='".$_GET["id_area"]."' AND id_grado='".$_GET["grado"]."' AND activo='SI'";
	$q0=mysql_query($query);
	if(!$q0){ die(mysql_error());   echo "0";}
	$componentes = "";
	$componentes .= '<br><br><span class="info"> &Aacute;rea seleccionada:</span>'.$_GET["nombre"].'<br>';
	$componentes .= '<span class="info">Paso '.$_GET['paso'].': Ahora seleccione un Componente para ver sus Contenidos:</span><br>';
	 while($qa0=mysql_fetch_assoc($q0)){
	    $componentes .= '<a href="contenidos_visualizar.php?id='.$qa0['id_componente'].'&grado='.$_GET["grado"].'" alt="'.$qa0['componente'].'" id="'.$qa0['id_componente'].'" class="componente"><img src="'.p_get_rel_path().'/uploadImages/COMP/'.$qa0['imagen'].'" class="imgarea"></a>';
	 }
	 echo $componentes; 
    }
    else{
	echo "0";
    }
?>