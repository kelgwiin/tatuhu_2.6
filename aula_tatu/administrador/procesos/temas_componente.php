<?php
require '../../config.php';
p_set_rel_path('../');
    if (isset($_GET["id"]) && $_GET["id"] != ""){
	$query = "SELECT id_contenido, contenido FROM tbl_contenido WHERE id_componente = '".$_GET["id"]."'";
	$q0=mysql_query($query);
	if(!$q0){ die(mysql_error());   echo "0";}
        if (mysql_num_rows($q0)>0){
	$componentes = '<select class="select expandable-list replacement fixedWidth select-styled-list tracked" name="contenido" id="contenido" style="width:150px;"><option></option>';
	 while($qa0=mysql_fetch_assoc($q0)){
	    $componentes .= '<option value="'.$qa0["id_contenido"].'">'.$qa0["contenido"].'</option>';
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