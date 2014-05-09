<?php
if (isset($_GET['material'])){
require '../../config.php';
$query="SELECT A.id_actividad,A.nombre_actividad,B.tipo_actividad, A.usuario,A.retroalimentacion,E.area_aprendizaje, F.grado, F.id_grado, C.contenido, D.componente, D.id_componente
	FROM tbl_actividades A,sist_actividad B, tbl_contenido C, tbl_componente D, tbl_areasaprendizaje E, sist_grado F
	WHERE A.id_actividad='".$_GET['actividad']."' AND A.tipo_actividad=B.id_tipo AND A.id_contenido=C.id_contenido 
	AND C.id_area=D.id_area AND D.id_area=E.id_area AND E.id_grado=F.id_grado";
$q0=mysql_query($query);
if(!$q0){ die(mysql_error());   echo "0";}
if($row_datos =mysql_fetch_assoc($q0)){
$usuario = strtolower($row_datos["usuario"]);
$usuario[0] = strtoupper($usuario[0]);
?>
<h3 class="thin"> <span style="font-weight: bold;">Material: </span><?php echo $row_datos['nombre_actividad']; ?> </h3>
<div style="margin: 0 auto; max-width: 600px;">
<div style="min-width:200px;max-width:600px; margin: 0 auto;">
	<p class="big-message">
		<strong><?php echo $row_datos['tipo_actividad'];  ?></strong><br>
                Tipo de Material <br><br>
		<strong><?php echo $usuario;  ?></strong><br>
                Usuario <br><br>
		<strong><?php echo (($row_datos['retroalimentacion']=="")?"-": $row_datos['retroalimentacion']); ?></strong><br>
                Retroalimentaci&oacute;n <br><br>
		<strong><?php echo $row_datos['area_aprendizaje'];   ?></strong><br>
                &Aacute;rea de Aprendizaje <br><br>
		<strong><?php echo $row_datos['componente'];   ?></strong><br>
                Componente <br><br>
		<strong><?php echo $row_datos['contenido'];   ?></strong><br>
                Contenido <br><br>
		<strong><a href="material_visualizar.php?&idA=<?php echo $row_datos['id_actividad'];?>&nombre=<?php echo $row_datos['nombre_actividad'];?>" style="font-size:12px">Click para abrir el material</a></strong><br>
                Direcci&oacute;n del Material <br><br>
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