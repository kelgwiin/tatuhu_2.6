<?php     
    error_reporting(0);
    require_once('../parametro/parametroDAO.php');

    if(isset($_REQUEST['modo'])){
        $modo = $_REQUEST['modo'];
    }
    
    switch ($modo){
        //consultar datos
        case 1:
            $param = new parametroDAO();
            echo $param->consultarDatos();        
        break;
        //editar datos
        case 2:
            $param    = new parametro();
            $paramDAO = new parametroDAO();
            
            $param->setCritAgrup($_REQUEST['critAgp']);
            $param->setNivelBorr($_REQUEST['nivelB']);
            $param->setNumGrupos($_REQUEST['numGrup']);
            $param->setParam($_REQUEST['paramP']);
            $param->setProxy((isset($_REQUEST['proxy']) && !empty($_REQUEST['proxy']) ?$_REQUEST['proxy']:NULL));
            
            echo $paramDAO->editarParametros($param);
        break;
        //verificar noticias MOVER DE AQUI
        case 3:
            $paramDAO = new parametroDAO();
            $param    = new parametro();
            $param = $paramDAO->consultarValores();
            
            $total = $paramDAO->numNoticiasNuevas() - $param->getNumDocs();
            //if($total < 0)
                //$total = 0;//$total*(-1);
            
            echo $total;
        break;
    }
?>
