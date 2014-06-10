<?php
    require '../noticia/noticiaDAO.php';
    require '../grupo/grupoDAO.php';
    require '../cluster/tf_idfDAO.php';
    require '../parametro/parametroDAO.php';
    
    $vector_ntc = array();
    $noticiaDAO = new noticiaDAO();
    $fuzzy      = new grupoDAO();
    $vector_ntc = $noticiaDAO->consultarTodo();
    $valores    = new parametro();
    $valoresDAO = new parametroDAO();

    set_time_limit(3600);
    
    //$valores   = $valoresDAO->consultarValores();
    $numGrupos = $_REQUEST['numGrup'];
    //$numGrupos = $valores->getNumGrupos();
    $cantDocs  = $_REQUEST['nDocs'];
    //$cantDocs  = $valores->getNumDocs();
    $nvlDifuso = $_REQUEST['NvlBorr'];
    //$nvlDifuso = $valores->getNivelBorr();
    //$criterio  = $_REQUEST['crtiterio'];
    $parParada = $_REQUEST['paramP'];
    //$parParada = $valores->getParam();
    
    //Crando Matriz TF_IDF
    obtenerTFIDF($vector_ntc);
    $numTerms = $valoresDAO->consultarNumTerm();

    //Realizando Agrupamiento de documentos
    fuzzyCMeans($numGrupos,$cantDocs,$numTerms,$nvlDifuso,$parParada);
    
    $criterio = $fuzzy->calcularCriterio();
    
    $fuzzy->calcularGrupos($criterio, $cantDocs);
    //echo verGrupos($vector_ntc,$cantDocs,$numGrupos);
    
function fuzzyCMeans($numGrupos,$cantDocs,$numTerms,$nvlDifuso,$parParada){

    $filaVectCarac  = array();
    $filaVectU      = array();
    $filaVectCent   = array();
    $band   = false;
    $q      = $nvlDifuso; //1.19;
    $parametro = $parParada;
    
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
            $ObjTf_IdfDAO->numIt($it,$max);
        }
        //echo "ITERACIONES FUERON: ".$it."<br>";
    }
}

function obtenerTFIDF($arrayNtc){

    $noticia        = new noticia();
    $noticiaDAO     = new noticiaDAO();
    $ObjTf_Idf      = new tf_idf();
    $ObjTf_IdfDAO   = new tf_idfDAO();
    $cantDocs       = count($arrayNtc);
    

    if($cantDocs > 0){
        
        $ObjTf_IdfDAO->vaciarListaTerm();
        
        for($w=0;$w<$cantDocs;$w++){
            
            $noticia        = $arrayNtc[$w];                       
            $vectNtc[$w]    = fopen($noticia->getDir(), 'r');
            $linea1         = explode(' ',fgets($vectNtc[$w], 6000)); //MAXIMO POR DOCUMENTOS 50000
            fclose($vectNtc[$w]);
            for($y=0; $y<count($linea1);$y++){
                if($linea1[$y] != ''){        
                    $ObjTf_Idf->setTermino($linea1[$y]);
                    $ObjTf_Idf->setId_not($w+1);
                    $ObjTf_IdfDAO->listaTerm($ObjTf_Idf);
                }
            }            
            unset ($linea1);           
        }         
        unset ($vectNtc);        
        $ObjTf_IdfDAO->calcularTf_Ifd($cantDocs);

    }//FIN TF_IDF

}

function calculaGrupos($matrizNtc,$criterio,$numGrupos,$cantDocs){

    $matriz = new noticia_ext();
    $matriz = $matrizNtc;
    for($i=0;$i<$cantDocs;$i++){
        $w = 0;
        for($j=0;$j<$numGrupos;$j++){

            if($matriz[$j][$i]->getPertinencia() >= $criterio){	                
                $grupos[$i][$w] = new noticia_ext($matriz[$j][$i]->getId(),$matriz[$j][$i]->getDir(),$matriz[$j][$i]->getNomb(),$matriz[$j][$i]->getPertinencia());		
                $w++;				
            }
            else{
                $grupos[$i][$w] = null;
                $w++;
            }
        }
    }
    return $grupos;    
}

function verGrupos($arrayNtc,$numDocs,$numGrupos){

    $grupDAO  = new grupoDAO();
    $notc   = new noticia();
    $vect   = array();
    
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
    return $cdg;
}

?>

