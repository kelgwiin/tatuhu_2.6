<?php
require_once '../../config.php';
if (isset($_POST["grado"]) && $_POST["grado"] != ""){
    $grado = $_POST["grado"];
    
    switch ($grado){
        case "1": $grado .= "ro"; break;
        case "2": $grado .= "do"; break;
        case "3": $grado .= "ro"; break;
        case "4": $grado .= "to"; break;
        case "5": $grado .= "to"; break;
        case "6": $grado .= "to"; break;
        case "7": $grado .= "mo"; break;
        case "8": $grado .= "vo"; break;
        case "10": $grado .= "mo"; break;
        case "11": $grado .= "mo"; break;
    }
    $query = "INSERT INTO sist_grado (grado, activo) VALUES ('".$grado."','ACTIVO')";
        $q0=mysql_query($query);
        if(!$q0){
            echo "<img src='../plantilla/img/standard/error.png'> El grado <strong>".$grado."</strong> ya se encuentra registrado";
        }
        else{
            echo "<img src='../plantilla/img/standard/correcto.png'> El grado <strong>".$grado."</strong> ha sido registrado correctamente";
        }
}
else{
    echo "<img src='../plantilla/img/standard/error.png'> Error al enviar los datos del Grado, verifique que est&eacute;n llenos los campos obligatorios o recargue la p&aacute;gina";
}
?>