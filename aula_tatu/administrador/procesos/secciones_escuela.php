<?php
require '../../config.php';
if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR') die('No autorizado');
if (isset($_GET ["colegio"]) && $_GET ["colegio"] != ""){
$query='SELECT A.id_seccion, A.seccion, B.grado 
		FROM tbl_seccion A, sist_grado B WHERE
		A.id_colegio="'.$_GET ["colegio"].'" AND A.activa="SI"
		AND A.id_grado = B.id_grado AND B.activo="ACTIVO"';
$q0=mysql_query($query);
if(!$q0) die('Error de Comunicacion y Gestion con BD <br>'.mysql_error().'<br>Comunique al Administrador');
if(mysql_num_rows($q0)>0){
echo "<select name='grado' class='select' id='gradoE'>";
	while($i=mysql_fetch_assoc($q0)){
		echo "<option value='".$i["id_seccion"]."'>".$i["grado"]."-".$i["seccion"]."</option>";
	}
echo "</select>";
}
else{ echo "<div style='color:red;'><img src='../plantilla/img/standard/error.png'> No hay secciones activas o registradas en esta Instituci&oacute;n</div>";}
}
else{ echo "0";}
?>