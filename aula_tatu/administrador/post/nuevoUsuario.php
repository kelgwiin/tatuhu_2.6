<?php
require_once '../../config.php';
require_once '../../plantilla/php/validator/validator_datos_usuario.php';
if ((isset($_POST["cedula"]) && $_POST["cedula"] != "" && cedulaValida($_POST["cedula"])) && 
    (isset($_POST["nombre"]) && $_POST["nombre"] != "" && nombresValidos($_POST["nombre"])) &&
    (isset($_POST["apellido"]) && $_POST["apellido"] != "" && nombresValidos($_POST["apellido"])) &&
    (isset($_POST["fecha_nacimiento"]) && $_POST["fecha_nacimiento"] != "" && fechaValida($_POST["fecha_nacimiento"])) &&
    (isset($_POST["sexo"]) && $_POST["sexo"] != "" && ($_POST["sexo"] == "FEMENINO" || $_POST["sexo"] == "MASCULINO")) &&
    (isset($_POST["tipo"]) && $_POST["tipo"]!="" && tipoValido($_POST["tipo"])) &&
    (isset($_POST["usuario"]) && $_POST["usuario"]!="" && usuarioValido($_POST["usuario"]))){
         $incT = false;
         $incC = false;
//---- VALIDACIONES  -----//
 if (isset($_POST["telefono"]) && $_POST["telefono"] != "" && !telefonoValido($_POST["telefono"])) $incT=true;
 if (isset($_POST["correo"]) && $_POST["correo"] && !correoValido($_POST["telefono"])) $incC=true;
 if($incT || $incC){
     echo "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> El ".($incT?"Tel&eacute;fono ":"Correo")." es incorrecto, verifique e intente nuevamente";
 }
 else{
     $query2="";
     $query3="";
     $incC = false;
     //validando datos educativos segun el tipo de usuario y construyendo el query correspondiente
   /* if ($_POST["tipo"]=="ADMINISTRADOR DE ESCUELA"){
         if (!isset($_POST["id_escuela"]) || $_POST["id_escuela"] == "") $incC = true;
         else
             $query2 = "INSERT INTO tbl_adminescuela(id_persona,id_escuela)
                        VALUES ('".$_POST["cedula"]."','".$_POST["id_escuela"]."')";
     }*/
    if ($_POST["tipo"]=="ESTUDIANTE"){
         if (!isset($_POST["id_escuela"]) || $_POST["id_escuela"] == "" 
             || !isset($_POST["grado"]) || $_POST["grado"]=="") $incC = true;
         else
             $query2 = "INSERT INTO tbl_personas_seccion (id_persona,id_seccion)
                        VALUES ('".$_POST["cedula"]."','".$_POST["grado"]."')";
     }
     else if ($_POST["tipo"]=="PROFESOR"){
         if(!isset($_POST["indices"]) || $_POST["indices"]=="") $incC = true;
         else{
             $indices = split(",",$_POST["indices"]);
             $incC = false;
             //validando que los grados de una misma escuela no tengan el mismo nombre y construyendo el query
             $cant = count($indices);
             $query2 = "INSERT INTO tbl_seccion(id_colegio,id_grado,seccion,activa) VALUES";
             for ($i=0;$i<$cant-1 && !$incC;$i++){
                 for ($j=$i+1; $j<$cant && !$incC; $j++){
                     if(isset($_POST[$indices[$i]]) || $_POST[$indices[$i]][0]=="" || $_POST[$indices[$i]][1]=="" || $_POST[$indices[$i]][2]==""){
                         if($_POST[$indices[$i]][0]==$_POST[$indices[$j]][0] 
                                 && $_POST[$indices[$i]][1]==$_POST[$indices[$j]][1] 
                                 && $_POST[$indices[$i]][2]==$_POST[$indices[$j]][2])
                             $incC = true;
                     }
                 }
                 if(!$incC)
                     $query2 .= "('".$_POST[$indices[$i]][0]."','".$_POST[$indices[$i]][1]."','".$_POST[$indices[$i]][2]."','SI'),";
             }
             if($incC){
                echo "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> Los datos de las secciones son incorrectos, verifique que no haya dos secciones iguales de una misma escuela";
             }
             else{ 
                 $query2[strlen($query2)-1] = "";
                 $query3 = "SELECT id_seccion FROM tbl_seccion ORDER BY id_seccion DESC LIMIT ".($cant-1);
             }
         }

     }
//--- REGISTRO DEL USUARIO ---//
     if(!$incC){
        $error = false;
        $fecha = split("/",$_POST["fecha_nacimiento"]);
        $fecha = $fecha[2]."-".$fecha[1]."-".$fecha[0];

        $query = "INSERT INTO tbl_personas(cedula,nombre,apellido,fecha_nacimiento,correo,telefono,sexo) 
                  VALUES ('".$_POST["cedula"]."','".htmlentities($_POST["nombre"])."','".htmlentities($_POST["apellido"])."',
                  '$fecha','".$_POST["correo"]."','".$_POST["telefono"]."','".$_POST["sexo"]."')";
        mysql_query("BEGIN");
        $q0=mysql_query($query);
        if($q0){
            //avatar predeterminado
            if ($_POST["tipo"]=="ADMINISTRADOR" /*|| $_POST["tipo"]=="ADMINISTRADOR DE ESCUELA"*/ || $_POST["tipo"]=="PROFESOR")
                $avatar = ($_POST["sexo"]=="FEMENINO"?"25":"35");
            else $avatar = ($_POST["sexo"]=="FEMENINO"?"13":"1");

            $pass = md5($_POST["cedula"]); //password predeterminado
            //insertando en la tabla de usuarios
            $query = "INSERT INTO sist_usuario(usuario,password,cedula,tipo,activo,id_avatar)
                      VALUES ('".$_POST["usuario"]."','".$pass."','".$_POST["cedula"]."','".$_POST["tipo"]."','SI','".$avatar."')";
            $q0=mysql_query($query);
            //manejo de escuela/secciones dependiendo del tipo de usuario
            if($q0){
              if($query2 != ""){
                  $q0=mysql_query($query2);
                  if($q0){
                      if ($query3 != "" && $_POST["tipo"]=="PROFESOR"){
                          $q0=mysql_query($query3);
                          if(!$q0){
                             $error = true; 
                             $e = 1;
                          }
                          else{
                              while($s = mysql_fetch_assoc($q0))
                                $secciones .= "(".$_POST["cedula"].",".$s["id_seccion"]."),";
                              
                              $secciones[strlen($secciones) - 1] = "";
                              $query3 = "INSERT INTO tbl_personas_seccion (id_persona,id_seccion) VALUES".$secciones; 
                              $q0=mysql_query($query3);
                                if(!$q0){
                                  $mensaje[0]["data"] = "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> No se puede asignar las secciones al docente. Verifique que los nombres de las secciones no est&eacute;n asignados a otros docentes.<br>";;
                                  $mensaje[0]["error"] = 1;
                                  $error = true; 
                                  $e = 6;
                                }
                          }
                      }
                  }
                  else{ 
                      $error = true; $e= 2;
                      if ($_POST["tipo"]=="ADMINISTRADOR DE ESCUELA")
                        echo "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> No se puede asignar la instituci&oacute;n al administrador. Verifique que la instituci&oacute;n ya no est&eacute; asignada a otra persona.<br>";
                      else if($_POST["tipo"]=="ESTUDIANTE")
                          echo "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> No se puede asignar la secci&oacute;n al estudiante.<br>";
                      else if($_POST["tipo"]=="PROFESOR")
                          echo "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> No se puede asignar las secciones al docente. Verifique que los nombres de las secciones no est&eacute;n asignados a otros docentes.<br>";;
                  }
              }
            }
            else{ $error = true; 
                 echo "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> No se puede registrar el usuario. Verifique que la c&eacute;dula y el nombre de usuario no se encuentre registrados.<br>";;
            }
        }
        else{ 
            $error = true;
            echo "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> No se puede registrar el usuario. Verifique que la c&eacute;dula y el nombre de usuario no se encuentre registrados.<br>";;
        }
        if($error){
            mysql_query("ROLLBACK");
        }
        else{
            mysql_query("COMMIT");
echo '<div style="margin: 0 auto; max-width: 600px;">
    <span style="color: green;"><img src="../plantilla/img/standard/correcto.png" alt="Correcto"> El usuario fue registrado exitosamente</span><br>
    <h3 class="thin"> <span style="font-weight: bold;">Datos del Usuario: </span>'.$_POST["nombre"]." ".$_POST["apellido"].'</h3>
<div style="min-width:200px;max-width:400px; margin: 0 auto;">
	<p class="big-message">
		<strong>'.$_POST["usuario"].'</strong></br>
		Nombre de Usuario para ingresar al Aula <br><br>
		<strong>'.$_POST["cedula"].'</strong><br>
                Contrase&ntilde;a  <br><br>
	</p>
</div>
    <img src="../plantilla/img/icons_docente/tip.png" alt="Correcto"> El usuario podr&aacute; acceder al aula con estos datos.<br>
    <img src="../plantilla/img/icons_docente/tip.png" alt="Correcto"> El usuario puede cambiar su contrase&ntilde;a desde su sesi&oacute;n.
</div>';
        }
     } 
     else{
         echo"<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> Verifique que los campos obligatorios est&eacute;n llenos correctamente";
     }
 }
}
else{
    echo "<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> Verifique que los campos obligatorios est&eacute;n llenos correctamente";
}
?>