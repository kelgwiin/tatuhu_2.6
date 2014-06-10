<?php
    require '../conexion.php';
    
    class usuario{
        
        public $id;
        public $nombre;
        public $apellido;
        public $correo;
        public $activo;
        public $user;
        public $tipo_usu;
        private $pass;
        private $pregunta;
        private $respuesta;
        
        //SETTERS
        
        function setId($idt){
            $this->id = $idt;
        }
        function setNombre($nomb){
            $this->nombre = $nomb;
        }
        function setApellido($apell){
            $this->apellido = $apell;
        }
        function setCorreo($mail){
            $this->correo = $mail;
        }
        function setUser($us){
            $this->user = $us;
        }
        function setPass($pss){
            $this->pass = $pss;
        }
        function setTipo($tipo){
            $this->tipo_usu = $tipo;
        }
        function setPregunta($preg){
            $this->pregunta = $preg;
        }
        function setRespuesta($resp){
            $this->respuesta = $resp;
        }
        function setActivo($valor){
            $this->activo = $valor;
        }
        
        //GETTERS
        
        function getId(){
            return $this->id;
        }
        function getNombre(){
            return $this->nombre;
        }
        function getApellido(){
            return $this->apellido;
        }
        function getCorreo(){
            return $this->correo;
        }
        function getUser(){
            return $this->user;
        }
        function getPass(){
            return $this->pass;
        }
        function getTipo(){
            return $this->tipo_usu;
        }
        function getPregunta(){
            return $this->pregunta;
        }
        function getRespuesta(){
            return $this->respuesta;
        }
        function getValor(){
            return $this->activo;
        }
        
    }
?>
