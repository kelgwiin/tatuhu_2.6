<?php
    require 'tf_idf.class.php';
    
    class tf_idfDAO{
        
        function listaTerm($obj){            
            $term  = new tf_idf();
            $term  = $obj;
            $query = "INSERT DELAYED INTO listaTerm (id_termino, id_noticia, termino) VALUES (NULL, ".$term->id_not.", '".$term->termino."')";
            mysql_query($query);
            unset ($term);
        }
        
        function imprimirTerminos(){
            $query = "SELECT DISTINCT termino FROM listaTerm GROUP BY termino";
            $tabla = mysql_query($query);
            
            while($rowListaTerm = mysql_fetch_assoc($tabla)){
                echo $rowListaTerm['termino']." ";
            }            
        }
        
        function vaciarListaTerm(){
            $query = "TRUNCATE listaTerm";
            mysql_query($query);
        }
        
        function calcularTf_Ifd($cantDocs){
            $query = "CALL tfIdfN()"; //Llamada a rutina
            mysql_query($query);
            
            //INSERTANDO TERMINOS FALTANTES EN DOCS CUYO PESO ES 0 EN ;
            $query = "SELECT DISTINCT termino FROM listaTerm GROUP BY termino";
            $tabla = mysql_query($query);
            $listaTerm = "";
            $vectTerm = array();
            
            $sum = 0;

            while($rowListaTerm = mysql_fetch_assoc($tabla)){
                //$listaTerm .= $rowListaTerm['termino']." ";
                $vectTerm[$sum] = ' '.$rowListaTerm['termino'].' ';
                $sum++;
            }

            $listaTerm = implode("", $vectTerm);
            $i=1;
            for($i=1;$i<=$cantDocs;$i++){
                $j = 0;
                $query = "SELECT termino FROM vectCarac WHERE id_noticia = ".$i." ";
                $tabla = mysql_query($query);
                while($rowLista = mysql_fetch_assoc($tabla)){
                    $vectorTerm[$j] = ' '.$rowLista['termino'].' ';
                    $j++;
                }
                
                $resultado = str_replace($vectorTerm,"",$listaTerm);
                unset($vectorTerm);
                $vectorTerm = explode("  ", trim($resultado));
                unset($resultado);
                
                $total = count($vectorTerm);
                if($sum != ((count($vectorTerm))+$j) ){
                    $total = ((count($vectorTerm))+$j) - $sum;
                    
                    if($sum == ((count($vectorTerm)+$j) - $total)){
                        $total = count($vectorTerm) - $total;
                    }                
                }
                
                for($w=0;$w<$total;$w++){
                    $term = $vectorTerm[$w];
                    $query = "INSERT DELAYED INTO vectCarac(id_noticia, peso_termino, termino) VALUES (".$i.",0,'".$term."')";
                    mysql_query($query);
                }
                unset($vectorTerm);
                //$resultado = "";
            }      
        }
        
        function primeraConfig_centros($numGrupos,$cantDocs){
            
            //GENERANDO NUMEROS ALEATOREOS
            $idRand = array();
            $i=1;
            $aux = "";
            while($i<=$numGrupos){         
                $valor = mt_rand(1, $cantDocs);
                if(strstr($aux, ' '.$valor.' ') == FALSE){
                    $idRand[$i] = $valor;
                    $aux .= ' '.$valor.' ';
                    $i++;
                }        
            }
            //FIN            
            
            unset($rowParam);
            unset($tabla);
            
            for($i=1;$i<=$numGrupos;$i++){

                $query = "SELECT peso_termino FROM vectCarac WHERE id_noticia = ".$idRand[$i]." ORDER BY id_noticia, termino";
                $tabla = mysql_query($query);
                while($rowVectCar = mysql_fetch_assoc($tabla)){
                    $valor = $rowVectCar['peso_termino'];                    
                    $query = "INSERT INTO vectCentr(num_grupo, valor) 
                              VALUES (".$i.",".$valor.")";                    
                    mysql_query($query);
                    
                    $query = "INSERT INTO vectCentrAux(num_grupo, valor) 
                    VALUES (".$i.",".$valor.")";                    
                    mysql_query($query);  
                }
            }               
        }
        
        function centrosElegidos($numGrupos,$vectID){
            
            $query = "TRUNCATE vectCentr";
            mysql_query($query);
            $query = "TRUNCATE vectCentrAux";
            mysql_query($query);
            
            for($i=0;$i<$numGrupos;$i++){

                $query = "SELECT peso_termino FROM vectCarac WHERE id_noticia = ".$vectID[$i]." ORDER BY id_noticia, termino";
                $tabla = mysql_query($query);
                while($rowVectCar = mysql_fetch_assoc($tabla)){
                    $valor = $rowVectCar['peso_termino'];                    
                    $query = "INSERT INTO vectCentr(num_grupo, valor) 
                              VALUES (".($i+1).",".$valor.")";                    
                    mysql_query($query);
                    
                    $query = "INSERT INTO vectCentrAux(num_grupo, valor) 
                    VALUES (".($i+1).",".$valor.")";                    
                    mysql_query($query);  
                }
            }
            
            return 1;
        }
        
        function nuevosCentros($idGrup, $vectCentr,$numTerms){            
            for($j=0;$j<$numTerms;$j++){
                $query = "INSERT INTO vectCentr(num_grupo, valor) 
                          VALUES (".$idGrup.",".$vectCentr[$j].")"; 
                mysql_query($query);
            }            
        }
        
        function nuevosCentrosAux(){
            
            $query = "TRUNCATE vectCentrAux";
            mysql_query($query);
            
            $query = "SELECT * FROM vectCentr ORDER BY id_vectCentr";
            $tabla = mysql_query($query);
            
            while($rowVectCent = mysql_fetch_assoc($tabla)){
                $idGrup = $rowVectCent['num_grupo'];
                $valor  = $rowVectCent['valor'];
                $query  = "INSERT INTO vectCentrAux(num_grupo, valor) 
                           VALUES (".$idGrup.",".$valor.")"; 
                mysql_query($query);
            }
            
        }
        function prueba($idGrupo, $idDoc){
            
            $query = "CALL distEcuclidiana(".$idGrupo.",".$idDoc.", @dist)";
            mysql_query($query);
            
            $query = "SELECT @dist";
            $resp = mysql_query($query);
            $row = mysql_fetch_array($resp);
            return $row[0];
            
        }
                
        function distEuclidiana($numT,$id_centr,$id_not){

            //$query = "SELECT valor FROM vectCentr WHERE num_grupo = ".$id_centr."";
            $query = "SELECT SUM(POW((peso_termino - valor),2)/".$numT.") AS result FROM vectCarac, vectCentr WHERE id_noticia = ".$id_not." AND num_grupo = ".$id_centr."";
            $tabla = mysql_query($query);
            $dist = 0;
            $i = 0;

            $rowVectCent = mysql_fetch_assoc($tabla);
            $dist =  $rowVectCent['result'];    
            /*while($rowVectCent = mysql_fetch_assoc($tabla)){

                $rowVectCent = mysql_fetch_assoc($tabla);
                //$resta = $vectCarac[$i] - $rowVectCent['valor'];
                //$dist  = ($dist + pow($resta, 2));//$n;
                $dist = $dist + $rowVectCent['result'];
                $i++;
            }*/

            $dist = sqrt($dist);    
            if($dist == 0)
                $dist = 0.000000000000001;
            
            unset($tabla);
            unset($vectCarac);
            unset($rowVectCent);
            //return ($dist/$n); 
            return $dist;
        }
                
        function llenarU($numGrp,$id_not,$Unum,$Udeno){            
            $query = "INSERT DELAYED INTO matrizU (id_noticia, num_grupo, valor) VALUES (".$id_not.",".$numGrp.",".($Unum/$Udeno).")";
            mysql_query($query);
        }
        
        function vaciarTablas($vCent, $matU, $lisT, $vCentAux){
            
            if($vCent){
                $query = "TRUNCATE vectCentr";
                $tabla = mysql_query($query);
            }
            if($vCentAux){
                $query = "TRUNCATE vectCentrAux";
                $tabla = mysql_query($query);
            }
            if($matU){
                $query = "TRUNCATE matrizU";
                $tabla = mysql_query($query);
            }
            if($lisT){
                $query = "TRUNCATE listaTerm";
                mysql_query($query);
            }

        }
        
        function filaVectorCarac($id_vectCarac){

            $query = "SELECT peso_termino FROM vectCarac WHERE termino = termino AND id_noticia = ".$id_vectCarac." ORDER BY termino";
            $tabla = mysql_query($query);
            $vect = array();
            $i = 0;
            
            while($rowVectCar = mysql_fetch_assoc($tabla)){
                $vect[$i] = $rowVectCar['peso_termino'];
                $i++;
            }            
            return $vect;            
        }
                
        function filaVectorU($idGrup){
            $query = "SELECT valor FROM matrizU WHERE num_grupo = ".$idGrup." ";
            $tabla = mysql_query($query);
            $vect = array();
            $i = 0;
            while($rowVectU = mysql_fetch_assoc($tabla)){
                $vect[$i] = $rowVectU['valor'];
                $i++;
            }           
            return $vect;            
        }
        
        function filaVectorCentr($idGrup,$tipo){
            
            if($tipo){
                $query = "SELECT valor FROM vectCentr WHERE num_grupo = ".$idGrup." "; 
            }
            else{  
                $query = "SELECT valor FROM vectCentrAux WHERE num_grupo = ".$idGrup." "; 
            }
            
            $tabla = mysql_query($query);
            $vect = array();
            $i = 0;
            while($rowVectCentr = mysql_fetch_assoc($tabla)){
                $vect[$i] = $rowVectCentr['valor'];
                $i++;
            }  
            return $vect;  
        }
        
        //funcion que devuelve cual es la palabra con mas relevancia en un grupo (es decir el tema del grupo)
        function palabraRelevanteGrupo($vect){
            $k=0;
            //Buscar palabras con mayor peso
            for($i=0;$i<count($vect);$i++){
                $query = "SELECT termino FROM vectCarac  WHERE id_noticia = ".$vect[$i]." AND peso_termino > 0.9";
                $tabla = mysql_query($query);
                
                while($datos = mysql_fetch_assoc($tabla)){
                    if($datos['termino'] != " " && $datos['termino'] != ' ' && $datos['termino'] != "Â"){
                        $arrayPal[$k] = $datos['termino'];   
                    }
                    $k++; 
                }
            }
            //$arrayPalAux = array_unique($arrayPal);            //Arreglo con palabras sin repetir
            $arrayCuenta = array_count_values($arrayPal);      //Arreglo con cantidad de apareciones de palabras
            arsort($arrayCuenta);
            $array = array_keys($arrayCuenta);
            /*$k = 0;
            //Eliminando espacios en blanco de arreglo de palabras
            for($i=0;$i<count($arrayPal);$i++){
                if($arrayPalAux[$i] != ""){
                    $nuevoArray[$k] = $arrayPalAux[$i];
                    $k++;
                }
            }
            //Determinando la palabra con mayor numero de apariciones
            $mayor = -999;
            for($i=0;$i<count($nuevoArray);$i++){
                if($mayor < $arrayCuenta[$nuevoArray[$i]]){
                    $mayor = $arrayCuenta[$nuevoArray[$i]];
                    $pos = $i;
                }
            }*/
            //echo "el mayor esta en la pos: ".$pos." y es el termino: ".$nuevoArray[$pos];
            
            return current($array)." ".next($array)." ". next($array);/*implode(" ", $arrayPal);*/   
        }
        //funcion que devuelve el valor de un termino de acuerdo a un documento dado.
        function valorTermino($idNtc, $term){
            
            $query = "SELECT peso_termino FROM vectCarac WHERE termino = '".$term."' AND id_noticia = ".$idNtc." ";
            $tabla = mysql_query($query);
            
            $datos = mysql_fetch_array($tabla);
            
            if($datos == FALSE){
                $valor = 0;
            }
            else{
                $valor = $datos['peso_termino'];
            }
            
            return $valor;
            
        }
        
        function calcularProducto($vect1,$vect2){
            $suma = 0;
            for($i=0;$i<count($vect1);$i++){
                    $suma = $suma + ($vect1[$i]*$vect2[$i]);
            }
            return $suma;
        }
        
        function calcularNorma($vect){
            
            $suma = 0;
            for($i=0;$i<count($vect);$i++){
                $suma = $suma + pow($vect[$i],2);
            }
            return sqrt($suma);            
        }
        
        function numIt($i,$pal){
            $query = "INSERT INTO pruebas (numero,palabra) VALUES (".$i.",'".$pal."')";
            mysql_query($query);
        }
        
        /*function calcularCriterio(){
            
            $query = "SELECT valor FROM matrizU";
            $tabla = mysql_query($query);
            $suma = 0;
            $total = mysql_num_rows($tabla);
            while($rowVectU = mysql_fetch_assoc($tabla)){
                $suma = $suma + $rowVectU['valor'];
            }
            return ($suma/$total);            
        }*/
        
        
                /*function distEuclidiana($idGrupo, $idDoc){
            
            $dist = 0;
            
            $query = "CALL distEcuclidiana(".$idGrupo.",".$idDoc.", @dist)";
            mysql_query($query);
            $query = "SELECT @dist";
            $resp = mysql_query($query);
            $row = mysql_fetch_array($resp);
            $dist = $row[0];
            $dist = sqrt($dist);    
            if($dist == 0)
                $dist = 0.000000000000001;

            return ($dist*$dist);    
        }*/
        
        /*function filaVectorCarac3($id_vectCarac){
            //CREAR TABLA   OJO!!!!!
            $query = "TRUNCATE vectCaracAux";
            mysql_query($query);
            
            $query = "INSERT INTO vectCaracAux (peso) 
                        (SELECT peso_termino FROM vectCarac WHERE (termino = termino AND id_noticia = ".$id_vectCarac.") 
                     ORDER BY termino)";
            mysql_query($query);
            
        }*/
        
        /*function distEuclidiana3($id_centr){ 
            ////CREAR TABLA   OJO!!!!!
            $query = "SELECT (peso - valor) AS resultado FROM vectCaracAux, vectCentr 
                        WHERE num_grupo = ".$id_centr." ";
            $tabla = mysql_query($query);
            
            $dist = 0;
            $i = 0;

            while($rowVectCent = mysql_fetch_assoc($tabla)){

                $rowVectCent = mysql_fetch_assoc($tabla);
                $dist  = $dist + pow($rowVectCent['resultado'], 2);
                $i++;
            }

            $dist = sqrt($dist);    
            if($dist == 0)
                $dist = 0.000000000000001;

            unset($tabla);
            unset($rowVectCent);
            return ($dist*$dist);    
        }*/
    }
    

?>