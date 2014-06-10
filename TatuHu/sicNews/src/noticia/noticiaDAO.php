<?php
    require 'noticia.class.php';
    

    class noticiaDAO{
        
        //CONSULTAS        
        function consultarUna($idt){
            
            $query = "SELECT * FROM noticia WHERE id_noticia = '$idt'";
            $tabla = mysql_query($query);		
            $datos = mysql_fetch_row($tabla);
            $noticia = new noticia();
            //$noticia = new noticia_ext();
            $noticia->setDirec( $datos['dir_noticia']);
            $noticia->setNomb($datos['nomb_noticia']);
            $noticia->setId($datos['id_noticia']);
            //$noticia->set
            return json_encode($noticia);
            //return $noticia;
        }

        function consultarTodo(){
            
            $query = "SELECT * from noticia";	
            $tabla = mysql_query($query);		
            //$datos = mysql_fetch_row($tabla);
            $array = array();
            $i=0;
            while($rowNtc = mysql_fetch_assoc($tabla)){
            
                $noticia = new noticia();
                $noticia->setDirec($rowNtc['dir_noticia']);
                //echo $rowNtc['dir_noticia'];
                $noticia->setNomb($rowNtc['nomb_noticia']);
                $noticia->setId($rowNtc['id_noticia']);
                
                $array[$i]=$noticia;
                //echo "Elc: ".$noticia->getDir()."<br>";
                $i++;            
            }
            
            /*$numDocs = count($array);
            $query = "UPDATE parametro SET cant_docs = ".$numDocs." WHERE id_parametro = 1";	
            mysql_query($query);
            */
            return $array;            
        }
        function consultarIdsNoticias(){                        
            $query = "SELECT id_noticia from noticia";	
            $tabla = mysql_query($query);		
            $array = array();
            $i=0;
            while($rowNtc = mysql_fetch_assoc($tabla)){               
                $array[$i]=$rowNtc['nomb_noticia'];
                $i++;            
            }
            return $array;  
        }
        //Dado un año, devuelve todas las noticias que son de ese año
        function conultarAño($año){
            
            $query = "SELECT * FROM noticia WHERE fecha_inicio >= '".$año."-00-00' AND fecha_inicio <= '".$año."-12-31'";
            $tabla = mysql_query($query);
            
            $k = 0;
            $resp = $query."\n";
            while($result = mysql_fetch_assoc($tabla)){                
                $noticia = new noticia_ext();
                $noticia->setId($result['id_noticia']);
                $noticia->setNomb($result['nomb_noticia']);
                $noticia->setDirec($result['dir_noticia']);
                $noticia->setFechaInicio($result['fecha_inicio']);
                $noticia->setFechaFin($result['fecha_fin']);
                $vectNotc[$k] = $noticia;
                
                $k++;
            }              
            return $vectNotc;
            
        }
        //Añade una noticia a la base de datos
        function guardar($obj){
            
            $noticia = new noticia();
            $noticia = $obj;            
            
            $query = "INSERT INTO noticia (id_noticia,  dir_noticia, nomb_noticia, ruta_html, enlace_pagina) VALUES (NULL,'$noticia->dir','$noticia->nomb','$noticia->dir_html','$noticia->dir_pagina')"; 
            return mysql_query($query);
            
        }

        //Editar informacion de una noticia
        function editar($obj){
            $noticia = new noticia();
            $noticia = $obj; 
            $query = "UPDATE noticia SET id_noticia = '$noticia->id', dir_noticia = '$noticia->dir', nomb_noticia = '$noticia->nomb' WHERE id_noticia = $noticia->id";			
            mysql_query($query);
        }
        //Eliminar noticias
        function eliminar($vect){
            
            for($i=0;$i<count($vect);$i++){
                
                $query = "SELECT dir_noticia, ruta_html FROM noticia WHERE id_noticia = ".$vect[$i]."";	
                mysql_query($query);
                $tabla = mysql_query($query);
                $result = mysql_fetch_assoc($tabla);                
                unlink($result['dir_noticia']);
                 unlink($result['ruta_html']);
                
                $query = "DELETE FROM noticia WHERE id_noticia = ".$vect[$i]."";	
                mysql_query($query);
            }
            
            $query = "SELECT * FROM noticia";
            $tabla = mysql_query($query);

            $k = 0;
            while($result = mysql_fetch_assoc($tabla)){                
                $noticia = new noticia_ext();
                $noticia->setNomb($result['nomb_noticia']);
                $noticia->setDirec($result['dir_noticia']);
                $noticia->setFechaInicio($result['fecha_inicio']);
                $noticia->setFechaFin($result['fecha_fin']);
                $vectNotc[$k] = $noticia;
                $k++;
            }            
            
            $query = "TRUNCATE noticia";	
            mysql_query($query);
            $query = "TRUNCATE contenidoNoticia";
            mysql_query($query);
            $query = "TRUNCATE fechasNoticia";
            mysql_query($query);
            $query = "TRUNCATE grupo";
            mysql_query($query);
            $query = "TRUNCATE listaTerm";
            mysql_query($query);
            $query = "TRUNCATE matrizU";
            mysql_query($query);
            $query = "TRUNCATE vectCarac";
            mysql_query($query);
            $query = "TRUNCATE vectCentr";
            mysql_query($query);
            $query = "TRUNCATE vectCentrAux";
            /*$query = "TRUNCATE noticia;
                      TRUNCATE contenidoNoticia;
                      TRUNCATE fechasNoticia;
                      TRUNCATE grupo;
                      TRUNCATE listaTerm;
                      TRUNCATE matrizU;
                      TRUNCATE vectCarac;
                      TRUNCATE vectCentr;
                      TRUNCATE vectCentrAux;";*/
            mysql_query($query);

            
            $noticia = new noticia_ext();
            $band = 1;
            for($i=0;$i<count($vectNotc);$i++){
                
                $noticia = $vectNotc[$i];
                $query = "INSERT INTO noticia (id_noticia,  dir_noticia, nomb_noticia, fecha_inicio, fecha_fin) VALUES (NULL,'$noticia->dir','$noticia->nomb',$noticia->fecha_inicio,$noticia->fecha_fin)"; 
                if(!mysql_query($query)){
                    $band = -1;
                }
            }
            
            $query = "UPDATE parametro SET cant_docs = ".$k." WHERE id_parametro = 1";
            mysql_query($query);
            
            return $band;
            
        }
        function numNoticias(){
            $query = "SELECT * FROM noticia";
            $result = mysql_query($query);
            return mysql_num_rows($result);
        }
        function pedirMes($tabla, $campo, $idNot){
            $k = 0;
            $meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
            $numros = array('01','02','03','04','05','06','07','08','09','10','11','12','01','02','03','04','05','06','07','08','09','10','11','12');
            $fechas = array();

            for($j=0;$j<24;$j++){
                $query = "SELECT termino, ".$campo." FROM ".$tabla." WHERE termino = '".$meses[$j]."' AND id_noticia = ".$idNot." ";
                $tabla1 = mysql_query($query);
                //$consulta .= $query."\n";
                while($row1 = mysql_fetch_assoc($tabla1)){
                    if($row1 != null){
                         
                        $query = "SELECT termino FROM ".$tabla." WHERE ".$campo." = ".($row1[$campo]-1)." ";
                        $tabla2 = mysql_query($query);
                        $row2 = mysql_fetch_assoc($tabla2);
                        //$consulta .= $query."\n";
                        $query = "SELECT termino FROM ".$tabla." WHERE ".$campo." = ".($row1[$campo]+1)." ";
                        $tabla3 = mysql_query($query);
                        $row3 = mysql_fetch_assoc($tabla3);
                        //$consulta .= $query."\n";
                        if( (is_numeric($row2['termino'])) && (is_numeric($row3['termino'])) ){
                            //$fechas .= ($i+1)." ".$row2['termino']." ".$row1['termino']." ".$row3['termino']."\n";
                            $mes = str_replace($meses, $numros, trim($row1['termino']));
                            $dia = trim($row2['termino']);
                            if(strlen($row2['termino'])<2 ){
                                $dia = "0".$row2['termino'];
                            }
                            $año = trim($row3['termino']);
                            $fechas[$k] = intval($año.$mes.$dia);
                            $k++;
                        }
                        //$fechas1 .= ($i+1)." ".$row2['termino']." ".$row1['termino']." ".$row3['termino']."\n";
                    }
                }                    
            }                
            return $fechas;
            //return $consulta;
        }
        //Funcion que consulta el periodo de fechas en el documento
        function consultarFechas($nDocs){
	    //echo var_dump("noticiaDAO.php consultarFechas()");
	    //echo var_dump($nDocs);            
            $meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
            //$numros = array('01','02','03','04','05','06','07','08','09','10','11','12','01','02','03','04','05','06','07','08','09','10','11','12');
            $dias = array('fecha','lunes','martes','miercoles','jueves','viernes','sabado','domingo');
            $band = 1;
            //$vector = $this->consultarTodo();            
            //$nDocs = $this->numNoticias();
            //unset($vector);

            for($i=0;$i<$nDocs;$i++){
                $k = 0;
                
                $fecha1 = $this->pedirMes("listaTerm", "id_termino", ($i+1));
                if(count($fecha1)>0){
                    $fechas[$k] = max($fecha1);
                    $k++;
                    $fechas[$k] = min($fecha1);
                    $k++;
                }
                
                $fecha2 = $this->pedirMes("fechasNoticia", "id_fechasNoticia", ($i+1));
                if(count($fecha2)>0){
                    $fechas[$k] = max($fecha2);
                    $k++;
                    $fechas[$k] = min($fecha2);
                    $k++;
                }
                
                
                /*if($i >110){
                    //$imp .= "Busqueda 1 \n Mayor: ".max($fecha1)."\n"."Menor: ".min($fecha1)."\n"."Busqueda 2 \n Mayor: ".max($fecha2)."\n"."Menor: ".min($fecha2)."\n";
                    $imp .= "Busqueda 1 \n ".$fecha1."\n"."Busqueda 2 \n ".$fecha2."\n";
                }*/
                
                //$consu .= $fecha1.$fecha2;              
                /*for($j=0;$j<24;$j++){                    
                    $query = "SELECT termino, id_termino FROM listaTerm WHERE termino = '".$meses[$j]."' and id_noticia = ".($i+1)." ";
                    $tabla1 = mysql_query($query);
                    while($row1 = mysql_fetch_assoc($tabla1)){
                        if($row1 != null){                        
                            $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']-1)." ";
                            $tabla2 = mysql_query($query);
                            $row2 = mysql_fetch_assoc($tabla2);

                            $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']+1)." ";
                            $tabla3 = mysql_query($query);
                            $row3 = mysql_fetch_assoc($tabla3);

                            if( (is_numeric($row2['termino'])) && (is_numeric($row3['termino'])) ){
                                //$fechas .= ($i+1)." ".$row2['termino']." ".$row1['termino']." ".$row3['termino']."\n";
                                $mes = str_replace($meses, $numros, $row1['termino']);
                                $dia = $row2['termino'];
                                if(strlen($row2['termino'])<2 ){
                                    $dia = "0".$row2['termino'];
                                }
                                $fechas[$k] = intval($row3['termino'].$mes.$dia);
                                $k++;
                            }
                            //$fechas1 .= ($i+1)." ".$row2['termino']." ".$row1['termino']." ".$row3['termino']."\n";
                        }
                    }                    
                }*/
                //Preguntando por formato dd/mm/aaaa
                $query = "SELECT * listaTerm WHERE termino < 2050 AND termino > 1999";
                $tabla1 = mysql_query($query);
                while($row1 = mysql_fetch_assoc($tabla1)){
                    $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']-1)." ";
                    $tabla2 = mysql_query($query);
                    $row2 = mysql_fetch_assoc($tabla2);

                    $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']-2)." ";
                    $tabla3 = mysql_query($query);
                    $row3 = mysql_fetch_assoc($tabla3);

                    if( (is_numeric($row2['termino'])) && (is_numeric($row3['termino'])) ){
                        $fechas[$k] = intval($row3['termino'].$row2['termino'].$row1['termino']);
                        $k++;
                    }
                }
                
                
                for($j=0;$j<8;$j++){
                    $query = "SELECT termino, id_termino FROM listaTerm WHERE termino = '".$dias[$j]."' and id_noticia = ".($i+1)." ";
                    $tabla1 = mysql_query($query);
                    while($row1 = mysql_fetch_assoc($tabla1)){
                        $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']+1)." ";
                        $tabla2 = mysql_query($query);
                        $row2 = mysql_fetch_assoc($tabla2);

                        $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']+2)." ";
                        $tabla3 = mysql_query($query);
                        $row3 = mysql_fetch_assoc($tabla3);

                        $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']+3)." ";
                        $tabla4 = mysql_query($query);
                        $row4 = mysql_fetch_assoc($tabla4);

                        if( (is_numeric($row2['termino'])) && (is_numeric($row3['termino'])) && (is_numeric($row4['termino'])) ){

                            if(strlen($row2['termino'])<3 ){
                                $dia = $row2['termino'];
                                if(strlen($row2['termino'])<2 ){
                                    $dia = "0".$row2['termino'];
                                }
                                $año = $row4['termino'];
                            }
                            else{
                                $dia = $row4['termino'];
                                $año = $row2['termino'];
                            }

                            //$mes = str_replace($meses, $numros, $row3['termino']);
                            $mes = $row3['termino'];                               

                            $fechas[$k] = intval($año.$mes.$dia);
                            $k++;
                        }
                    }
                    
                }
                
                if(count($fechas)>1){
                    $fechaInicial = min($fechas);
                    $fechaFinal = max($fechas);
                }
                else{
                    $fechaInicial = $fechas[0];
                    $fechaFinal   = $fechaInicial;
                }


                $query = "UPDATE noticia SET fecha_inicio = ".$fechaInicial.", fecha_fin = ".$fechaFinal." WHERE id_noticia = ".($i+1)."";
                //$imp .= $query."\n";
                $result = mysql_query($query);
                if($result == FALSE){
                    $band = -1;
                }
                unset($fechaInicial);
                unset($fechaFinal);
                unset($fechas);
            }    
            //return $imp;
            //return $band;
        }
        
        //NUEVO!!!
        function rangoFecha($nDocs){
            
            //$nucleos = array('ayer','anteayer','anoche','antenoche');
            //$modificador = array('pasado','proximo');
            //$grano = array('dia','mes','ano','trimestre','cuatrimestre','semestre','decada','siglo');
            $nucleo_nomb  = array();
            $modif_nomb   = array();
            $grano_nomb   = array();

            $nucleo_valor = array();
            $modif_valor  = array();
            $grano_valor  = array();
            
            $tipo = array('nucleo','modificador','grano');
            
            for($i=0;$i<3;$i++){
                
                $query = "SELECT termino, valor FROM modelo_tiempo WHERE tipo = '".$tipo[$i]."'";
                $tabla1 = mysql_query($query);
                $k = 0;
                while($row1 = mysql_fetch_assoc($tabla1)){
                    
                    if($i == 0){
                        $nucleo_nomb[$k]  = $row1['termino'];
                        $nucleo_valor[$k] = $row1['valor'];
                        $k++;
                    }
                    else{                        
                        if($i == 1){
                            $modif_nomb[$k]  = $row1['termino'];
                            $modif_valor[$k] = $row1['valor'];
                            $k++;
                        }
                        else{
                            if($i == 2){
                                $grano_nomb[$k]  = $row1['termino'];
                                $grano_valor[$k] = $row1['valor'];
                                $k++;
                            }    
                        }     
                    }
                }                
            }
            
            
            for($i=0;$i<$nDocs;$i++){
                
                $vectFech = array();                
                $band = false;
                $k = 0;
                
                $query = "SELECT fecha_inicio FROM noticia WHERE id_noticia = ".($i+1)."";
                $tabla1 = mysql_query($query);
                $row1 = mysql_fetch_assoc($tabla1);
                
                $fechaInicio = $row1['fecha_inicio'];
                $fecha = explode('-',$fechaInicio);
                
                if($fechaInicio != '0000-00-00'){
                
                    //BUSCANDO NUCLEOS
                    for($j=0;$j<count($nucleo_nomb);$j++){
                        $query = "SELECT termino FROM listaTerm WHERE termino = '".$nucleo_nomb[$j]."' AND id_noticia = ".($i+1)."";
                        $tabla1 = mysql_query($query);
                        //$row1 = mysql_fetch_assoc($tabla1);

                        if(mysql_num_rows($tabla1) > 0){
                            
                            $dia = intval($fecha[2]);
                            $mes = $fecha[1];
                            $año = intval($fecha[0]);

                            if($dia > 1){
                               $dia = $dia - 1; 
                            }
                            else{
                                $dia = $this->operarDia($fecha[1],$nucleo_valor[$j]);
                                if($mes == '01'){
                                    $mes = 12;
                                    $año = $año - 1;
                                }
                                else{
                                    $mes = intval($fecha[1])-1;
                                }
                                if($mes < 10){
                                    $mes = "0".$mes;
                                }
                            } 

                            if($dia < 10){
                                $dia = "0".$dia;
                            }

                            $vectFech[$k] = $año.$mes.$dia;
                            //$insertar .= ($i+1).": ".$año."-".$mes."-".$dia."\n";//$fecha[0]."-".$fecha[1]."-".$fecha[2]."\n";
                            $k++;         
                            $band = true;
                        }                     
                    }
                    //BUSCANDO MODIFICADOR 
                    for($j=0;$j<count($modif_nomb);$j++){

                        $query = "SELECT termino, id_termino FROM listaTerm WHERE termino = '".$modif_nomb[$j]."' AND id_noticia = ".($i+1)."";
                        $tabla1 = mysql_query($query);
                        //$row1 = mysql_fetch_assoc($tabla1);
                        $mes = intval($fecha[2]);
                        
                        while($row1 = mysql_fetch_assoc($tabla1)){                            

                            $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']-1)." AND id_noticia = ".($i+1)."";
                            $tabla3 = mysql_query($query);
                            $row3 = mysql_fetch_assoc($tabla3); 

                            $term1 = $row3['termino'];

                            $query = "SELECT termino FROM listaTerm WHERE id_termino = ".($row1['id_termino']+1)." AND id_noticia = ".($i+1)."";
                            $tabla3 = mysql_query($query);
                            $row3 = mysql_fetch_assoc($tabla3);

                            $term2 = $row3['termino'];

                            for($w=0;$w<count($grano_nomb);$w++){
                                if(($term1 == $grano_nomb[$w]) || ($term2 == $grano_nomb[$w])){

                                    $vectFech[$k] = intval($fecha[0].$fecha[1].$fecha[2]) + ($modif_valor[$j]*$grano_valor[$w]);
                                    //$insertar .= $vectFech[$k]."\n";
                                    $k++;
                                    $band = true;
                                }
                            }
                        }
                    }       
                    if($band){
                        $query = "UPDATE noticia SET fecha_inicio = ".min($vectFech).", fecha_fin = ".max($vectFech)." WHERE id_noticia = ".($i+1)."";
                        mysql_query($query);
                        //$insertar .= ($i+1).": ".min($vectFech)."\n";    
                    }                    
                }
            }            
            return 1;
        }
        
        function operarDia($mes,$sumRest){
            
            if($sumRest == -1){
                
                if( ($mes == '05') || ($mes == '07') || ($mes == '08') || ($mes == '12')){
                    $dia = 30;                
                }
                else{
                    if($mes == '03'){
                        $dia = 28;

                    }
                    else{
                        $dia = 31;
                    }
                }
            }
            elseif($tipo == -2){
                
                if( ($mes == '05') || ($mes == '07') || ($mes == '08') || ($mes == '12')){
                    $dia = 29;                
                }
                else{
                    if($mes == '03'){
                        $dia = 27;

                    }
                    else{
                        $dia = 30;
                    }
                }  
            }
            return $dia;
        }
        
        function insertarFechas($fechs){
            
            $vectFechs = explode("\n", $fechs);
            $meses = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
            $numros = array('01','02','03','04','05','06','07','08','09','10','11','12');
            $band = 1;
            
            for($i=0;$i<(count($vectFechs)-1);$i++){
                $linea = str_replace($meses, $numros, trim($vectFechs[$i]));
                $vectCadena = explode(" ", $linea);
                $query = "UPDATE noticia SET fecha_inicio = '".$vectCadena[3].$vectCadena[2].$vectCadena[1]."' WHERE id_noticia = ".$vectCadena[0]."";
                $result = mysql_query($query);
                if($result == FALSE){
                    $band = -1;
                }
            }
            return $result;
        }
        
        //Esta funcion consulta la fecha con la que fue etiquetada una noticia
        function consultarFechaNoticia($idNoticia){
            
            $query = "SELECT * FROM noticia WHERE id_noticia = ".$idNoticia." ";
            $tabla = mysql_query($query);
            $result = mysql_fetch_array($tabla);
            
            $ntcia = new noticia_ext();
            
            $ntcia->setId($idNoticia);
            $ntcia->setNomb($result['nomb_noticia']);
            $ntcia->setDirec($result['dir_noticia']);
            $ntcia->setDirHtml($result['ruta_html']);
            $ntcia->setDirPag($result['enlace_pagina']);
            $ntcia->setFechaInicio($result['fecha_inicio']);
            $ntcia->setFechaFin($result['fecha_fin']);
            /*
            if(mysql_num_rows($result) == 0){
                $ntcia = null;
            }*/
            
            return $ntcia;            
        }

        //Llamado desde La carga de Archivos
        function guardarListaFechas($arrFech, $dir){
            
            $query = "SELECT id_noticia FROM noticia WHERE dir_noticia = '".$dir."' ";
            $tabla = mysql_query($query);
            $result = mysql_fetch_array($tabla);
            
            $idNoticia = $result['id_noticia'];
            
            for($i=0;$i<count($arrFech);$i++){
                if($arrFech[$i] != "" && $arrFech[$i] != " "){
                    $query = "INSERT INTO fechasNoticia (termino, id_noticia) VALUES ('".$arrFech[$i]."',".$idNoticia.") ";
                    mysql_query($query);   
                }
            }
            
        }
        
        function guardarContenido($textoNotc,$dir){
                        
            $query = "SELECT id_noticia FROM noticia WHERE dir_noticia = '".$dir."' ";
            $tabla = mysql_query($query);
            $result = mysql_fetch_array($tabla);            
            $idNoticia = $result['id_noticia'];
            
            $query = "INSERT INTO contenidoNoticia (texto, id_noticia) VALUES ('".$textoNotc."',".$idNoticia.") ";
            mysql_query($query);   
            
        }

        function consultarTerminos(){
            $query = "SELECT termino FROM listaTerm GROUP BY termino ORDER BY termino";
            $result = mysql_query($query);
            $i = 0;
            while($rowList = mysql_fetch_assoc($result)){
                $vectTerm[$i] = $rowList['termino'];
                $i++;
            }
            return $vectTerm;
        }
        //Consulta el contenido de la noticia sin limpieza de StopWords
        function contenidoNoticia($idN){
            $query = "SELECT texto FROM contenidoNoticia WHERE id_noticia = ".$idN." ";
            $result = mysql_query($query);
            
            $rowList = mysql_fetch_assoc($result);
            
            return $rowList['texto'];
        }
    }
?>
