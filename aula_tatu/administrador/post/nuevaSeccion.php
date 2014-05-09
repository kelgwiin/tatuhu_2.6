<?php
require_once '../../config.php';
if (isset($_POST["cedula"]) && $_POST["cedula"] != "" 
        && isset($_POST["grado"]) && $_POST["grado"] != ""
       && isset($_POST["seccion"]) && $_POST["seccion"] != ""
        && isset($_POST["id_escuela"]) && $_POST["id_escuela"] != ""){

    $query = 'INSERT INTO tbl_seccion(id_colegio,id_grado,seccion, activa)
              VALUES("'.$_POST["id_escuela"].'","'.$_POST["grado"].'","'.$_POST["seccion"].'","SI")';
    mysql_query("BEGIN");
    $q0=mysql_query($query);
    if($q0){
        $lastId = mysql_insert_id();
            $query = 'INSERT INTO tbl_personas_seccion(id_persona, id_seccion)
                        VALUES ("'.$_POST["cedula"].'","'.$lastId.'")';
            $q0=mysql_query($query);
        if (!$q0){
            mysql_query("ROLLBACK");
            echo "<img src='../plantilla/img/standard/error.png'> Error al registrar la secci&oacute;n, verifique que est&eacute;n llenos los campos obligatorios o recargue la p&aacute;gina";
        }
        else{
            mysql_query("COMMIT");
            echo "<img src='../plantilla/img/standard/correcto.png'> La secci&oacute;n ha sido registrada correctamente";
        }
    }
    else{
        echo "<img src='../plantilla/img/standard/error.png'> La secci&oacute;n ya se encuentra registrada";
    }
}
else{
    echo "<img src='../plantilla/img/standard/error.png'> Error al enviar los datos de la secci&oacute;n, verifique que est&eacute;n llenos los campos obligatorios o recargue la p&aacute;gina";
}
?>