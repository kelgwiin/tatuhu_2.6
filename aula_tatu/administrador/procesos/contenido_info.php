<?php
//Falta modificar este archivo - puede ser como usuario_info
if (isset($_GET['area']) && ($_GET['area'] != "")){
require '../../config.php';
$query='
    SELECT A.*, B.area_aprendizaje, C.componente, D.grado
        FROM tbl_contenido A, tbl_componente C, tbl_areasaprendizaje B, sist_grado D
        WHERE A.id_contenido="'.$_GET['area'].'" AND A.id_componente=C.id_componente 
            AND A.id_area= B.id_area AND B.id_grado=D.id_grado
        ORDER BY A.id_area
';
$q0=mysql_query($query);
if(!$q0){ die(mysql_error());   echo "0";}
if($row_datos =mysql_fetch_assoc($q0)){
?>
<h3 class="thin"> <span style="font-weight: bold;">Tema: </span><?php echo $row_datos["contenido"]; ?> </h3>
<div style="margin: 0 auto; max-width: 600px;">
<div style="min-width:200px;max-width:400px; margin: 0 auto;">
	<p class="big-message">
		<strong><?php echo $row_datos['area_aprendizaje'];  ?></strong><br>
                &Aacute;rea de Aprendizaje <br><br>
                <strong><?php echo $row_datos['componente']; ?></strong><br>
                Grado/A&ntilde;o <br><br>
                <strong><?php echo $row_datos['grado']; ?></strong><br>
                Grado/A&ntilde;o <br><br>
		<strong><?php echo (($row_datos['descripcion']=="")?"-": $row_datos['descripcion']); ?></strong><br>
                Descripci&oacute;n <br><br>
                <strong><?php echo (($row_datos['objetivos']=="")?"-": $row_datos['objetivos']); ?></strong><br>
                Objetivos <br><br>
	</p>
</div >
</div>
<?php
}

}
else{
    echo "-1";
}
?>