<?php
require_once '../../config.php';
require_once '../../plantilla/php/validator/validator_archivos.php';
$tipo = array("image/png");
if (isset($_POST["nombre_componente"]) && $_POST["nombre_componente"] != "" && isset($_POST["descripcion"])
        && $_POST["descripcion"]!= "" 
        && isset($_POST["area"]) && $_POST["area"]!="" && isset($_POST["grado"]) && $_POST["grado"]!=""
        && isset($_FILES) && nombre_correcto($_FILES["imagen_componente"]["name"])
        && tamanio_correcto($_FILES["imagen_componente"]["tmp_name"], 122880)/*120KB*/ 
        && imagen_valida($_FILES["imagen_componente"]["tmp_name"], $tipo, 250,400,250,400)){
   //procesando el nombre de la imagen
   $nombre_arch = get_nombre($_FILES["imagen_componente"]["name"]);
   $ruta = "../../uploadImages/COMP/".$nombre_arch;
   if (@move_uploaded_file($_FILES["imagen_componente"]["tmp_name"],$ruta)){
        $query = "INSERT INTO tbl_componente(id_grado, id_area, componente, descripcion,imagen, activo) VALUES 
                 ('".$_POST["grado"]."','".$_POST["area"]."','".htmlentities($_POST["nombre_componente"])."',
                  '".htmlentities($_POST["descripcion"])."','".$nombre_arch."','SI')";
        $q0=mysql_query($query);
        if ($q0){
            chmod($ruta,0666);  //Cambiamos los permisos del archivo
            echo '<span><img src="../plantilla/img/standard/correcto.png" alt="Correcto"> El componente <strong>'.$_POST["nombre_componente"].'</strong> fue registrado exitosamente</span><br>';
        }
       else{
             unlink($ruta);
            echo "<img src='../plantilla/img/standard/error.png'> Error al registrar el componente, verifique que est&eacute;n llenos los campos obligatorios";
       }
   }
}
else{
    echo "<img src='../plantilla/img/standard/error.png'> Error al enviar los datos del componente, verifique que est&eacute;n llenos los campos obligatorios y que el tipo y tama&ntilde;o de la imagen sean correctos, o recargue la p&aacute;gina";
}
?>