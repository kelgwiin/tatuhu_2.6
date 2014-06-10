<?php
    require '../conexion.php';
    
    class parametro{
        
        public $num_grupos;
        public $num_documentos;
        public $num_terminos;
        public $nivel_borrosidad;
        public $crit_agrupamiento;
        public $parametroParada;
        public $proxy;
        
        function setNumGrupos($nGrup){
            $this->num_grupos = $nGrup;
        }
        function setNumDocs($nDocs){
            $this->num_documentos = $nGrup;
        }
        function setNumTerm($nTerm){
            $this->num_terminos = $nTerm;
        }
        function  setNivelBorr($nBorr){
            $this->nivel_borrosidad = $nBorr;
        }
        function setCritAgrup($cAgrup){
            $this->crit_agrupamiento = $cAgrup;
        }
        function setParam($prmt){
            $this->parametroParada = $prmt;
        }
        function setProxy($proxy){
            $this->proxy = $proxy;
        }
        
        //GETTERS
        
        function getNumGrupos(){
            return $this->num_grupos;
        }
        function getNumDocs(){
            return $this->num_documentos;
        }
        function getNumTerm(){
            return $this->num_terminos;
        }
        function getNivelBorr(){
            return $this->nivel_borrosidad;
        }
        function getCritAgrup(){
            return $this->crit_agrupamiento;
        }
        function getParam(){
            return $this->parametroParada;
        }
        function getProxy(){
            return $this->proxy;
        }
        
    }
?>
