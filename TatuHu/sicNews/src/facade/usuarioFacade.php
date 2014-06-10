<?php     
error_reporting(0);
require_once('../usuario/usuarioDAO.php');

if(isset($_REQUEST['modo'])){
	$modo = $_REQUEST['modo'];
}
    switch ($modo) {
        //MODO GUARDAR
        case 1:
            //echo 1;
            if($_REQUEST['loginUsu']){

                $usu    = new usuario();
                $usuDAO = new usuarioDAO();   

                $usu->setNombre($_REQUEST['nombreUsu']);
                $usu->setUser($_REQUEST['loginUsu']);
                $usu->setPass($_REQUEST['passUsu']);
                $usu->setCorreo($_REQUEST['emailUsu']);
                $usu->setPregunta($_REQUEST['preguntaUsu']);
                $usu->setRespuesta($_REQUEST['respuestaUsu']);
                $usu->setTipo($_REQUEST['tipoUsu']);

                echo $usuDAO->agregar($usu);
            }

        break;
        //Modo Inicio Sesion
        case 2:
            
            if($_REQUEST['loginUsu']){
                //si existe login vengo de inicio de sesion...			
                $usu    = new usuario();
                $usuDAO = new usuarioDAO();                
                $usu->setPass(trim($_REQUEST['passUsu']));				
                $usu->setUser(trim($_REQUEST['loginUsu']));                
                $usResp = $usuDAO->consultarLogin($usu);
                if($usResp == 1){
                    $usuDAO->actualiza_cookie();
                }
                echo $usResp;		
            }
        break;
        //Consultar Usuarios
        case 3:
            $usuDAO = new usuarioDAO();            
            echo json_encode($usuDAO->consultarTodos());
        break;
        //Cambiar estatus usuario (ACTIVO/INACTIVO)
        case 4:
            if(isset($_REQUEST['idUser'])){
                $usuDAO = new usuarioDAO();            
                echo $usuDAO->setStatus($_REQUEST['idUser'], $_REQUEST['status']);
            }
        break;
        //Eliminar Usuario
        case 5:
            if(isset($_REQUEST['idUser'])){
                $usuDAO = new usuarioDAO();            
                echo $usuDAO->eliminar($_REQUEST['idUser']);   
            }
        break;
        //Editar Usuario
        case 6:
            if(isset($_REQUEST['name'])){
                $usuDAO = new usuarioDAO();  
                if($_REQUEST['name'] == 'user' && $usuDAO->existeUser(trim($_REQUEST['value'])) > 0)
                    echo -1;
                elseif($_REQUEST['name'] == 'pass_usu' && strlen(trim($_REQUEST['value'])) < 8){
                    echo -1;
                }
                else
                    echo $usuDAO->updateField($_REQUEST['name'],trim($_REQUEST['value']), $_REQUEST['pk']);  
            }
        break;
        //Cerrar Sesion
        case 7:
            setcookie("idsession","",0,"/");
            session_start();

            $_SESSION['nombre'] = "";
            $_SESSION['login'] = "";
            $_SESSION['tipoUs'] = 3;
            $_SESSION['idUsu'] = "";

            session_destroy();
            echo 1;
        break;
        
    }

?>
