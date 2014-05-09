<?php
require '../../config.php';
p_set_rel_path('../');
    if (isset($_GET["id"]) && $_GET["id"] != ""){
	$query = "SELECT area_aprendizaje, id_area FROM tbl_areasaprendizaje
                  WHERE id_grado ='".$_GET["id"]."' AND activo='SI'";
	$q0=mysql_query($query);
	if(!$q0){ die(mysql_error());   echo "0";}
        if (mysql_num_rows($q0)>0){
	$componentes = '<select class="select expandable-list replacement fixedWidth select-styled-list tracked" name="area" id="area" style="width:150px;"><option></option>';
	 while($qa0=mysql_fetch_assoc($q0)){
	    $componentes .= '<option value="'.$qa0["id_area"].'">'.$qa0["area_aprendizaje"].'</option>';
	 }
         $componentes .= "</select>";
	 echo $componentes; 
        }
        else{
            echo "0";
        }
    }
    else{
	echo "-1";
    }
?>