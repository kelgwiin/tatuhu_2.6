<?php
    require 'vectorC.class.php';
    
    class vectCDAO{
        
        function consultarTodo($modo){
            
            switch ($modo){
                case 1:
                    $query = "SELECT * from vectCaracteristico";
                    $tabla = mysql_query($query);		
                    //$datos = mysql_fetch_row($tabla);
                    $array = array();
                    $i=0;
                    while($rowVect = mysql_fetch_assoc($tabla)){
                        $vect = new vectC();
                        $vect->setId($rowVect['id']);
                        $vect->setVectorC($rowVect['vector']);
                        $array[$i]= $vect;
                        $i++;            
                    }            
                    break;
                case 2:
                    $query = "SELECT * from vectCentros";
                    $tabla = mysql_query($query);		
                    //$datos = mysql_fetch_row($tabla);
                    $array = array();
                    $i=0;
                    while($rowVect = mysql_fetch_assoc($tabla)){
                        $vect = new vectC();
                        $vect->setId($rowVect['id']);
                        $vect->setNumGrupo($rowVect['num_grupo']);
                        $vect->setVectorC($rowVect['vector']);                        
                        $array[$i]= $vect;
                        $i++;            
                    }
                    break;
            }
            return $array;
        }
        
        function consultarVector($idt, $modo){            
            
            switch ($modo){                
                //Vector Caracteristico
                case 1:                    
                    $query = "SELECT * FROM vectCaracteristico WHERE id = '$idt'";
                    $tabla= mysql_query($query);		
                    $datos = mysql_fetch_row($tabla);
                    $vect = new vectC();
                    $vect->setId($rowVect['id']);
                    $vect->setVectorC($rowVect['vector']);                    
                    break;
                //Vector de Centros
                case 2:                    
                    $query = "SELECT * FROM vectCentros WHERE id = '$idt'";
                    $tabla= mysql_query($query);		
                    $datos = mysql_fetch_row($tabla);
                    $vect = new vectC();
                    $vect->setId($rowVect['id']);
                    $vect->setNumGrupo($rowVect['num_grupo']);
                    $vect->setVectorC($rowVect['vector']);     
                    break;          
            }
            return json_encode($vect);            
        }

        function guardar($obj){
            
            $vect = new vectC();
            $vect = $obj;
            $modo = $vect->tipoVector;
            
            switch ($modo){                
                //Vector Caracteristico
                case 1:                    
                    $query = "INSERT INTO vectCaracteristico (id_noticia,  vector_carac) VALUES ('$vect->id','$vect->vectorC')"; 
                    break;
                //Vector de Centros
                case 2:                    
                    $query = "INSERT INTO vectCentros (num_grupo, vector_cent) VALUES ('$vect->numGrupo','$vect->vectorC')"; 
                    break;                
            }
            
            return mysql_query($query);
        }
        
        function actualizar($obj){
            
            $vect = new vectC();
            $vect = $obj;
            $modo = $vect->tipoVector;
            
            switch ($modo){                
                //Vector Caracteristico
                case 1:    
                    $query = "UPDATE vectCaracteristico SET vector_carac = '$vect->vectorC' WHERE id_noticia = $vect->id";			
                    break;
                //Vector de Centros
                case 2:  
                    $query = "UPDATE vectCentros SET vector_cent = '$vect->vectorC' WHERE num_grupo = $vect->numGrupo";			
                    break;                
            }
            
            return mysql_query($query);
        }
    }
?>
