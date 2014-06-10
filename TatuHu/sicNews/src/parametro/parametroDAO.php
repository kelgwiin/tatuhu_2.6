<?php
    require 'parametro.calss.php';
    
    class parametroDAO{
        
        function modificarNumGrupos($numGrup){
            $query = "UPDATE parametro SET cant_grupos = '$numGrup' WHERE id_parametro = 1";
            mysql_query($query);
        }
        function modificarNumDocs($numDocs){
            $query = "UPDATE parametro SET cant_docs = '$numDocs' WHERE id_parametro = 1";
            mysql_query($query);
        }
        function modificarNumTerm($numTerm){
            $query = "UPDATE parametro SET cant_term = '$numTerm' WHERE id_parametro = 1";
            mysql_query($query);
        }
        function modificarNivelBorr($nivelBo){
            $query = "UPDATE parametro SET nivel_borrosidad = '$nivelBo' WHERE id_parametro = 1";
            mysql_query($query);
        }
        function modificarCritAgrup($critAgru){
            $query = "UPDATE parametro SET criterio_agrupa = '$critAgru' WHERE id_parametro = 1";
            mysql_query($query);
        }
        function modificarParam($paramt){
            $query = "UPDATE parametro SET param = '$paramt' WHERE id_parametro = 1";
            mysql_query($query);
        }
        function editarParametros($obj){
            $parametro = new parametro();
            $parametro = $obj;
            $query  = "UPDATE parametro SET cant_grupos = ".$parametro->getNumGrupos().", nivel_borrosidad = ".$parametro->getNivelBorr().", param = ".$parametro->getParam();
            $query .= ", proxy = ".(isset($parametro->proxy) ? "'".$parametro->getProxy()."'" : 'NULL')."";
            $query .= " WHERE id_parametro = 1";
            return mysql_query($query);
        }


        function consultarValores(){
            
            $valores = new parametro();
            
            $query = " SELECT * FROM parametro WHERE id_parametro = 1";
            $tabla = mysql_query($query);
            $rowParam = mysql_fetch_assoc($tabla);
            
            $valores->num_grupos        = $rowParam['cant_grupos'];
            $valores->num_documentos    = $rowParam['cant_docs'];
            $valores->num_terminos      = $rowParam['cant_term'];
            $valores->nivel_borrosidad  = $rowParam['nivel_borrosidad'];
            $valores->crit_agrupamiento = $rowParam['criterio_agrupa'];
            $valores->parametroParada   = $rowParam['param'];
            
            return $valores;
        }
        
        function consultarNumTerm(){
            
            $query = " SELECT cant_term FROM parametro WHERE id_parametro = 1";
            $tabla = mysql_query($query);
            $rowParam = mysql_fetch_assoc($tabla);
            return $rowParam['cant_term'];
            
        }
        function consultarDatos(){
            
            $valores = new parametro();
            
            $query = " SELECT * FROM parametro WHERE id_parametro = 1";
            $tabla = mysql_query($query);
            $rowParam = mysql_fetch_assoc($tabla);
            
            $valores->num_grupos        = $rowParam['cant_grupos'];
            $valores->num_documentos    = $rowParam['cant_docs'];
            $valores->num_terminos      = $rowParam['cant_term'];
            $valores->nivel_borrosidad  = $rowParam['nivel_borrosidad'];
            $valores->crit_agrupamiento = $rowParam['criterio_agrupa'];
            $valores->parametroParada   = $rowParam['param'];         
            $valores->proxy             = $rowParam['proxy'];         
            
            return json_encode($valores);
        }
        function numNoticiasNuevas(){
            
            $total = count(glob("../../web/files/{*.txt}",GLOB_BRACE));
            return $total;

        }
    }

?>
