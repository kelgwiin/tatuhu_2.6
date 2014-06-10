<?php
    require 'rssclase.class.php';

    class rssDAO{
        
        function consultarTodo(){
            $query = "SELECT * FROM rss";
            $tabla = mysql_query($query);
            $i = 0;
            $vect = array();
            while($datos = mysql_fetch_assoc($tabla)){
                $rss = new rssclase();
                $rss->setEnlace($datos['enlace_rss']);
                $rss->setId($datos['id_rss']);
                $vect[$i] = $rss;
                $i++;
            }        
            
            if($i>0){
               $result = $vect;
            }
            else{
                $result = -1;
            }
            return $result;
        }
        
        function consultarEnlaces(){
            $query = "SELECT * FROM rss";
            $tabla = mysql_query($query);
            $i = 0;
            $vect = array();
            while($datos = mysql_fetch_assoc($tabla)){
                $vect[$i] = $datos['enlace_rss'];
                $i++;
            }        
            
            if($i>0){
               $result = $vect;
            }
            else{
                $result = -1;
            }
            return $result;
        }
        
        function nuevoRss($url){
            
            $query = "SELECT * FROM rss WHERE enlace_rss = ('".$url."')";
            $res = mysql_query($query);
            $filas = mysql_num_rows($res);
            if($filas == 0){            
                $query = "INSERT INTO rss (enlace_rss) VALUES ('".$url."')";
                $result = mysql_query($query);
            }
            else{
                $result = -1;
            }
            
            return $result;
        }
        
        function eliminarRss($vectRss){
            
            $result = 1;
            for($i=0;$i<count($vectRss);$i++){
                $query = "DELETE FROM rss WHERE id_rss = ".$vectRss[$i]."";
                $band = mysql_query($query);                
                if($band != TRUE){
                    $result = -1;
                }
            }
            return $result;
        }
    }
?>
