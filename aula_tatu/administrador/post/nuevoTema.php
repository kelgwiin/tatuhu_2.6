<?php
require_once '../../config.php';

if (isset($_POST["nombre_tema"]) && $_POST["nombre_tema"] != ""  &&
        isset($_POST["area"]) && $_POST["area"] != "" &&
        isset($_POST["componente"]) && $_POST["componente"] != ""){
        //Comprobando el orden del contenido
        $query = "SELECT orden+1 AS ultimo FROM tbl_contenido 
                 WHERE id_area='".$_POST["area"]."' AND id_componente='".$_POST["componente"]."'
                 ORDER BY orden DESC LIMIT 0,1";
        $q0=mysql_query($query);
        if ($q0){
         if (mysql_num_rows($q0)>0){ $qa0=mysql_fetch_assoc($q0); $ultima = $qa0["ultimo"];}
         else{$ultima = 1;}
           $query = "INSERT INTO tbl_contenido(id_area, id_componente,contenido, descripcion, objetivos, orden) 
                     VALUES('".$_POST["area"]."', '".$_POST["componente"]."','".htmlentities($_POST["nombre_tema"])."','"
                   .htmlentities($_POST["descripcion"])."','".htmlentities($_POST["objetivos"])."','".$ultima."')";
           $q0=mysql_query($query);        
           if (!$q0)
               echo "<img src='../plantilla/img/standard/error.png'> Error al registrar el tema";
           else
             echo '<span><img src="../plantilla/img/standard/correcto.png" alt="Correcto"> El tema <strong>'.$_POST["nombre_tema"].'</strong> fue registrado exitosamente</span><br>';
        }
        else{
            echo "<img src='../plantilla/img/standard/error.png'> Error al comprobar el orden de la actividad";
       }
}
else{
    echo "<img src='../plantilla/img/standard/error.png'> Error al enviar los datos del tema, verifique que est&eacute;n llenos los campos obligatorios o recargue la p&aacute;gina";
}
?>