<?php
require 'config.php';
require 'auth.php';
switch($_SESSION['usuario']['tipo']) {
    
    case 'ADMINISTRADOR':
        header("Location: administrador/index.php");
    break;
	
	case 'ADMINISTRADOR DE ESCUELA':
        header("Location: administrador/index.php");
    break;
	
	case 'ESTUDIANTE':
		header("Location: estudiante/index.php");
	break;
	
	case 'PROFESOR':                         //EH
		header("Location: docente/index.php");
	break;
}