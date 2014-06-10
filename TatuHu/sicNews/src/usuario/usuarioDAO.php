<?php
    require 'usuario.class.php';
    
    class usuarioDAO{
        
        function agregar($obj){            
            $usu = new usuario();
            $usu = $obj;         
            if($this->existeUser($usu->getUser()) == 0){
                $query = "INSERT INTO usuario (nombre_usu, user, pass_usu, correo_usu, tipo_usu, preg_secreta, resp_secreta) VALUES ('".$usu->nombre."','".$usu->getUser()."','".  $this->codificar($usu->getPass())."','".$usu->correo."',".$usu->getTipo().",'".$usu->getPregunta()."','".$usu->getRespuesta()."')";
                return mysql_query($query);   
            }
            else{
                return -1;
            }
        }
        /**
         * Retorna > 0 si usuario existe, sino devuelve 0
         * @param text $user
         * @return int
         */
        function existeUser($user){
            $query = "SELECT id_usu FROM usuario WHERE user = '".$user."'";
            $result = mysql_query($query);
            return mysql_num_rows($result);
            
        }
        function editar($obj){
            $usu = new usuario();
            $usu = $obj; 
            $query = "UPDATE usuario SET nombre_usu = '".$usu->nombre."', correo_usu = '".$usu->correo."' WHERE id_noticia = ".$usu->id."";			
            return mysql_query($query);
        }
        function eliminar($idt){
            $query = "DELETE FROM usuario WHERE id_usu = ".$idt."";	
            return mysql_query($query);
        }
        function consultarLogin($usuario){
            $usu = new usuario();
            $usu = $usuario;
            $query = "SELECT id_usu, nombre_usu, user, tipo_usu, proxy FROM usuario, parametro WHERE user = '".$usu->getUser()."' AND pass_usu = '".strrev(base64_encode(md5($usu->getPass())))."' AND activo = 1 AND id_parametro = 1";
            $tabla = mysql_query($query);  
            if(mysql_num_rows($tabla) > 0){
                
                $rowUsu = mysql_fetch_assoc($tabla);
                session_start();
                $_SESSION['nombre'] = $rowUsu['nombre_usu'];
                $_SESSION['login'] = $rowUsu['user'];
                $_SESSION['tipoUs'] = $rowUsu['tipo_usu'];
                $_SESSION['idUsu'] = $rowUsu['id_usu'];
                if(isset($rowUsu['proxy'])){
                    $proxy = explode(":", $rowUsu['proxy']);
                    $_SESSION['proxy'] = $proxy[0];
                    $_SESSION['proxyport'] = $proxy[1];
                }
                else{
                    $_SESSION['proxy'] = NULL;
                    $_SESSION['proxyport'] = NULL;
                }
                
                $id = session_id();
                setcookie("idsession","$id",time()+3600,"/");
                date_default_timezone_set('America/Caracas');
                $band = 1;
            }
            else{
                $band = -1;
            }    
            return $band;
        }
        function updateField($field, $vaule,$id){
            if($field != 'pass_usu')
                $query = "UPDATE usuario SET ".$field." = '".$vaule."' WHERE id_usu = ".$id."";                         
            else
                $query = "UPDATE usuario SET ".$field." = '".$this->codificar($vaule)."' WHERE id_usu = ".$id."";                         
                
            return mysql_query($query);
        }
        function consultarTodos(){
            
            $arrayUsu = array();
            
            $query = "SELECT * FROM usuario";
            $result = mysql_query($query);  
            while ($obj = mysql_fetch_object($result)){
                $usu = new usuario();
                $usu->id = $obj->id_usu;
                $usu->nombre = $obj->nombre_usu;
                $usu->correo = $obj->correo_usu;
                $usu->activo = $obj->activo;
                $usu->setUser($obj->user);
                $usu->tipo_usu = $obj->tipo_usu;
                $arrayUsu[] = $usu;
                unset($usu);
            }
            return $arrayUsu;
        }
        //Cambiar estatus de usuario (ACTIVO/INACTIVO)
        function setStatus($id,$act){
            $query = "UPDATE usuario SET activo = '".$act."' WHERE id_usu = ".$id;
            if(mysql_query($query)){
                return 1;
            }
            else{
                return 0;
            }
        }
        function actualiza_cookie(){		
            session_start();
            $id = session_id();
            setcookie("idsession","$id",time()+3600,"/");
	}
        function codificar($str){
            return strrev(base64_encode(md5($str)));
        }
    }
?>
