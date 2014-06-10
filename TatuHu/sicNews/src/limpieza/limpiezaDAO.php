<?php
    require_once '../../web/js/uploadify-v2.1.4/html2text.php';

    class limpiezaDAO{
        
        //ELimina las etiquetas HTML del documento
        function elimiarEtiquetasHtml($contenido){
            
            $search1 = array('de', 'del', ',', '-');
            
            $contenido = html2text( $contenido );
            
            $contenido = str_replace("<p>", ' ', $contenido);
            $contenido = str_replace("</p>", ' ', $contenido);
            $contenido = str_replace("<em>", ' ', $contenido);
            $contenido = str_replace("</em>", ' ', $contenido);
            
            return $contenido;

            
        }
        
        //Busca las posibles fechas en el documento
        function posiblesFechas($plain_text){
            $vectorTexto = explode("\n", $plain_text);
            $plain_text = "";            
            $meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
            $k = 0;
            $result = array();
            for($i=0;$i<count($vectorTexto);$i++){
                if((strrpos($vectorTexto[$i], "[") === FALSE) && (strrpos($vectorTexto[$i], "http") === FALSE)){
                    $plain_text .= $vectorTexto[$i]." ";
                }
                $limpio = str_replace($search1, " ", $vectorTexto[$i]);
                $lineaFchas = explode(" ", $limpio);
                $band = FALSE;
                $j=0;
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
            $result[0] = $plain_text;
            $result[1] = $listaFchas;
            return $result;
        }
        
        //Eliminando acentos
        function eliminarAcentos($plain_text){
            
            $listCaracteres  = file_get_contents('/var/www/sicNews/src/limpieza/acentos_1.txt');
            $vectCaract = explode("\n", $listCaracteres);
            for($i=0;$i<count($vectCaract);$i++){
                $aux = explode(" ", $vectCaract[$i]);
                $plain_text = str_replace($aux[0],$aux[1],$plain_text);
            }
            
            $listCaracteres  = file_get_contents('/var/www/sicNews/src/limpieza/acentos_2.txt');
            $vectCaract = explode("\n", $listCaracteres);
            $aux = explode(" ", $vectCaract[0]);
            $acentos = explode(" ", $vectCaract[1]);
            $plain_text =  strtr(strtolower($plain_text), $aux[0],$aux[1]);
            
            $listCaracteres  = file_get_contents('/var/www/sicNews/src/limpieza/acentos_3.txt');
            $vectCaract = explode("\n", $listCaracteres);
            for($i=0;$i<count($vectCaract);$i++){
                $aux = explode(" ", $vectCaract[$i]);
                $plain_text = str_replace($aux[0],$aux[1],$plain_text);
            }
            
            return $plain_text;
        }
        
        //Eliminando Simbolos
        function eliminarSimbolos($plain_text){
            
            $listCaracteres  = file_get_contents('/var/www/sicNews/src/limpieza/simbolos.txt');
            $vectCaract = explode("\n", $listCaracteres);
            for($i=0;$i<count($vectCaract);$i++){
                $plain_text = str_replace($vectCaract[$i]," ",$plain_text);
            }       
            
            $plain_text = preg_replace("[\n|\r|\t|\n\r]", ' ', $plain_text);	//elimino el salto de linea
            $plain_text = str_replace('  ',' ',$plain_text);
            $plain_text = str_replace('  ',' ',$plain_text);
            $plain_text = str_replace('  ',' ',$plain_text);
            $plain_text = str_replace('  ',' ',$plain_text);
            $plain_text = str_replace('  ',' ',$plain_text);
            $plain_text = str_replace('  ',' ',$plain_text);                
            $plain_text = trim($plain_text);
            
            return $plain_text;
            
        }
        //Eliminando palabrqas de parada
        function eliminarStopWords($plain_text){
            
            $stopW = file_get_contents('/var/www/sicNews/src/limpieza/stopWords.txt');
            $search = explode("\n", $stopW);
            $plain_text = str_replace("universal", ' ', $plain_text);
            $plain_text = str_replace("carabobeno", ' ', $plain_text);
            $plain_text = str_replace($search, ' ', $plain_text);            
            return $plain_text;
        }
        //Devuelve la lista de los acentos a eliminar
        function obtenerListaAcentos2(){
            $listCaracteres  = file_get_contents('/var/www/sicNews/src/limpieza/acentos_2.txt');
            $vectCaract = explode("\n", $listCaracteres);
            $acentos = explode(" ", $vectCaract[1]);
           
            return $listCaracteres;
        }
    }
?>
