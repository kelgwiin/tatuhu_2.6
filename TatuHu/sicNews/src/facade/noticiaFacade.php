<?php     
    error_reporting(0);
    require_once('../noticia/noticiaDAO.php');
    require_once('../limpieza/limpiezaDAO.php');
    require_once('../parametro/parametroDAO.php');

    if(isset($_REQUEST['modo'])){
        $modo = $_REQUEST['modo'];
    }
    
    switch ($modo){
        //consultar noticias
        case 1:
            $noticiaDAO = new noticiaDAO();    
            $vector = $noticiaDAO->consultarTodo();
            
            echo json_encode($vector);
        break;
        //consultar Numero de Noticias
        case 2:
            $ntcDAO = new noticiaDAO();    
            echo $ntcDAO->numNoticias();
        break;
        //llamado desde Agrupar - Consultar Fechas de Noticias
        case 3:
            $fechas = new noticiaDAO();
            $fechas->consultarFechas($_REQUEST['cantDocs']);
            echo $fechas->rangoFecha($_REQUEST['cantDocs']);
            
        break;
        case 4:
            $fechas = new noticiaDAO();
            echo $fechas->insertarFechas($_REQUEST['fech']);
        break;
        //Consultar Contenido Noticia, llamado desde Busqueda.php
        case 5:
            $id = $_REQUEST['idNoticia'];
            $noticia = new noticiaDAO();
            echo $noticia->contenidoNoticia($id);
            
        break;
        //Guardar Html de noticias - llamado desde Carga.php
        case 6:
            
            $list = $_REQUEST['vectNotc'];
            $tittles = explode("##",$_REQUEST['titulos']);
            $fechaPub = $_REQUEST['fechPub'];
            $vect = explode(",", $list);
//print_r($vect);            
//exit();
            $limpiar = new limpiezaDAO();
            //Limpiando Documentos
            for($i=0;$i<count($vect);$i++){ 
                
                $titulo = $tittles[$i];//str_replace('/','',strrchr($vect[$i],"/")); 
                $titulo_ruta = $titulo;
                

                $targetPath = $_SERVER['DOCUMENT_ROOT'].'/';    
                $route = $_SERVER['PHP_SELF'];
                $route[0] = "";
		//echo var_dump("TARGETPATH: " . $targetPath);
		//echo var_dump("ROUTE: " . $route);
                //$ruta = $targetPath.substr($route,0,strpos($route,'/'));
                //echo var_dump("RUTA: " . $ruta);
		$ruta = $_SERVER['DOCUMENT_ROOT'].'/sicNews';
$auth = base64_encode(':');

$aContext = array(
    'http' => array(
        'proxy' => 'tcp://190.170.87.230:3128',
        'request_fulluri' => true,
        'header' => "Proxy-Authorization: Basic $auth",
    ),
);
$cxContext = stream_context_create($aContext);

// Open the file using the HTTP headers set above
$contenido = file_get_contents($vect[$i], false, $cxContext);
                //$contenido = file_get_contents($vect[$i]);
		//echo var_dump($vect[$i]); echo var_dump($contenido); exit();

                $html = $contenido;
                
                //Eliminando etiquetas HTML
                $contenido  = $limpiar->elimiarEtiquetasHtml($contenido);
                //$textoCompleto = $contenido;
                
                //Buscando posibles Fechas
                $result = $limpiar->posiblesFechas($contenido);
                $contenido = $result[0];
                $lineaFchas = $result[1];
                //Eliminando Acentos
                $contenido  = $limpiar->eliminarAcentos($contenido);
                $titulo     = $limpiar->eliminarAcentos($titulo);
                //Eliminando Simbolos
                $contenido  = $limpiar->eliminarSimbolos($contenido);
                $titulo     = $limpiar->eliminarSimbolos($titulo);
                //Eliminando '\'
                $contenido  = stripslashes($contenido);
                $titulo     = stripslashes($titulo);    
                
                $acentos    = $limpiar->obtenerListaAcentos2();
                
                //Eliminando Otros Acentos
                //$contenido  = utf8_encode((strtr($contenido,utf8_decode($acentos[0]),$acentos[1])));
                //$titulo     = utf8_encode((strtr($titulo,utf8_decode($acentos[0]),$acentos[1])));
                
                //Eliminando StopWords
                $contenido  = $limpiar->eliminarStopWords($contenido);
                //$titulo     = $limpiar->eliminarStopWords($titulo);
                //
                //FIN LIMPIEZA

                echo var_dump("noticiaFacade.php CONTENIDO");
		echo var_dump($contenido);
                //$result = $limpiar->posiblesFechas($contenido);
                //$contenido = $result[0];
                //$lineaFchas = $result[1];
		echo var_dump("noticiaFacade.php FIN LIMPIEZA");
		print_r($result);
                
                $titulo_ruta = str_replace(' ','-',$titulo); 
                
                //Guardando archivo HTML
                $id  = fopen("../../web/files/files_mostrar/".$titulo_ruta.".html",'w+');
                fwrite($id, $html);
		//echo var_dump($html); exit();
                fclose($id); 
                
                //Guardando archivo TXT
                $id  = fopen("../../web/files/".$titulo_ruta.".txt",'w+');
                fwrite($id, $contenido);
		//echo var_dump($contenido); exit();
                fclose($id);
                
                $rutaHtml = $ruta."/web/files/files_mostrar/".$titulo_ruta.".html";
                $direc    = $ruta."/web/files/".$titulo_ruta.".txt";
                
                $noticia = new noticia();
                $noticiaDAO = new noticiaDAO();
                $noticia->setDirHtml($rutaHtml);
                $noticia->setDirec($direc);
                $noticia->setNomb($titulo);
                $noticia->setDirPag($vect[$i]);                               
                
                $noticiaDAO->guardar($noticia);
                $numNotc = new parametroDAO();
                $numNotc->modificarNumDocs($noticiaDAO->numNoticias());  
                $noticiaDAO->guardarListaFechas($lineaFchas,$direc);             
            }
            
            /*for($i=0;$i<count($vect);$i++){                
                $titulo = str_replace('/','',strrchr($vect[$i],"/"));                    
                $pag = file_get_contents($vect[$i]);
                $id  = fopen("../noticias_web/".$titulo.".html",'w+');
                fwrite($id, $pag);
                fclose($id);                
            }  */          
            echo $acentos;//$ruta;
        break;
        
        //Listar Noticias
        case 7:
            
            $noticia    = new noticia();
            $noticiaDAO = new noticiaDAO();    
            $vector = $noticiaDAO->consultarTodo();
            
            $cdg .= "<table>";
            for($i=0;$i<count($vector);$i++){
                
                $noticia = $vector[$i];
                $cdg .= "<tr><td>";
                $cdg .= "<input type=\"checkbox\" id=\"id".$i."\" name=\"checkbox\" value=\"".$noticia->getId()."\" /> ".$noticia->getNomb();
                $cdg .= "</tr></td>";
            }            
            $cdg .= "</table>";
            
            if(count($vector)<1){
                $cdg = -1;
            }
            
            echo $cdg;
        break;
        
        //Eliminar Noticias
        case 8:
            
            $listNotc = $_REQUEST['vectNotc'];
            $vectNotc = explode(",", $listNotc);
            
            $noticiaDAO = new noticiaDAO();
            echo $noticiaDAO->eliminar($vectNotc);
            
        break;
    }
?>