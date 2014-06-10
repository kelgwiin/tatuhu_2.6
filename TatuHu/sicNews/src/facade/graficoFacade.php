<?php
    error_reporting(0);
    require '../grafico/graficoDAO.php';
    require '../noticia/noticiaDAO.php';
    require '../grupo/grupoDAO.php';
    require '../cluster/tf_idfDAO.php';
    require_once '../../web/js/jpgraph/src/jpgraph.php';
    require_once '../../web/js/jpgraph/src/jpgraph_scatter.php';

if(isset($_REQUEST['modo'])){
        $modo = $_REQUEST['modo'];
}
                         //(año,mes)
$fechaInicioGeneral = array(2000,1);
$fechaFinGeneral    = array((date("o")+1),12);
switch ($modo){
    //Grafico por Palabras
    case 1:        
        
        $idGrupo = $_REQUEST['idGrup'];
        $fechas  = $_REQUEST['fech'];
        $ids     = $_REQUEST['idNot'];  
        $rango   = $_REQUEST['rang'];  
        $palClav = $_REQUEST['pClv'];
        $leyenda = $_REQUEST['leyda'];
        $tema    = $_REQUEST['temaG'];
        
        $ids      = trim($ids);
        $vectId   = explode(" ", $ids);
        $vectFech = explode("<>", $fechas);

        $fechaIni = explode("-", $vectFech[0]);
        $fechaFin = explode("-", $vectFech[1]);
        
        $ntcDAO = new noticiaDAO();
        $ntcExt = new noticia_ext();
        $grupoDAO = new grupoDAO();
        $grupo    = new grupo();
        $ObjTf_IdfDAO = new tf_idfDAO();
        
        $vectPal = explode(" ", $palClav);
        $vectLey = explode(" ", $leyenda);
        
        for($j=0;$j<count($vectPal);$j++){
            $w=0;
            for($i=0;$i<count($vectId);$i++){
                $ntcExt = $ntcDAO->consultarFechaNoticia($vectId[$i]);
                $vechFechIni = explode("-", $ntcExt->getFechaInicio());
                if($vechFechIni[0] != '0000'){
                    $datax[$j][$w] = $vechFechIni[$rango];
                    //$datax[$j][$i] = $vechFechIni[$rango];
                    //$pert .= $datax[$i]." - ";  
                    //$grupo = $grupoDAO->consultarDatos($vectId[$i], $idGrupo);
                    //$datay[$i] = $grupo->getPertinencia();
                    ${"datay".$j}[$w] = $ObjTf_IdfDAO->valorTermino($vectId[$i],$vectPal[$j]);   
                    $w++;
                }
            } 
        }

        $graph = new Graph(400,300);
        //Si el rango de fecha es abierto
        if(($fechaIni[0] == "0000") && ($fechaFin[0] == "9999")){
            $graph->SetScale("intlin",0,1);
        }
        else{            
            //Si solo consulto fecha inicial
            if(($fechaIni[0] != "0000") && ($fechaFin[0] == "9999")){
                $graph->SetScale("intlin",0,1,($fechaIni[$rango]-1),$fechaFinGeneral[$rango]);        
            }
            else{
                //Si solo consulto fecha final
                if(($fechaIni[0] == "0000") && ($fechaFin[0] != "9999")){
                    $graph->SetScale("intlin",0,1,$fechaInicioGeneral[$rango],(1+$fechaFin[$rango]));
                }
                else{
                    //Si solo consulto un rango fecha
                    $graph->SetScale("intlin",0,1,($fechaIni[$rango]-1),(1+$fechaFin[$rango]));
                }
            }
        }
        if($rango == 1){
            $graph->xaxis->title->Set("MESES");
        }
        else{
            $graph->xaxis->title->Set("AÑOS");
        }
        
	$graph->yaxis->title->Set("RELEVANCIA");

        $graph->img->SetMargin(40,40,40,40);        
        $graph->SetShadow();

        $graph->title->Set("Grupo ".$tema);
        $graph->title->SetFont(FF_FONT1,FS_BOLD);

        
        $lisColors = array("blue","brown","orange","green","red","yellow","violet");
        $listMarcos = array(MARK_FILLEDCIRCLE,MARK_DIAMOND,MARK_SQUARE,MARK_DTRIANGLE,MARK_X,MARK_CROSS);
        
        for($i=0;$i<count($vectPal);$i++){

            ${"sp".$i} = new ScatterPlot(${"datay".$i},$datax[$i]);
            ${"sp".$i}->mark->SetType($listMarcos[$i]);
            ${"sp".$i}->mark->SetFillColor($lisColors[$i]);
            ${"sp".$i}->mark->SetWidth(8);
            ${"sp".$i}->SetLegend($vectLey[$i]);
            //SetLegend
            $graph->Add(${"sp".$i});
        }
        $graph->Stroke();

    break;
    //Grafico General
    case 2:
        $cantGrups = $_REQUEST['numGrup'];
        $fechas  = $_REQUEST['fech'];
        $ids     = $_REQUEST['idNot'];  
        $rango   = $_REQUEST['rang'];  
        
        $ids      = trim($ids);
        $vectFech = explode("<>", $fechas);
        $vechFechFin = explode("-", $vectFech[1]);
        
        $fechaIni = explode("-", $vectFech[0]);
        $fechaFin = explode("-", $vectFech[1]);
        
        
        $ntcDAO = new noticiaDAO();
        $ntcExt = new noticia_ext();
        $grupoDAO = new grupoDAO();
        $grupo    = new grupo();
        $ObjTf_IdfDAO = new tf_idfDAO();
        
        for($j=1;$j<=$cantGrups;$j++){
        
            $vectGrup2 = $grupoDAO->consultarGrupo3($j);   
            $vectGrup = $grupoDAO->consultarGrupoRango($j,$vectFech[0],$vectFech[1]);
            
            for($i=0;$i<count($vectGrup);$i++){
                $vectId[$i] = $vectGrup2[$i]->getId();                
                //$vectId[$i] = $vectGrup[$i];
            }
            unset($vectGrup2);

            $palabra = $ObjTf_IdfDAO->palabraRelevanteGrupo($vectId); //RELEVANCIA POR GRUPO COMPLETO
            //$palabra = $ObjTf_IdfDAO->palabraRelevanteGrupo($vectGrup); //RELEVANCIA POR DOCUMENTOS RECUPERADOS
            if($palabra == 'danos'){
                $palabra = 'daños';                
            }
            $vectP[$j] = $palabra;
            $w=0;
            for($i=0;$i<count($vectGrup);$i++){
                $ntcExt = $ntcDAO->consultarFechaNoticia($vectGrup[$i]);
                $vechFechIni = explode("-", $ntcExt->getFechaInicio());
                if($vechFechIni[0] != '0000'){
                    $datax[$j][$w] = $vechFechIni[$rango];
                    unset ($vechFechIni);
                    ${"datay".$j}[$w] = $ObjTf_IdfDAO->valorTermino($vectGrup[$i],$palabra);
                    $w++;
                }
            }
            unset($vectId);
            unset ($vectGrup);
        }      
       
        $graph = new Graph(400,300);     
        
        //Si el rango de fecha es abierto
        if(($fechaIni[0] == "0000") && ($fechaFin[0] == "9999")){
            $graph->SetScale("intlin",0,1);
        }
        else{            
            //Si solo consulto fecha inicial
            if(($fechaIni[0] != "0000") && ($fechaFin[0] == "9999")){
                $graph->SetScale("intlin",0,1,($fechaIni[$rango]-1),$fechaFinGeneral[$rango]);        
            }
            else{
                //Si solo consulto fecha final
                if(($fechaIni[0] == "0000") && ($fechaFin[0] != "9999")){
                    $graph->SetScale("intlin",0,1,$fechaInicioGeneral[$rango],(1+$fechaFin[$rango]));
                }
                else{
                    //Si solo consulto un rango fecha
                    $graph->SetScale("intlin",0,1,($fechaIni[$rango]-1),(1+$fechaFin[$rango]));
                }
            }
        }
        
        //$graph->xaxis->title->Set("Fecha");
        if($rango == 1){
            $graph->xaxis->title->Set("MESES");
        }
        else{
            $graph->xaxis->title->Set("AÑOS");
        }
        
	$graph->yaxis->title->Set("RELEVANCIA");

        $graph->img->SetMargin(40,40,40,40);        
        $graph->SetShadow();
        if($rango == 0){
            $graph->title->Set("Grafico de noticias Anual");            
        }
        else{
            $graph->title->Set("Grafico de noticias por Meses");      
        }

        $graph->title->SetFont(FF_FONT1,FS_BOLD);

        $lisColors = array("blue","brown","orange","green","red","yellow","violet");
        $listMarcos = array(MARK_FILLEDCIRCLE,MARK_DIAMOND,MARK_SQUARE,MARK_DTRIANGLE,MARK_X,MARK_CROSS);

        for($i=1;$i<=$cantGrups;$i++){

            ${"sp".$i} = new ScatterPlot(${"datay".$i},$datax[$i]);
            ${"sp".$i}->mark->SetType($listMarcos[$i-1]);
            ${"sp".$i}->mark->SetFillColor($lisColors[$i-1]);
            ${"sp".$i}->mark->SetWidth(8);
            ${"sp".$i}->SetLegend($vectP[$i]);
            //SetLegend
            $graph->Add(${"sp".$i});
        }
        $graph->Stroke();
        //echo $pert;
    break;
    
    case 3:
        
        $grupoDAO = new grupoDAO();
        $ObjTf_IdfDAO = new tf_idfDAO();
        
        $numGrup = $_REQUEST['numGrups'];
        for($j=1;$j<=$numGrup;$j++){        
            $vectGrup = $grupoDAO->consultarGrupo3($j);   
            for($i=0;$i<count($vectGrup);$i++){
                $vectId[$i] = $vectGrup[$i]->getId();                
            }
            
            //$palabra .= "\n\n";//$ObjTf_IdfDAO->palabraRelevanteGrupo($vectId)."\n\n"; 
            if($ObjTf_IdfDAO->palabraRelevanteGrupo($vectId) == 'danos'){
                $palabra .= 'daños\n\n'; 
            }
            else{
                $palabra .= $ObjTf_IdfDAO->palabraRelevanteGrupo($vectId)."\n\n"; 
            }
            
            unset($vectGrup);
            unset($vectId);
        }
        
        echo $palabra;
        
    break;
    //Limpiar palabras de busqueda para graficar
    case 4:
        
        $listaPala = $_REQUEST['palabras'];        
        //---------LIMPIEZA----------//
        $listCaracteres  = file_get_contents('../limpieza/acentos_1.txt');
        $vectCaract = explode("\n", $listCaracteres);
        for($i=0;$i<count($vectCaract);$i++){
            $aux = explode(" ", $vectCaract[$i]);
            $listaPala = str_replace($aux[0],$aux[1],$listaPala);
        }
            
        $listCaracteres  = file_get_contents('../limpieza/acentos_2.txt');
        $vectCaract = explode("\n", $listCaracteres);
        $aux = explode(" ", $vectCaract[0]);
        $acentos = explode(" ", $vectCaract[1]);
        $listaPala =  strtr(strtolower($listaPala), $aux[0],$aux[1]);

        $listCaracteres  = file_get_contents('../limpieza/acentos_3.txt');
        $vectCaract = explode("\n", $listCaracteres);
        for($i=0;$i<count($vectCaract);$i++){
            $aux = explode(" ", $vectCaract[$i]);
            $listaPala = str_replace($aux[0],$aux[1],$listaPala);
        }
        //Eliminando Simbolos
        $listCaracteres  = file_get_contents('../limpieza/simbolos.txt');
        $vectCaract = explode("\n", $listCaracteres);
        for($i=0;$i<count($vectCaract);$i++){
            $listaPala = str_replace($vectCaract[$i]," ",$listaPala);
        }       
        //---------FIN LIMPIEZA----------//
        echo $listaPala;
    break;
    //Años de noticias Consultadas
    case 5:        
        
        $ntcDAO = new noticiaDAO();
        $ntcExt = new noticia_ext();

        $ids     = $_REQUEST['idNot'];          
        $ids      = trim($ids);
        $vectId   = explode(" ", $ids);

        $fechas = "";
        $w = 0;
        for($i=0;$i<count($vectId);$i++){
            
            $ntcExt = $ntcDAO->consultarFechaNoticia($vectId[$i]);
            $vechFechIni = explode("-", $ntcExt->getFechaInicio());
            
            if($vechFechIni[0] != '0000'){                
                $fechas[$w] = $vechFechIni[0].$vechFechIni[1];
                $w++;
            }
        } 
        
        sort($fechas);
        for($i=0;$i<count($fechas);$i++){
            $result .= trim(substr($fechas[$i],0,-2))."-".trim(substr($fechas[$i],-2))."\n";
        }
        
        echo $result;
        
        
    break;
    
    case 6:

        $fechas  = $_REQUEST['fech'];
        $rango = 1;
        
        $ntcDAO = new noticiaDAO();
        $ntcExt = new noticia_ext();
        $grupoDAO = new grupoDAO();
        $grupo    = new grupo();
        $ObjTf_IdfDAO = new tf_idfDAO();
        $vectNoticias  = array();                
                
        $vectNoticias = $ntcDAO->conultarAño($fechas);
        for($i=0;$i<count($vectNoticias);$i++){  
            $vectId[$i] = $vectNoticias[$i]->getId();
        }
        $palabra = $ObjTf_IdfDAO->palabraRelevanteGrupo($vectId); //RELEVANCIA POR GRUPO COMPLETO
        if($palabra == 'danos'){
            $palabra = 'daños';                
        }
        
        for($i=0;$i<count($vectId);$i++){        
            $vechFechIni = explode("-", $vectNoticias[$i]->getFechaInicio());
            $datax[$i] = $vechFechIni[$rango];
            unset ($vechFechIni);
            $datay[$i] = $ObjTf_IdfDAO->valorTermino($vectId[$i],$palabra);
            //$resp .=   ${"datay".$i}." ";
        }
       
        $graph = new Graph(400,300);     

        $graph->SetScale("intlin",0,1,1,12);
        //$graph->xaxis->title->Set("Fecha");
        if($rango == 1){
            $graph->xaxis->title->Set("MESES");
        }
        else{
            $graph->xaxis->title->Set("AÑOS");
        }
        
	$graph->yaxis->title->Set("RELEVANCIA");

        $graph->img->SetMargin(40,40,40,40);        
        $graph->SetShadow();
        if($rango == 0){
            $graph->title->Set("Grafico de noticias Anual");            
        }
        else{
            $graph->title->Set("Detalle del anio ".$fechas);      
        }

        $graph->title->SetFont(FF_FONT1,FS_BOLD);

        $lisColors = array("blue","brown","orange","green","red","yellow","violet");
        //$listMarcos = array(MARK_FILLEDCIRCLE,MARK_DIAMOND,MARK_SQUARE,MARK_DTRIANGLE,MARK_X,MARK_CROSS);
        $listMarcos = MARK_FILLEDCIRCLE;
        $lisColors = "blue";
        //for($i=1;$i<=$cantGrups;$i++){
        $sp =  new ScatterPlot($datay,$datax);
        $sp->mark->SetType($listMarcos);
        $sp->mark->SetFillColor($lisColors);
        $sp->mark->SetWidth(8);
        $sp->SetLegend($palabra);
        $graph->Add($sp);
        
            //${"sp".$i} = new ScatterPlot($datay,$datax);
            //${"sp".$i}->mark->SetType($listMarcos[$i-1]);
            //${"sp".$i}->mark->SetFillColor($lisColors[$i-1]);
            //${"sp".$i}->mark->SetWidth(8);
            //${"sp".$i}->SetLegend($vectP[$i]);
            //SetLegend
            //$graph->Add(${"sp".$i});
        //}
        $graph->Stroke();
        //echo $resp;
    break;
    
    case 7:           
        $idGrupo = $_REQUEST['idGrup'];
        $fechas  = $_REQUEST['fech'];
        $palClav = $_REQUEST['pClv'];
        $leyenda = $_REQUEST['leyda'];
        $tema    = $_REQUEST['temaG'];
        
        $rango = 1;
        
        
        $ntcDAO = new noticiaDAO();
        $ntcExt = new noticia_ext();
        $grupoDAO = new grupoDAO();
        $grupo    = new grupo();
        $ObjTf_IdfDAO = new tf_idfDAO();
        
        $vectPal = explode(" ", $palClav);
        $vectLey = explode(" ", $leyenda);
        
        
        $vectNoticias = $ntcDAO->conultarAño($fechas);
        for($i=0;$i<count($vectNoticias);$i++){  
            $vectId[$i] = $vectNoticias[$i]->getId();
        }
        //$palabra = $ObjTf_IdfDAO->palabraRelevanteGrupo($vectId); //RELEVANCIA POR GRUPO COMPLETO
        
        
        for($j=0;$j<count($vectPal);$j++){
            $w=0;
            for($i=0;$i<count($vectId);$i++){
                //$ntcExt = $ntcDAO->consultarFechaNoticia($vectId[$i]);
                $vechFechIni = explode("-", $vectNoticias[$i]->getFechaInicio());
                $datax[$j][$w] = $vechFechIni[$rango];
                ${"datay".$j}[$w] = $ObjTf_IdfDAO->valorTermino($vectId[$i],$vectPal[$j]);   
                $resp .=   ${"datay".$j}[$w] ." ";
                $w++;               
            } 
        }
              
        

        $graph = new Graph(400,300);
        $graph->SetScale("intlin",0,1,1,12);
        
        if($rango == 1){
            $graph->xaxis->title->Set("MESES");
        }
        else{
            $graph->xaxis->title->Set("AÑOS");
        }
        
	$graph->yaxis->title->Set("RELEVANCIA");

        $graph->img->SetMargin(40,40,40,40);        
        $graph->SetShadow();

        $graph->title->Set("Grupo ".$tema);
        $graph->title->SetFont(FF_FONT1,FS_BOLD);

        
        $lisColors = array("blue","brown","orange","green","red","yellow","violet");
        $listMarcos = array(MARK_FILLEDCIRCLE,MARK_DIAMOND,MARK_SQUARE,MARK_DTRIANGLE,MARK_X,MARK_CROSS);
        
        for($i=0;$i<count($vectPal);$i++){

            ${"sp".$i} = new ScatterPlot(${"datay".$i},$datax[$i]);
            ${"sp".$i}->mark->SetType($listMarcos[$i]);
            ${"sp".$i}->mark->SetFillColor($lisColors[$i]);
            ${"sp".$i}->mark->SetWidth(8);
            ${"sp".$i}->SetLegend($vectLey[$i]);
            //SetLegend
            $graph->Add(${"sp".$i});
        }
        $graph->Stroke();
        //echo $resp;
    break;
    //Consulta de datos para grafico Highstock (CONSULTA GENERAL)
    case 8:
        header('Content-Type: text/javascript');  
  
        $ntcDAO = new noticiaDAO();
        $ntcExt = new noticia_ext();
        $ObjTf_IdfDAO = new tf_idfDAO();

        $namearray = explode(' ', $_REQUEST['name']);
        $name     = $namearray[0];
        $ids      = $_REQUEST['idNot'];          
        $ids      = trim($ids);
        $vectId   = explode("-", $ids);

        $fechas = "";
        $w = 0;
        //Buscar fechas (eje x)
        for($i=0;$i<count($vectId);$i++){            
            $ntcExt = $ntcDAO->consultarFechaNoticia($vectId[$i]);
            $vechFechIni = explode("-", $ntcExt->getFechaInicio());

            if($vechFechIni[0] != ' '  && $vechFechIni[0] != ''  && $vechFechIni[0] != '0000' && $vechFechIni[0] != '000' && $vechFechIni[1] != '00'  && $vechFechIni[2] != '00'){                
                $x = mktime(0,0,0,$vechFechIni[2],$vechFechIni[1],$vechFechIni[0]);
                if($x."000" != "000")
                    $array[$i] = $x."000";           
            }
        } 
        //Ordenar fechas 
        asort($array);
        //Buscar valor de fecha (eje y)
        foreach ($array as $key => $value) {
            $y = $ObjTf_IdfDAO->valorTermino($vectId[$key],$name);
            $fechas[] = "[".$value.",".$y."]"; 
        }
        echo "[".join($fechas, ',')."]";
        exit();
    break;
}
?>
