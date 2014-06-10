<?php
    require '../conexion.php';
    
    class noticia{
        
        public $id;
        public $dir;
        public $nomb;
        public $dir_html;
        public $dir_pagina;
        
        //SETTERS
        
        function setId($idt){
            $this->id = $idt;
        }
        function setDirec($direc){
            $this->dir = $direc;            
        }
        function setNomb($nombre){
            $this->nomb = $nombre;
        }
        function setDirHtml($html){
            $this->dir_html = $html;
        }
        function setDirPag($enlace){
            $this->dir_pagina = $enlace;
        }
        
        //GETTERS
        
        function getId(){
            return $this->id;
        }
        function getDir(){
            return $this->dir;
        }
        function getNomb(){
            return $this->nomb;
        }
        function getDirHtml(){
            return $this->dir_html;
        }
        function getDirPag(){
            return $this->dir_pagina;
        }
    }
    
    class noticia_ext extends noticia{
        
        public $pert;
        public $fecha_inicio;
        public $fecha_fin;
       
        function noticia_ext($idt, $direc, $nombr, $perti){
            $this->id   = $idt;
            $this->dir  = $direc;
            $this->nomb = $nombr;
            $this->pert = $perti;
        }
        function setPertinencia($p){
            $this->pert = $p;
        }
        function setFechaInicio($fech){
            $this->fecha_inicio = $fech;
        }
        function setFechaFin($fech){
            $this->fecha_fin = $fech;
        }
        function getPertinencia(){
            return $this->pert;
        }
        function getFechaInicio(){
            return $this->fecha_inicio;
        }
        function getFechaFin(){
            return $this->fecha_fin;
        }

    }
?>
