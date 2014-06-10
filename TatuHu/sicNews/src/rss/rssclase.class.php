<?php
    require '../conexion.php';
    
    class rssclase{
        
        public $id;
        public $enlace;
        
        function setId($idt){
            $this->id = $idt;
        }
        
        function setEnlace($enlc){
            $this->enlace = $enlc;
        }
        
        function getId(){
            return $this->id;
        }
        
        function getEnlace(){
            return $this->enlace;
        }
        
    }
?>
