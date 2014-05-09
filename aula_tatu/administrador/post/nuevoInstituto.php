<?php
require_once '../../config.php';
$sinacoe = '/^([a-z1-90]{10})$/i';

if (isset($_POST["codigo_colegio"]) && $_POST["codigo_colegio"] != "" 
    && isset($_POST["nombre_colegio"]) && $_POST["nombre_colegio"] != ""
    && isset($_POST["tipo"]) && $_POST["tipo"] != "" 
    && isset($_POST["estado"]) && $_POST["estado"] != ""
    && isset($_POST["municipio"]) && $_POST["municipio"] != ""
    && isset($_POST["parroquia"]) && $_POST["parroquia"] != ""){
    if (preg_match($sinacoe, $_POST["codigo_colegio"])){
        switch ($_POST["tipo"]){
            case "0": $tipo = "B&aacute;sica Media"; break;
            case "1": $tipo = "B&aacute;sica Alta";  break;
            case "2": $tipo = "B&aacute;sica Alta";  break;
            default : $tipo = "Otro";                break;
        }
         $query = "INSERT INTO tbl_unidadeducativa 
                (codigo_colegio,nombre_colegio,direccion,tipo,telefono,
                nombre_contacto,correo,id_estado,id_municipio,id_parroquia,activo) 
                VALUES ('".strtoupper($_POST["codigo_colegio"])."','".htmlentities($_POST["nombre_colegio"])."','".htmlentities($_POST["direccion"])."','"
                .$tipo."','".$_POST["telefono"]."','".htmlentities($_POST["nombre_contacto"])."','"
                .$_POST["correo"]."','".$_POST["estado"]."','".$_POST["municipio"]."','".$_POST["parroquia"]."', 'ACTIVO')";
         $q0=mysql_query($query);
        if(!$q0){  
            echo "<img src='../plantilla/img/standard/error.png'> 
                El c&oacute;digo del Instituto que intenta registrar ya existe, 
                por favor verifique e intente nuevamente";
            
        }
        else{
                    echo "<img src='../plantilla/img/standard/correcto.png'> 
                          El Instituto <strong>".$_POST["nombre_colegio"]."</strong> ha sido registrado correctamente.<br><br>
                         <img src='../plantilla/img/icons_docente/tip.png'> Puede modificar los datos del instituto en la opci&oacute;n \"Ver y Modificar Institutos\"";
        }
    }
}
else{
     echo "<img src='../plantilla/img/standard/error.png'> Error al enviar los datos del Instituto, verifique 
         que est&eacute; llenos todos los campos obligatorios o recargue la p&aacute;gina";
}
?>