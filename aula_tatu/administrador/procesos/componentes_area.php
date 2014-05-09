<?php
require '../../config.php';
p_set_rel_path('../');
    if (isset($_GET["id"]) && $_GET["id"] != ""){
	$query = "SELECT A.id_componente, A.componente
                FROM tbl_componente A, sist_grado B
                WHERE id_area='".$_GET["id"]."' AND A.id_grado = B.id_grado";
	$q0=mysql_query($query);
	if(!$q0){ die(mysql_error());   echo "0";}
        if (mysql_num_rows($q0)>0){
	$componentes = '<select class="select expandable-list replacement fixedWidth select-styled-list tracked" name="componente" id="componente" style="width:150px;"><option></option>';
	 while($qa0=mysql_fetch_assoc($q0)){
	    $componentes .= '<option value="'.$qa0["id_componente"].'">'.$qa0["componente"].'</option>';
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