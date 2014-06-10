<?php
    require '../conexion.php';
    
    class vectC{
        
        public $id;
        public $numGrupo;
        public $vectorC;
        public $tipoVector; //Tipo 1: Caracteristico - Tipo 2: Centros;


        //SETTERS
        
        function setId($idt){
            $this->id = $idt;
        }        
        function setNumGrupo($nGrupo){
            $this->numGrupo = $nGrupo;
        }
        function setVectorC($vector){
            $this->vectorC = $vector;
        }
        function setTipoVector($tipo){
            $this->tipoVector = $tipo;
        }
        
        //GETTERS
        
        function getId(){
            return $this->id;
        }        
        function getNumGrupo(){
            return $this->numGrupo;
        }
        function getVectorC(){
            return $this->vectorC;
        }
        function getTipoVector(){
            return $this->tipoVector;
        }
        
    }
?>
