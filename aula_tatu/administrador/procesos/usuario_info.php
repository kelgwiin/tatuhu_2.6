<?php
if (isset($_GET["cedula"]) && $_GET["cedula"] != ""){
require '../../config.php';
/*$query='SELECT A.*, B.tipo, B.activo, C.ruta_imagen 
        FROM tbl_personas A, sist_usuario B, tbl_avatar C 
        WHERE A.cedula="'.$_GET['cedula'].'" AND A.cedula = B.cedula AND B.id_avatar = C.id_imagen';*/
$query='SELECT
	A.*, B.tipo,
	B.activo,
	C.ruta_imagen,
	E.codigo_colegio,
	E.nombre_colegio
FROM
	tbl_personas A,
	tbl_seccion D,
	sist_usuario B,
	tbl_unidadeducativa AS E,
	tbl_personas_seccion AS F,
	tbl_avatar C
WHERE
	A.cedula = "'.$_GET['cedula'].'"
AND A.cedula = B.cedula
AND B.id_avatar = C.id_imagen
AND A.cedula = F.id_persona
AND B.cedula = F.id_persona 
AND D.id_colegio = E.id_colegio
AND D.id_seccion = F.id_seccion
LIMIT 0,1';
$q0=mysql_query($query);
if(!$q0) die('Error de Comunicacion y Gestion con BD <br>'.mysql_error().'<br>Comunique al Administrador');
if($row_datos=mysql_fetch_assoc($q0)){
?>
<h3 class="thin"> <span style="font-weight: bold;">Usuario: </span><?php echo $row_datos["nombre"]." ".$row_datos["apellido"]; ?> </h3>
<div style="margin: 0 auto; max-width: 600px;">
	<div style="min-width:200px;max-width:300px; margin: 0 auto; float:left">
		<p class="big-message" style="width:80%">
			<strong><?php echo $row_datos['nombre']." ".$row_datos['apellido'];  ?></strong><br>
			Nombre de la Persona  <br><br>
			<strong><?php echo $row_datos['fecha_nacimiento'].' '.$row_datos['edad']; ?></strong><br>
			Fecha de Nacimiento								Edad</br></br>
			<strong><?php echo $row_datos['tipo']; ?></strong></br>
			Tipo de Usuario <br><br>
			<?php
			if($row_datos['tipo']=='ESTUDIANTE'){ ?>
				<strong><?php echo $row_datos['codigo_colegio'].' - '.$row_datos['nombre_colegio']; ?></strong><br>
				Instituto Educativo  <br><br>
			<?php
			}
			?>
		</p>
	</div>
	<div><img src=<?php echo "../".$row_datos["ruta_imagen"]; ?>></div>
</div>

<?php
}
else{
    echo "0";
}
}
?>