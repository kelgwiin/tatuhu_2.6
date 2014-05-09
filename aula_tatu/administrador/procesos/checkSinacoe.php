<?php
require '../../config.php';
//Veri
if (isset($_GET['cod']) && ($_GET['cod'] != "")){
$query='SELECT id_colegio FROM tbl_unidadeducativa WHERE codigo_colegio="'.$_GET['cod'].'"';
$q0=mysql_query($query);
if(!$q0){ die(mysql_error());   echo "0";}
if(mysql_num_rows($q0)>0){
	echo "0";
}
else{
	echo "1";
}

}
else{
echo "-1";
}

?>
