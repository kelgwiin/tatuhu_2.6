<?php 
/*
* Estructura de la data de sesion:
* Array(
[logueado] = true|false
[usuario] =(             -->> Datos de Cuenta
    [activo] = SI|NO
    [cedula] = INT
    [tipo] = PROFESOR|ADMINISTRADOR|ESTUDIANTE
)
[persona] = (            -->> Datos Personales
    [cedula] = STRING
    [nombre] = STRING
    [apellido] = STRING
    [fecha_nacimiento] = STRING
    [correo] = STRING   
    [telefono] = STRING
    [sexo] =FEMENINO|MASCULINO
    [ruta_imagen] = STRING
)
[datos_educativos] = 
 * Si es estudiante
 * ([id_seccion] = INT
 *  [seccion] = STRING
 *  [id_grado] = INT 
 *  [grado] = STRING
 *  [id_colegio] = INT
 *  [colegio] = STRING
 * )
 * Si es Profesor
 * (
 * [id_seccion] 
 * [id_grado]
 * [id_colegio]
 * [seccion]
 * [grado]
 * [nombre_colegio]
 * ) -> por cada seccion que maneje el docente
)
* El password se recupera pero se borra por seguridad
*/

require '../../aula_tatu/config.php';
echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />";
if (isset($_POST['login']) && isset($_POST['pass']) && trim($_POST['login'])!='' && trim($_POST['pass'])!='') {
$query = mysql_query('SELECT activo,cedula,password,tipo FROM sist_usuario WHERE usuario="'.$_POST['login'].'"');
if (!$query) die('Error con la conexi&oacute;n a la base de datos, contacte al administrador del sistema');
if (mysql_num_rows($query) <= 0 ) {
    echo "Usuario no Registrado, si desea una cuenta haga clic en &iquest;C&oacute;mo solicitar una cuenta?";
}
else{
$usuario=mysql_fetch_assoc($query);
if($usuario["activo"] == "NO"){
        echo "Su cuenta est&aacute; desactivada, contacte con el administrador";
}
else{
if ((md5($_POST['pass']) == $usuario['password']) || $_POST['pass']==$usuario['password']) {
        $_SESSION['logueado']=true;
        unset($usuario['password']);
        $_SESSION['usuario']=$usuario;
        //Datos personales del usuario
        $query='SELECT A.cedula,A.nombre, A.apellido,A.fecha_nacimiento,A.correo,A.telefono,A.sexo,C.ruta_imagen
            FROM tbl_personas AS A, sist_usuario AS B,tbl_avatar AS C WHERE A.cedula=B.cedula AND A.cedula="'.$_SESSION['usuario']['cedula'].'"
                AND B.id_avatar=C.id_imagen';
                $qa0=mysql_query($query);
                if(!$qa0) die('Error en la construcci&oacute;n del Nombre de Usuario <br>Error: '.mysql_error().'</b><br>Informe al Administrador de Sistema');
                $persona=mysql_fetch_assoc($qa0);
                $_SESSION['persona']=$persona;
                
                $error = false;
                if($_SESSION['usuario']['tipo']=="ESTUDIANTE"){
                    //Si es estudiante, recuperamos a cual colegio y seccion pertenece
                     $query='SELECT A.id_seccion,B.id_grado,B.seccion,C.grado, D.id_colegio, D.nombre_colegio
                            FROM tbl_personas_seccion A, tbl_seccion B, sist_grado C, tbl_unidadeducativa D
                            WHERE A.id_persona="'.$_SESSION['persona']['cedula'].'" 
							AND A.id_seccion=B.id_seccion AND B.id_grado=C.id_grado
							AND B.id_colegio=D.id_colegio';
                    $qa0=mysql_query($query);
                    if(!$qa0) die('Error en la construcci&oacute;n del Nombre de Usuario <br>Error: '.mysql_error().'</b><br>Informe al Administrador de Sistema');
                    $seccion=mysql_fetch_assoc($qa0);
                    if( $seccion ){ 
                        $_SESSION['datos_educativos'] = $seccion;
                        //Interfaz
                       $query="SELECT * FROM tbl_areasaprendizaje 
                            WHERE id_grado='".$_SESSION['datos_educativos']['id_grado']."' AND activo = 'SI'";
                        $qa0=mysql_query($query);
                        if ($qa0 && mysql_num_rows($qa0)>0){
                            $areas = array();
                            $i = 0;
                            while(($area=mysql_fetch_assoc($qa0))!=false){
                                $areas[$i]["nombre_area"] = $area['area_aprendizaje'];
                                $areas[$i]["id_area"] = $area['id_area'];
                                $areas[$i]["imagen"] = "../uploadImages/AA/".$area['imagen'];
                                $i++;
                            }
                            $_SESSION["interfaz"]["areas"] = $areas;
                        }
                        else{
                           echo "El aula Tatu H&uacute; no se encuentra configurada, informe al Administrador";
                            $error = true; 
                        }
                        $query="SELECT * FROM tbl_areasaprendizaje 
                            WHERE id_grado='".$_SESSION['datos_educativos']['id_grado']."' AND activo = 'SI'";
                        $qa0=mysql_query($query);
                        if ($qa0 && mysql_num_rows($qa0)>0){
                            $query="SELECT * FROM sist_int_mensajesvalores WHERE 1  ORDER BY RAND( )  LIMIT 1";
                            $qa0=mysql_query($query);
                            $mensaje=mysql_fetch_assoc($qa0);
                            $_SESSION["interfaz"]["mensaje"] = $mensaje["mensaje"];
                        }
                    }
                    else{
                        echo "El estudiante no est&aacute; asignado a una secci&oacute;n, informe al Administrador";
                        $error = true;
                    }
                }
                else if ($_SESSION['usuario']['tipo']=="PROFESOR"){
                    //En el caso del docente se recupera las secciones/grados/escuelas Activos a su cargo
                    $query = 'SELECT A.id_seccion, A.id_colegio, A.id_grado, A.seccion, C.nombre_colegio, D.grado
                             FROM tbl_seccion A, tbl_personas_seccion B, tbl_unidadeducativa C, sist_grado D
                             WHERE B.id_persona='.$_SESSION['persona']['cedula'].' 
                             AND B.id_seccion = A.id_seccion AND A.activa="SI" AND A.id_colegio = C.id_colegio 
                             AND C.activo="ACTIVO" AND A.id_grado = D.id_grado AND D.activo="ACTIVO"';                    
                    $qa0=mysql_query($query);
                    if(!$qa0) die('Error en la construcci&oacute;n del Nombre de Usuario <br>Error: '.mysql_error().'</b><br>Informe al Administrador de Sistema');
                    if (mysql_num_rows($qa0)>0){
                        $i = 0;
                        while($s=mysql_fetch_assoc($qa0)){
                            $seccion[$i]["id_seccion"] = $s["id_seccion"];
                            $seccion[$i]["nombre_seccion"] = $s["seccion"];
                            $seccion[$i]["id_grado"] = $s["id_grado"];
                            $seccion[$i]["nombre_grado"] = $s["grado"];
                            $seccion[$i]["id_colegio"] = $s["id_colegio"];
                            $seccion[$i]["nombre_colegio"] = $s["nombre_colegio"];
                            $i++;
                        }
                        $_SESSION['datos_educativos'] = $seccion;
                    }
                    else{
                        $error = true;
                        echo "No tiene asignadas secciones, o sus secciones est&aacute;n inhabilitadas. Informe al administrador del sistema";
                    }
                    
                }
               /* else if ($_SESSION['usuario']['tipo']=="ADMINISTRADOR DE ESCUELA"){
                    $query = 'SELECT A.id_escuela, B.nombre_colegio 
                              FROM tbl_adminescuela A, tbl_unidadeducativa B
                              WHERE A.id_persona = "'.$_SESSION['persona']['cedula'].'" 
                              AND A.id_escuela= B.id_colegio AND B.activo="ACTIVO"'; 
                    $qa0=mysql_query($query);
                    if(!$qa0) die('Error en la construcci&oacute;n del Nombre de Usuario <br>Error: '.mysql_error().'</b><br>Informe al Administrador de Sistema');
                     if (mysql_num_rows($qa0)>0){
                         $seccion=mysql_fetch_assoc($qa0);
                         $_SESSION['datos_educativos'] = $seccion;
                     }
                    else{
                        $error = true;
                        echo "No tiene asignado un Instituto Educativo, o su Instituto est&aacute; inhabilitado. Informe al administrador del sistema";
                    }
                }*/
                if(!$error)
                    echo "<script language='javascript'>window.location='../../aula_tatu/index.php'</script>";
        }
        else{
                echo "Combinaci&oacute;n Nombre de Usuario - Contrase&ntilde;a Incorrecta";
        }
}
}

}
?>