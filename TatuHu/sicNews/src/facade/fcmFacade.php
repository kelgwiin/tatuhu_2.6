<?php
    error_reporting(0);
    require '../noticia/noticiaDAO.php';
    require '../grupo/grupoDAO.php';
    require '../cluster/tf_idfDAO.php';
    require '../parametro/parametroDAO.php';

if(isset($_REQUEST['modo'])){
	$modo = $_REQUEST['modo'];
}

switch ($modo){
    
    //Obtener Vector Caracteristico
    case 1:
        
        $noticia        = new noticia();
        $noticiaDAO     = new noticiaDAO();
        $ObjTf_Idf      = new tf_idf();
        $ObjTf_IdfDAO   = new tf_idfDAO();                
        $arrayNtc       = $noticiaDAO->consultarTodo();        
        $cantDocs       = count($arrayNtc);

        set_time_limit(1200);    

        if($cantDocs > 0){

            $ObjTf_IdfDAO->vaciarListaTerm();

            for($w=0;$w<$cantDocs;$w++){

                $noticia        = $arrayNtc[$w];                       
                $vectNtc[$w]    = fopen($noticia->getDir(), 'r');
		//echo var_dump($noticia->getDir());
		//echo var_dump($vectNtc[$w]);
                $idNot          = $noticia->getId();
                $linea1         = explode(' ',fgets($vectNtc[$w], 6000)); //MAXIMO POR DOCUMENTOS 50000                
                fclose($vectNtc[$w]);
                for($y=0; $y<count($linea1);$y++){
                    if($linea1[$y] != ''){        
                        $ObjTf_Idf->setTermino($linea1[$y]);
                        //$ObjTf_Idf->setId_not($w+1);
                        $ObjTf_Idf->setId_not($idNot);
                        $ObjTf_IdfDAO->listaTerm($ObjTf_Idf);
                    }
                }            
                unset ($linea1);    
            }         
            unset ($vectNtc);        
            $ObjTf_IdfDAO->calcularTf_Ifd($cantDocs);
        }        
        echo 1;
    break;
    //calcular distEuclidiana - Llamado desde Busqueda.php
    case 2:
        
        $noticia    = new noticia_ext();
        $notc       = new noticiaDAO();
        $ObjTf_IdfDAO = new tf_idfDAO();
        $grupoDAO     = new grupoDAO();
        $grupo        = new grupo();
        
        $numGrupos = $_REQUEST['numGrups'];
        $listaPala = $_REQUEST['palabras'];
        $cantDocs  = $_REQUEST['numDocs'];
        $fchIni    = $_REQUEST['fechaIni'];
        $fchFin    = $_REQUEST['fechaFin'];
        
        $vecTerm = $notc->consultarTerminos();
        
        for($i=0;$i<count($vecTerm);$i++){
            $vectBusq[$i] = 0;
        }      
        
        //$vectPala = explode(",", $listaPala);
        $vectPala = explode(" ", $listaPala);
        for($i=0;$i<count($vectPala);$i++){
            $pos = array_search(trim($vectPala[$i]), $vecTerm);
            if($pos != FALSE){
                $vectBusq[$pos] = 0.8;
            }
            /*else{
                $vectBusq[$i] = 0.1;
            }*/
        }  
        $numT = count($vectPala);
        $mayor = 999;
        //$vectBusq = $ObjTf_IdfDAO->filaVectorCentr(3, TRUE);
        for($i=1;$i<=$numGrupos;$i++){

            //$dist = $ObjTf_IdfDAO->distEuclidiana($numT,$i,$j);
            $vectCent = $ObjTf_IdfDAO->filaVectorCentr($i, TRUE);
            $dist = 0;
            for($j=0;$j<count($vectBusq);$j++){
                $resta = $vectBusq[$j] - $vectCent[$j];
                $dist = $dist + pow($resta, 2);
            }
            $dist = sqrt($dist);
            //$valorDist .= $dist."\n";
            if($dist<$mayor){
                $mayor = $dist;
                $id_gp = $i;
            }
        }
        //$valorDist .= "Grupo:".$id_gp."\n";
        $k = 0;
        
        $docsGrup = $grupoDAO->consultarGrupo2($id_gp);
        //Calculando dist Euclidiana entre VectBusq y VectTerm por Docs
        for($i=0;$i<count($docsGrup);$i++){           
            $filaVectCarac = $ObjTf_IdfDAO->filaVectorCarac($docsGrup[$i]);            
            for($j=0;$j<count($vectBusq);$j++){
                $resta = $filaVectCarac[$j] - $vectBusq[$j];
                $dist  = $dist + pow($resta, 2);
            }
            $dist = sqrt($dist);    
            if($dist == 0)
                $dist = 0.000000000000001;
            
            $dist = $dist/count($vectBusq);
            $docs[$i] = $dist;
            /*if($dist < 0.0036){
                $vect[$k] = $i;    
                $k++;
            }*/
            unset($filaVectCarac);            
        }
        $prom = array_sum($docs)/count($docs);
        //$maximo = max($vect);
        $k = 0;
        for($i=0;$i<count($docsGrup);$i++){  
            if($docs[$i] <= $prom){
                $vect[$k] = $docsGrup[$i];    
                $k++;
            }
        }
        unset($docs);
        $k=0;
        $band = -1;
        
        $docs .= $id_gp."\n";
        for($i=0;$i<count($vect);$i++){  
            $noticia = $notc->consultarFechaNoticia($vect[$i]);            
            if(!((($noticia->getFechaInicio() < $fchIni) && ($noticia->getFechaFin() < $fchIni)) || (($noticia->getFechaInicio() > $fchFin) && ($noticia->getFechaFin() > $fchFin)))){
                //$docs[$k] = $noticia();                
                $docs .= $noticia->getId()." ".$noticia->getNomb()."##".$noticia->getDirHtml()."\n";
                $band = 1;
            }
        }     
        if($band == -1)
           $docs = $band;
      
        echo $docs;
        //echo $valorDist;
        
    break;    
    //Ver Grupos. Llamado desde Agrupar.php
    case 3:
        
        $numGrupos = $_REQUEST['cantGrup'];
        $cantDocs  = $_REQUEST['cantDocs'];

        $grupDAO  = new grupoDAO();
        $noticiaDAO = new noticiaDAO();
        $notc   = new noticia();
        $vect   = array();
        $arrayNtc = $noticiaDAO->consultarTodo();

        for($i=1; $i<=$numGrupos; $i++){
            $cont = 0;
            $vect = $grupDAO->consultarGrupo2($i);        
            $cdg .= "Grupo: ".$i."<br><br>";

            for($j=0; $j<count($vect); $j++){	
                $id = $vect[$j] - 1;
                $notc = $arrayNtc[$id];
                $cdg .= $notc->getNomb();
                $cdg .= "<br>";
                $cont++;
            }
            $cdg .= "<br>Docs en el grupo ".$i.": ".$cont;
            $cdg .= "<br><br>";
        }
        echo $cdg;
       
    break;
    //Calculo de Similitud Promedio - Llamado desde Agrupar.php
    case 4:
        
        $ObjTf_IdfDAO   = new tf_idfDAO();
        $numGrup  = $_REQUEST['cantGrup'];
        $cantDoc  = $_REQUEST['cantDocs'];
        $vectGrup = array();
        $Doc1     = array();
        $Doc2     = array();
        
        $grupDAO  = new grupoDAO();
        set_time_limit(1200);
        
        for($j=0;$j<$numGrup;$j++){
            
            $vectGrup = $grupDAO->consultarGrupo2($j+1);
            //$vectGrup = array(21,22,23,24,25,26,27,28,29,30);
            $nj  = count($vectGrup);
            $div = 1/pow($nj,2);
            $total2 = 0;
            //$njVect[$j] = $nj;
            
            for($ki=0;$ki<$nj;$ki++){
                
                $Doc1 = $ObjTf_IdfDAO->filaVectorCarac($vectGrup[$ki]);
                $normVect1 = $ObjTf_IdfDAO->calcularNorma($Doc1);
                $total1 = 0;
                
                for($kj=0;$kj<$nj;$kj++){
 
                    $Doc2 = $ObjTf_IdfDAO->filaVectorCarac($vectGrup[$kj]);
                    $normVect2 = $ObjTf_IdfDAO->calcularNorma($Doc2);
                    $numerador = $ObjTf_IdfDAO->calcularProducto($Doc1, $Doc2);                    
                    $denominador = $normVect1 * $normVect2;
                    $total1 = $total1 + ($numerador/$denominador);
                    //$dist .= $numerador/$denominador."\n";;
                }
                unset($Doc1);
                $total2 = $total2 + $total1;
                
            }
            //$ps[$j] = $div*$total2;
            $ps .= ($div*$total2)."\n";
        }
        /*$sum = 0;
        $cant = 0;
        for($j=0;$j<$numGrup;$j++){
            $sum = $sum+($njVect[$j] * $ps[$j]);
            $cant = $cant+$ps[$j];
        }*/
        
        echo $ps;    
        
    break;
    //Rrealizando Agrupamiento - Llamado desde Agrupar
    case 5:
        
        set_time_limit(3600);

        $valores    = new parametro();
        $valoresDAO = new parametroDAO();
        $fuzzy      = new grupoDAO();

        $numGrupos = $_REQUEST['numGrup'];
        $cantDocs  = $_REQUEST['nDocs'];
        //$nvlDifuso = $_REQUEST['NvlBorr'];
        //$parParada = $_REQUEST['paramP'];

        $numTerms = $valoresDAO->consultarNumTerm();

        $filaVectCarac  = array();
        $filaVectU      = array();
        $filaVectCent   = array();
        $band = false;
        $q = $_REQUEST['NvlBorr'];//$nvlDifuso; //1.19;
        $parametro = $_REQUEST['paramP'];//$parParada;

        if($numGrupos < $cantDocs){

            $ObjTf_Idf      = new tf_idf();
            $ObjTf_IdfDAO   = new tf_idfDAO();

            $ObjTf_IdfDAO->vaciarTablas(FALSE, TRUE, FALSE, FALSE); //($vCent, $matU, $lisT, $vCentAux)
            //$ObjTf_IdfDAO->vaciarTablas(TRUE, TRUE, FALSE, TRUE); //($vCent, $matU, $lisT, $vCentAux)
            //$ObjTf_IdfDAO->primeraConfig_centros($numGrupos,$cantDocs);

            $it = 0;
            while((!$band) && ($it<150)){

                $ObjTf_IdfDAO->vaciarTablas(FALSE, TRUE, FALSE, FALSE); //($vCent, $matU, $lisT, $vCentAux)
                for($i=1;$i<=$numGrupos;$i++){
                    for($j=1;$j<=$cantDocs;$j++){

                        $filaVectCarac = $ObjTf_IdfDAO->filaVectorCarac($j);
                        $filaVecCent   =  $ObjTf_IdfDAO->filaVectorCentr($i, TRUE);
                        //$dist = $ObjTf_IdfDAO->distEuclidiana($filaVectCarac,$i,$j);
                        //$dist = $ObjTf_IdfDAO->distEuclidiana($numTerms,$i,$j);     

                        $dist = 0;
                        for($jj=0;$jj<$numTerms;$jj++){
                            $resta = $filaVectCarac[$jj] - $filaVecCent[$jj];
                            $dist = $dist + pow($resta, 2);
                        }
                        $dist = sqrt($dist);

                        unset($filaVecCent);
                        $dist = pow($dist, 2);
                        $Unum = pow((1/$dist),(1/($q-1)));
                        $Udeno = 0.0;

                        for($w=1;$w<=$numGrupos;$w++){
                            //$dist = $ObjTf_IdfDAO->distEuclidiana($filaVectCarac,$w,$j);                         
                            //$dist = $ObjTf_IdfDAO->distEuclidiana($numTerms,$w,$j);
                            $filaVecCent   =  $ObjTf_IdfDAO->filaVectorCentr($w, TRUE);

                            $dist = 0;
                            for($jj=0;$jj<$numTerms;$jj++){
                                $resta = $filaVectCarac[$jj] - $filaVecCent[$jj];
                                $dist = $dist + pow($resta, 2);
                            }
                            $dist = sqrt($dist);

                            $dist = pow($dist, 2);
                            $Udeno = $Udeno + pow((1/$dist),(1/($q-1)));
                        }
                        unset($filaVecCent);
                        $ObjTf_IdfDAO->llenarU($i,$j,$Unum,$Udeno);
                        unset($filaVectCarac);                    
                    }
                } 

                $ObjTf_IdfDAO->vaciarTablas(TRUE, FALSE, FALSE, FALSE); //($vCent, $matU, $lisT, $vCentAux)

                //Actualizar Centros
                for($i=1;$i<=$numGrupos;$i++){

                    $CentDeno = 0;
                    for($w=0;$w<$numTerms;$w++){
                        $filaVectCent[$w] = 0;
                    }

                    $filaVectU = $ObjTf_IdfDAO->filaVectorU($i);

                    for($j=1; $j<=$cantDocs; $j++){

                        $filaVectCarac = $ObjTf_IdfDAO->filaVectorCarac($j);
                        $uQ = pow($filaVectU[$j], $q);
                        $CentDeno = $CentDeno + $uQ;

                        for($w=0;$w<$numTerms;$w++){
                            $filaVectCent[$w] = $filaVectCent[$w] + ($uQ * $filaVectCarac[$w]);
                        }                    
                        unset($filaVectCarac);
                    }
                    for($w=0; $w<$numTerms; $w++){
                            $filaVectCent[$w] = ($filaVectCent[$w])/($CentDeno);
                    }
                    $ObjTf_IdfDAO->nuevosCentros($i, $filaVectCent, $numTerms);
                    unset($filaVectU);
                    unset($filaVectCent);
                }
                //Parada
                $max = -1;
                $i=1;

                while(((!$band)==true) && ($i<$numGrupos)){

                    $filaVectCent    = $ObjTf_IdfDAO->filaVectorCentr($i, TRUE);
                    $filaVectCentAux = $ObjTf_IdfDAO->filaVectorCentr($i, FALSE);    
                    $j = 0;
                    while(((!$band)==true) && ($j<$numTerms)){                    

                        $dif = $filaVectCent[$j] - $filaVectCentAux[$j];
                        if($dif < 0)
                            $dif = $dif*(-1);
                        if($dif > $max)
                            $max = $dif;
                        $j++;
                    }
                    $i++;
                }

                unset($filaVectCent);
                unset($filaVectCentAux);

                if($max <= $parametro){
                    $band = true;
                }
                else{              
                    $ObjTf_IdfDAO->nuevosCentrosAux();
                }

                $it++;
                //$ObjTf_IdfDAO->numIt($it,$max);
            }
            //echo "ITERACIONES FUERON: ".$it."<br>";
        }
        $criterio = $fuzzy->calcularCriterio();//0.33337;
        $fuzzy->calcularGrupos($criterio, $cantDocs);
    
        
    break;
    
    case 6:
        
        $cantDocs  = $_REQUEST['cantDocs'];
        $noticiaDAO = new noticiaDAO();
        $notc   = new noticia();

        $arrayNtc = $noticiaDAO->consultarTodo();

        $cdg .= "<table>";
        for($i=0; $i<$cantDocs; $i++){            
            $notc = $arrayNtc[$i];
            $nomb = $notc->getNomb();
            $id = $notc->getId();
            $cdg .= "<tr><td>";
            $cdg .= "<input type=\"checkbox\" id=\"id".$i."\" name=\"checkbox\" value=\"".$id."\" /> ".$nomb;
            $cdg .= "</tr></td>";
        }
        $cdg .= "</table>";
        echo $cdg;
    break;
    
    case 7:
        
        $numGrupos = $_REQUEST['numGrups'];
        $listaPala = $_REQUEST['palabras'];
        $cantDocs  = $_REQUEST['numDocs'];
        $fchIni    = $_REQUEST['fechaIni'];
        $fchFin    = $_REQUEST['fechaFin'];
        
        $noticia    = new noticia_ext();
        $noticiaDAO = new noticiaDAO();              
        $arrayNtc   = $noticiaDAO->consultarTodo();
        $grupoDAO   = new grupoDAO();
        $group = new grupo();
        $ObjTf_IdfDAO = new tf_idfDAO();
        
        
        $band = -1;
        for($ii=1;$ii<=$numGrupos;$ii++){

            $vectIdObj = $grupoDAO->consultarGrupo3($ii);
            //$vectId = $grupoDAO->consultarGrupo4($i);            
            //$palabra = $ObjTf_IdfDAO->palabraRelevanteGrupo($vectId); //RELEVANCIA POR GRUPO COMPLETO
            
            //$docs .= $palabra."\n";
            $aux = "";
            for($i=0;$i<count($vectIdObj);$i++){
                $id = $vectIdObj[$i]->getId();
                $noticia = $noticiaDAO->consultarFechaNoticia($id);            
                if(!((($noticia->getFechaInicio() < $fchIni) && ($noticia->getFechaFin() < $fchIni)) || (($noticia->getFechaInicio() > $fchFin) && ($noticia->getFechaFin() > $fchFin)))){
                    //$docs[$k] = $noticia();                
                    $docs .= $noticia->getId()." ".$noticia->getNomb()."##".$noticia->getDirPag()."\n";
                    $band = 1;
                }
            }  
            
            if($ii<$numGrupos){
                $docs .= "%%\n";
            }
            unset($vectIdObj);
            //$docs[$i] = $aux;
        }  
        /*
        $band = -1;
        if(count($arrayNtc)>1){
            
            for($i=0;$i<$cantDocs;$i++){
                $id = $arrayNtc[$i]->getId();
                $noticia = $noticiaDAO->consultarFechaNoticia($id);            
                if(!((($noticia->getFechaInicio() < $fchIni) && ($noticia->getFechaFin() < $fchIni)) || (($noticia->getFechaInicio() > $fchFin) && ($noticia->getFechaFin() > $fchFin)))){
                    //$docs[$k] = $noticia();                
                    $docs .= $noticia->getId()." ".$noticia->getNomb()."\n";
                    $band = 1;
                }
            }
        }*/
        
        if($band == -1){
           $docs = $band;
        }
        /*else{
            $result = json_encode($docs);
        }*/
      
        echo $docs;
        
    break;

    case 8:
        $listID    = $_REQUEST['vectIds'];        
        $vectID    = explode(",", $listID);
        $numGrupos = $_REQUEST['numGr'];
        
        $ObjTf_IdfDAO   = new tf_idfDAO();        
        echo $ObjTf_IdfDAO->centrosElegidos($numGrupos, $vectID);
        
    break;
    //Devuelve un arreglo con las palabras los temas de cada grupo
    case 9:
        
        $ObjTf_IdfDAO   = new tf_idfDAO();
        $numGrupos  = $_REQUEST['numGrups'];
        $grupoDAO   = new grupoDAO();
        $group      = new grupo();

        for($i=1;$i<=$numGrupos;$i++){
            $vectId = $grupoDAO->consultarGrupo4($i);            
            $palabra[$i] = $ObjTf_IdfDAO->palabraRelevanteGrupo($vectId); //RELEVANCIA POR GRUPO COMPLETO        
        }       
        echo json_encode($palabra);
        
    break;
}
?>
