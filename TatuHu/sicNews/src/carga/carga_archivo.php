<?php
    error_reporting(0);
    require_once '../../web/js/uploadify-v2.1.4/html2text.php';
    require '../noticia/noticiaDAO.php';
    require '../parametro/parametroDAO.php';

if (!empty($_FILES)) {
    
        $noticiaDAO = new noticiaDAO();
    
        //Carga de Archivos
        $tempFile = $_FILES['Filedata']['tmp_name'];    
        $fileName= $_FILES['Filedata']['name'];
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
        $extension = end(explode('.',$fileName));
        $onlyName = substr($fileName,0,strlen($fileName)-(strlen($extension)+1));
        $originalName = $onlyName;
        $onlyName = "documento".($noticiaDAO->numNoticias()+1);
        $targetFile =  str_replace('//','/',$targetPath) . $onlyName . ".txt";
        
        $titulo1 = explode("-", $originalName);
        $titulo  = implode(" ", $titulo1);
        
        $search1 = array('de', 'del', ',', '-');
            
            
        if(move_uploaded_file($tempFile,$targetFile)){

            //Eliminando Etiquetas HTML
            $html = file_get_contents($targetFile);
            
            $id  = fopen($targetPath.'files_mostrar/'.$onlyName.".html",'w+');
            $rutaHtml = $targetPath.'files_mostrar/'.$onlyName.".html";
            fwrite($id, $html);
            fclose($id);
            
            $html = html2text( $html );
        
            /*$html = str_replace("<p>", ' ', $html);
            $html = str_replace("</p>", ' ', $html);
            $html = str_replace("<em>", ' ', $html);
            $html = str_replace("</em>", ' ', $html);*/

            $plain_text = $html;            
            $vectorTexto = explode("\n", $plain_text);
            $plain_text = "";            
            $meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
            $k = 0;
            
            for($i=0;$i<count($vectorTexto);$i++){
                if((strrpos($vectorTexto[$i], "[") === FALSE) && (strrpos($vectorTexto[$i], "http") === FALSE)){
                    $plain_text .= $vectorTexto[$i]." ";
                }
                $limpio = str_replace($search1, " ", $vectorTexto[$i]);
                $lineaFchas = explode(" ", $limpio);
                $band = FALSE;
                $j=0;
                //Buscando posibles meses de fecha del documento
                while($j<24 && $band == FALSE){
                    $pos = array_search($meses[$j], $lineaFchas);
                    unset($lineaFchas);
                    if($pos != FALSE){
                        $listaFchas .= $limpio." ";
                        $band = TRUE;
                        unset ($limpio);
                    }
                    $j++;
                }   
            }
            $lineaFchas = explode(" ", $listaFchas);
            //Fin 
            //Eliminar salto de linieas y dobles espacios en blanco
            function limpieza($str){
                
                $str = preg_replace("[\n|\r|\t|\n\r]", ' ', $str);	//elimino el salto de linea
                $str = str_replace('  ',' ',$str);
                $str = str_replace('  ',' ',$str);
                $str = str_replace('  ',' ',$str);
                $str = str_replace('  ',' ',$str);
                $str = str_replace('  ',' ',$str);
                $str = str_replace('  ',' ',$str);                
                $str = trim($str);
		return $str;
                    
            }            
            //Eliminar acentos (NO SE UTILIZA)
            function elimina_acentos($cadena){
                $tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
                $replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
                return utf8_encode((strtr($cadena,utf8_decode($tofind),$replac)));
            }	
            $textoCompleto = $plain_text;
            
            //Eliminando Acentos
            $listCaracteres  = file_get_contents('../limpieza/acentos_1.txt');
            $vectCaract = explode("\n", $listCaracteres);
            for($i=0;$i<count($vectCaract);$i++){
                $aux = explode(" ", $vectCaract[$i]);
                $plain_text = str_replace($aux[0],$aux[1],$plain_text);
                $titulo = str_replace($aux[0],$aux[1],$titulo);
            }            
            $listCaracteres  = file_get_contents('../limpieza/acentos_2.txt');
            $vectCaract = explode("\n", $listCaracteres);
            $aux = explode(" ", $vectCaract[0]);
            $acentos = explode(" ", $vectCaract[1]);
            $plain_text =  strtr(strtolower($plain_text), $aux[0],$aux[1]);
            $titulo =  strtr(strtolower($titulo), $aux[0],$aux[1]);
            
            $listCaracteres  = file_get_contents('../limpieza/acentos_3.txt');
            $vectCaract = explode("\n", $listCaracteres);
            for($i=0;$i<count($vectCaract);$i++){
                $aux = explode(" ", $vectCaract[$i]);
                $plain_text = str_replace($aux[0],$aux[1],$plain_text);
                $titulo = str_replace($aux[0],$aux[1],$titulo);
            }
            //Eliminando Simbolos
            $listCaracteres  = file_get_contents('../limpieza/simbolos.txt');
            $vectCaract = explode("\n", $listCaracteres);
            for($i=0;$i<count($vectCaract);$i++){
                $plain_text = str_replace($vectCaract[$i]," ",$plain_text);
                $titulo = str_replace($vectCaract[$i]," ",$titulo);
            }       

            $plain_text = limpieza($plain_text);
            $titulo     = limpieza($titulo);
            
            $plain_text = stripslashes($plain_text);    // QUITANDO '\' 
            $titulo     = stripslashes($titulo);            
            
            //Eliminando Otros Acentos
            //$plain_text = utf8_encode((strtr($plain_text,utf8_decode($acentos[0]),$acentos[1])));
            //$titulo = utf8_encode((strtr($titulo,utf8_decode($acentos[0]),$acentos[1])));
            
            //ELIMINANDO STOPWORDS
            
            $stopW = file_get_contents('../limpieza/stopWords.txt');
            $search = explode("\n", $stopW);
            $plain_text = str_replace("universal", ' ', $plain_text);
            $plain_text = str_replace("carabobeno", ' ', $plain_text);
            $plain_text = str_replace("a ¢", ' ', $plain_text);
            $plain_text = str_replace("a ¢", ' ', $plain_text);
            $plain_text = str_replace($search, ' ', $plain_text);

            $id  = fopen($targetPath.$onlyName.".txt",'w+');

            fwrite($id, $plain_text);
            fclose($id);
            //Fin 
            
            $linea1 = explode(' ', $textoCompleto); //MAXIMO POR DOCUMENTOS 5000
            $textoCompleto = "";
            for($y=0; $y<count($linea1);$y++){
                if($linea1[$y] != '' && $linea1[$y] != ' ' && $linea1[$y] != '[\n|\r|\t|\n\r]'){   
                    $textoCompleto .= $linea1[$y]." ";
                }
            }   
            $direc = $targetPath.$onlyName.".txt";
            $direc = str_replace("/./", "/", $direc);
            $rutaHtml = str_replace("/./", "/", $rutaHtml);
            
            $noticia = new noticia();
            $noticia->setDirHtml($rutaHtml);
            $noticia->setDirec($direc);
            $noticia->setNomb($titulo);
            $noticia->setDirPag("/files/files_mostrar/".$onlyName.".html");
                        
            if($noticiaDAO->guardar($noticia)){ 
                    $numNotc = new parametroDAO();
                    $numNotc->modificarNumDocs($noticiaDAO->numNoticias());  
                    $noticiaDAO->guardarListaFechas($lineaFchas,$direc);
                    $noticiaDAO->guardarContenido($textoCompleto,$direc);
                    echo 'Tu archivo se subio correctamente';
            }else{
                    echo 'Tu archivo fallo.';
            }
            
        }
}
?>
