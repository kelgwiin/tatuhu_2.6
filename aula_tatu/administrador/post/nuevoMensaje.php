<?php
require_once '../../config.php';
if (isset($_POST["mensaje"]) && $_POST["mensaje"] != ""){
   $query='INSERT INTO sist_int_mensajesvalores (mensaje) VALUES("'.htmlentities($_POST["mensaje"]).'")';
   $q0 = mysql_query($query); 
   if ($q0){
       echo '<span><img src="../plantilla/img/standard/correcto.png" alt="Correcto"> El mensaje <strong>'.$_POST["mensaje"].'</strong> fue registrado exitosamente</span><br>';
   }
   else{
       echo "<img src='../plantilla/img/standard/error.png'> Error al registrar el mensaje, recargue la p&aacute;gina e intente nuevamente";
   }
}
else{
    echo "<img src='../plantilla/img/standard/error.png'> Error al enviar los datos del mensaje, verifique que est&eacute;n llenos los campos obligatorios, o recargue la p&aacute;gina";
}
?>