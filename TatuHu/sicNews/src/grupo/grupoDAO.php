<?php
    require 'grupo.class.php';
    
    class grupoDAO{
        
        function consultarGrupo($idt){
                        
            //$query = "SELECT * FROM grupo WHERE id_noticia = '$idt'";
            $query = "SELECT * FROM grupo WHERE num_grupo = ".$idt."";
            $tabla = mysql_query($query);		
            $vector = array();
            $i = 0;
            while($datos = mysql_fetch_assoc($tabla)){
                $group = new grupo();
                $group->setId($datos['id_noticia']);
                $group->setNumGrupo($datos['num_grupo']);
                $group->setNivelBorrosidad($datos['nivel_borrosidad']);
                $group->setCriterioAgrupa($datos['criterio_agrupamiento']);
                $group->setPertinencia($datos['pertinencia']);
                $vector[$i] = $group;
                $i++;
            }

            return json_encode($vector);
        }
        function consultarGrupo3($idt){
                        
            //$query = "SELECT * FROM grupo WHERE id_noticia = '$idt'";
            $query = "SELECT * FROM grupo WHERE num_grupo = ".$idt."";
            $tabla = mysql_query($query);		
            $vector = array();
            $i = 0;
            while($datos = mysql_fetch_assoc($tabla)){
                $group = new grupo();
                $group->setId($datos['id_noticia']);
                $group->setNumGrupo($datos['num_grupo']);
                $group->setNivelBorrosidad($datos['nivel_borrosidad']);
                $group->setCriterioAgrupa($datos['criterio_agrupamiento']);
                $group->setPertinencia($datos['pertinencia']);
                $vector[$i] = $group;
                $i++;
            }

            return $vector;
        }
        //Devuelve solo la lista con ids
        function consultarGrupo4($idt){
                        
            //$query = "SELECT * FROM grupo WHERE id_noticia = '$idt'";
            $query = "SELECT id_noticia FROM grupo WHERE num_grupo = ".$idt."";
            $tabla = mysql_query($query);		
            $vector = array();
            $i = 0;
            while($datos = mysql_fetch_assoc($tabla)){
                $vector[$i] = $datos['id_noticia'];
                $i++;
            }
            return $vector;
        }
        //Consulta los documetnos de un grupo en un rango de fecha determinado para graficar
        function consultarGrupoRango($idt, $fechaIni,$fechaFin){
            
            $query = "SELECT t1.id_noticia AS id FROM grupo AS t1, noticia AS t2 WHERE num_grupo = ".$idt." AND fecha_inicio >= '".$fechaIni."' AND fecha_fin <= '".$fechaFin."' AND t1.id_noticia = t2.id_noticia;";
            $tabla = mysql_query($query);		
            $vector = array();
            $i = 0;
            while($datos = mysql_fetch_assoc($tabla)){
                $vector[$i] = $datos['id'];
                $i++;
            }
            return $vector;            
        }
        //Funcion que devuelve el los valores de una noticia en un grupo dado
        function consultarDatos($idNtc,$idGrup){
            $query = "SELECT * FROM grupo WHERE id_noticia = ".$idNtc." AND num_grupo = ".$idGrup."";
            $tabla = mysql_query($query);
            
            $datos = mysql_fetch_array($tabla);
            
            $group = new grupo();
            $group->setIdnoticia($datos['id_noticia']);
            $group->setNumGrupo($datos['num_grupo']);
            $group->setNivelBorrosidad($datos['nivel_borrosidad']);
            $group->setCriterioAgrupa($datos['criterio_agrupamiento']);
            $group->setPertinencia($datos['pertinencia']);
            
            return $group;
        }

        
        function consultarTodo(){
            
            $query = "SELECT * from grupo";	
            $tabla = mysql_query($query);		
            //$datos = mysql_fetch_row($tabla);
            $array = array();
            $i=0;
            while($datos = mysql_fetch_assoc($tabla)){

                $group = new grupo();
                $group->setId($datos['id_noticia']);
                $group->setNumGrupo($datos['num_grupo']);
                $group->setNivelBorrosidad($datos['nivel_borrosidad']);
                $group->setCriterioAgrupa($datos['criterio_agrupamiento']);
                $group->setPertinencia($dator['pertinencia']);
                
                $array[$i]= $group;
                $i++;            
            }
            return $array;
        }
        
        function guardar($obj){            
            $group = new grupo();
            $group = $obj;            
            $query = "INSERT INTO grupo (id_noticia, num_grupo, nivel_borrosidad, criterio_agrupamiento, pertinencia) VALUES ('$group->id','$group->numGrupo', '$group->nivelBorrosidad', '$group->criterioAgrupa', '$group->pert')"; 
            return mysql_query($query);            
        }
        
        function calcularCriterio(){
            
            $query = "SELECT valor FROM matrizU";
            $tabla = mysql_query($query);
            //$suma = 0;
            $i = 0;
            $total = mysql_num_rows($tabla);
            while($rowVectU = mysql_fetch_assoc($tabla)){
                //$suma = $suma + $rowVectU['valor'];
                $suma[$i] = $rowVectU['valor'];
                $i++;
            }
            $pos = intval($total/2);
            sort($suma);
            
            return ($suma[$pos-1]);  
        }
        
        function calcularGrupos($criterio, $cantDocs){

            $grupos = array();
            
            $query = "TRUNCATE grupo";//NUEVO!!!!!
            mysql_query($query);      //NUEVO!!!!!
            
            for($i=1;$i<=$cantDocs;$i++){
                
                //$query = "SELECT valor FROM matrizU WHERE id_noticia = ".$i." ";                
                $query = "SELECT valor, num_grupo FROM matrizU WHERE id_noticia =  ".$i." ORDER BY valor DESC";
                $tabla = mysql_query($query);
                
                $w = 1; //GRUPO
                $j = 0;
                
                //INICIA NUEVA PARTE
                $rowVectU = mysql_fetch_assoc($tabla);
                $valor =  $rowVectU['valor'];
                $numG =  $rowVectU['num_grupo'];
                $query = "INSERT INTO grupo (id_noticia, num_grupo, nivel_borrosidad, criterio_agrupamiento, pertinencia) VALUES (".$i.",".$numG.", 2, ".$criterio.",".$valor.")";
                mysql_query($query);
                //FIN NUEVA PARTE
                /*
                while($rowVectU = mysql_fetch_assoc($tabla)){
                    if($rowVectU['valor'] >= $criterio){
                        $grupos[$i][$w] = $rowVectU['valor'];
                        $w++;    
                    }
                    else{
                        $grupos[$i][$w] = -1;
                        $w++;    
                    }
                    $j++;
                }*/
            }       
            /*$numGrupos = $w - 1;

            $query = "TRUNCATE grupo";
            mysql_query($query);

            for($i=1; $i<=$numGrupos; $i++){
                $cont = 0;
                for($j=1; $j<=$cantDocs; $j++){
                    if($grupos[$j][$i] != -1){
                        $query = "INSERT INTO grupo (id_noticia, num_grupo, nivel_borrosidad, criterio_agrupamiento, pertinencia) VALUES (".$j.",".$i.", 2, ".$criterio.",".($grupos[$j][$i]).")";
                        mysql_query($query);         
                        $cont++;
                    }
                }
                //echo "Docs en el grupo ".$i.": ".$cont;
                //echo "<br>";
            }*/
            //return $grupos;
        }
        function consultarGrupo2($idGrup){
            
            //for($i=1; $i<=$numGrupos; $i++){
            $vect = array();
            $i = 0;
            $query = "SELECT id_noticia FROM grupo WHERE num_grupo = ".$idGrup." ";
            $tabla = mysql_query($query);    

             while($rowVectGrup = mysql_fetch_assoc($tabla)){
                 $vect[$i] = $rowVectGrup['id_noticia'];
                 $i++;
             }
             return $vect;
            //}
        }
        
        function similitudPromedio($numGrup,$numDocs){
            
            for($j=1;$j<=$numGrup;$j++){
                $query = "SELECT * FROM grupo where num_grupo = ".$j."";
                $tabla = mysql_query($query); 
                
                $numElemts = mysql_num_rows($tabla);
                while($rowVectGrup = mysql_fetch_assoc($tabla)){
                 
                    
                }
            }
        }
    }
?>
