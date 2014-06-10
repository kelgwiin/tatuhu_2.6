<?php
    require '../conexion.php';
    class tf_idf{
        
        public $termino;
        public $id_not;
        public $valor;
        public $tf;
        public $df;
        
        function setTermino($term){
            $this->termino = $term;
        }
        function setId_not($id){
            $this->id_not = $id;
        }
        function setTf($rep){
            $this->tf = $rep;
        }
        function setDf($rep){
            $this->df = $rep;
        }
        function setValor($val){
            $this->valor = $val;
        }
        
        function getTermino(){
            return $this->termino;
        }
        function getId_not(){
            return $this->id_not;
        }
        function getTf(){
            return $this->tf;
        }
        function getDf(){
            return $this->df;
        }
        function getValor(){
            return $this->valor;
        }
    }
?>
