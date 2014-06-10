<?php
    require '../conexion.php';
    
    class grupo{
        
        public $id;
        public $idnoticia;
        public $numGrupo;
        public $nivelBorrosidad;
        public $criterioAgrupa;
        public $pert;
        
        //STTERS
        
        function setId($idt){
            $this->id = $idt;
        }
        function setIdnoticia($idt){
            $this->idnoticia = $idt;
        }
        function setNumGrupo($nGrupo){
            $this->numGrupo = $nGrupo;
        }
        function setNivelBorrosidad($nBorro){
            $this->nivelBorrosidad = $nBorro;
        }
        function setCriterioAgrupa($cAgrupa){
            $this->criterioAgrupa = $cAgrupa;
        }
        function setPertinencia($perti){
            $this->pert = $perti;
        }
        //GETTERS
        
        function getId(){
            return $this->id;
        }
        function getIdnoticia(){
            return  $this->idnoticia;
        }
        function getNumGrupo(){
            return $this->numGrupo;
        }
        function getNivelBorrosidad(){
            return $this->nivelBorrosidad;
        }
        function getCriterioAgrupa(){
            return $this->criterioAgrupa;
        }
        function getPertinencia(){
            return $this->pert;
        }
    }

?>
