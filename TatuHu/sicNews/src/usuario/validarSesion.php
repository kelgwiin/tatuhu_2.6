<?php
    error_reporting(0);
    //require_once '../src/usuario/usuarioDAO.php';
    //require_once('/usuarioDAO.php');

    function salir(){
        setcookie("idsession","",0,"/");
        session_start();
        
        $_SESSION['nombre'] = "";
        $_SESSION['login'] = "";
        $_SESSION['tipoUs'] = 3;
        $_SESSION['idUsu'] = "";
                
        session_destroy();
        echo "<script> window.parent.location = ''</script>";

    }
    //salir();
    if($_GET['logout']=="yes"){
            salir();
    }
	
    function validar_sesion(){
        //return isset($_COOKIE['idsession']);
        //return $_SERVER['PHP_SELF'];
        if (isset($_COOKIE['idsession'])){
            $idsession = $_COOKIE['idsession'];
            session_start();
            $valor = strcmp($idsession,session_id());

            /*if($valor == 0){
                    //require_once 'usuarioDAO.php';
                    //$UsuarioDAO = new usuarioDAO();
                    //$UsuarioDAO->actualiza_cookie();
            }*/
            return $valor;
        }
        else{
            return 3;
        }
    }
    
    function bloqueo_url(){
        $band = true;
        if (isset($_COOKIE['idsession'])){
            return 1;
        }
        else{            
            header("Location: ../msj_error/acceso_denegado.php");              
        }
    }

?>
