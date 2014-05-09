<?php
require_once '../../config.php';
require_once '../../plantilla/php/validator/validator_archivos.php';
$tipo = array("image/png");
if (isset($_POST["nombre_area"]) && $_POST["nombre_area"] != "" && 
        isset($_POST["descripcion"]) && $_POST["descripcion"]!= "" &&
        isset($_POST["grado"]) && $_POST["grado"] != "" &&
        isset($_FILES) && nombre_correcto($_FILES["imagen_area"]["name"])
        && tamanio_correcto($_FILES["imagen_area"]["tmp_name"], 122880)/*120KB*/ 
        && imagen_valida($_FILES["imagen_area"]["tmp_name"], $tipo, 250,400,250,400)){
   //procesando el nombre de la imagen
   $nombre_arch = get_nombre($_FILES["imagen_area"]["name"]);
   $ruta = "../../uploadImages/AA/".$nombre_arch;
   if (@move_uploaded_file($_FILES["imagen_area"]["tmp_name"],$ruta)){
        $query = "INSERT INTO tbl_areasaprendizaje
            (area_aprendizaje, descripcion, imagen, id_grado, activo) 
            VALUES ('".htmlentities($_POST["nombre_area"])."',
            '".htmlentities($_POST["descripcion"])."','".$nombre_arch."','".$_POST["grado"]."','SI')";
        $q0=mysql_query($query);
        if ($q0){
            chmod($ruta,0666);  //Cambiamos los permisos del archivo
            echo '<span><img src="../plantilla/img/standard/correcto.png" alt="Correcto"> El &aacute;rea <strong>'.$_POST["nombre_area"].'</strong> fue registrada exitosamente</span><br>';
        }
       else{
             unlink($ruta);
            echo "<img src='../plantilla/img/standard/error.png'> Error al registrar el &Aacute;rea, verifique que est&eacute;n llenos los campos obligatorios";
       }
   }
}
else{
    echo "<img src='../plantilla/img/standard/error.png'> Error al enviar los datos del &Aacute;rea, verifique que est&eacute;n llenos los campos obligatorios y que el tipo y tama&ntilde;o de la imagen sean correctos, o recargue la p&aacute;gina";
}
?>