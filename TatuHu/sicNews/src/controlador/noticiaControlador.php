<?php
require_once('/../noticia/noticiaDAO.php');

if(isset($_GET['modo'])){
	$modo = $_GET['modo'];
}

switch ($modo){
    
    //modo guardar
    case 1:
        
        $noticia = new noticia();
        $noticia->setDirec("casa");
        $noticia->setNomb("nombre");
        echo $noticia->getDir();
        /*
        $noticiaDAO = new noticiaDAO();
        $band = $noticiaDAO->guardar($noticia);
        echo $band;
        */
    break;

    case 2:
        //$direccion = $_REQUEST['ntcDir'];
        echo "casita";
    break;    
}
?>
