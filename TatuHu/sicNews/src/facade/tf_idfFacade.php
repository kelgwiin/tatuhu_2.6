<?php     
    error_reporting(0);

if(isset($_REQUEST['modo'])){
	$modo = $_REQUEST['modo'];
}

switch ($modo){
    
    //Crear Lista de Terminos
    case 1:
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
    break;

    case 2:

        
    break;    
}
?>
