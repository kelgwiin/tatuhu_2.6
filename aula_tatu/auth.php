<?php

if (isset($_POST['login']) && isset($_POST['pass']) && trim($_POST['login'])!='' && trim($_POST['pass'])!='') {
    $q0=mysql_query('SELECT * FROM sist_usuario WHERE usuario="'.mysql_escape_string($_POST['login']).'" AND activo="SI"');
    if (!$q0) die('Error de base de datos');
    if (mysql_num_rows($q0) != 1) {
        p_login_set_login_error('Usuario "'.$_POST['login'].'" no existe');
    }else{
        $usuario=mysql_fetch_assoc($q0);
        if((md5($_POST['pass']) == $usuario['password']) || $_POST['pass']==$usuario['password']) {
            $_SESSION['logueado']=true;
            $_SESSION['usuario']=$usuario;
			$query='SELECT * FROM tbl_personas AS A, sist_usuario AS B WHERE A.cedula=B.cedula AND A.cedula="'.$_SESSION['usuario']['cedula'].'"';
			//echo $query; die();
			$qa0=mysql_query($query);
			if(!$qa0) die('Error en la construccion del Nombre de Usuario <br>Error: '.mysql_error().'</b><br>Informe al Administrador de Sistema');
			$persona=mysql_fetch_assoc($qa0);
			$_SESSION['persona']=$persona;
			
        }else{
            p_login_set_login_error('Contraseña inválida');
        }
    }
    
}

if (!isset($_SESSION['logueado']) || $_SESSION['logueado']==false) {
    if (strtolower(($_SERVER['REQUEST_URI'])) != str_replace('//','/',$raiz_proyecto.'/index.php')) {
        header(str_replace('//','/',"Location: ".$raiz_proyecto.'/index.php'));
        die();
    }
    p_login_set_titulo('TATU HÚ');
    p_login_set_msg_titulo('Importante');
    p_login_set_msg_contenido('Coloca El usuario y contraseña que se le fue asignado para realizar las actividades, en caso de no contar con el acceso deseado comunicate con tu maestro o con el Administrador de Sistema <br> <div align="center"><b>¡Exitos!</div>');
    p_login_set_msg_img('images/nina_peq.png');
    p_login_set_form_action('index.php');
    p_dibujar('login');    
    
}