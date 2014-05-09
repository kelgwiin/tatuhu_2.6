<?php
//Falta modificar este archivo - puede ser como usuario_info
if (isset($_GET['area']) && ($_GET['area'] != "")){
require '../../config.php';
$query='SELECT A.*, B.area_aprendizaje, C.grado FROM tbl_componente A, tbl_areasaprendizaje B, sist_grado C
        WHERE A.id_componente= "'.$_GET['area'].'" AND A.id_grado = C.id_grado AND A.id_area=B.id_area';
$q0=mysql_query($query);
if(!$q0){ die(mysql_error());   echo "0";}
if($row_datos =mysql_fetch_assoc($q0)){
?>
<h3 class="thin"> <span style="font-weight: bold;">Componente: </span><?php echo $row_datos["componente"]; ?> </h3>
<div style="margin: 0 auto; max-width: 600px;">
<div style="min-width:200px;max-width:400px; margin: 0 auto; float:left">
	<p class="big-message">
		<strong><?php echo $row_datos['area_aprendizaje'];  ?></strong><br>
                &Aacute;rea de Aprendizaje <br><br>
                <strong><?php echo $row_datos['grado']; ?></strong><br>
                Grado/A&ntilde;o <br><br>
		<strong><?php echo (($row_datos['descripcion']=="")?"-": $row_datos['descripcion']); ?></strong><br>
                Descripci&oacute;n <br><br>
	</p>
</div >
<div style="float: right; margin-right: 20px; margin-top: 20px;">
    <img src="<?php echo "../uploadImages/COMP/".$row_datos["imagen"]; ?>" style="max-width: 150px; max-height: auto; ">
</div>
</div>
<?php
}

}
else{
    echo "-1";
}
?>