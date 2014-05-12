<?php
/*
	Archivo generado por el equipoPEI
	Funcion: Generar los parametros de conexion de BD
*/
	session_name('proyecto_pei');
	session_start();

    
    /* Informacion de base de datos */
		$db['usuario'] = 'aulatatuPEI';
		$db['pass']='20aulatatu13';
		$db['dbname']='TatuHu_aulaON';
		$db['host']='localhost';
		$db['port']='3306';
        $raiz_proyecto='/tatuhu_2.6/aula_tatu/';
    
    
/** ------------------------------ */
    /**
    * Funcion auxiliar para realizar transacciones utilizando mysqli
    * Se recomienda utilizarla solo para statements que modifiquen tablas
    * @warning Nota: para poder utilizar transacciones en MySQL, el motor de tablas debe ser InnoDB
    * 
    * @param mixed $queries Arreglo de consultas a realizar
    * @param mixed $results (output) Arreglo retornado con los objetos mysqli_results
    * @param int $errno
    * @param string $errstr
    */
    function mysqli_transaction($queries,&$results=array(),&$errno=null,&$errstr=null) {
        // Se debe establecer una conexion nueva
        GLOBAL $db;
        
        $mysqli=new mysqli($db['host'],$db['usuario'],$db['pass'],$db['dbname']);
        if (mysqli_connect_errno()) {
            $errno=mysqli_connect_errno();
            $errstr=mysqli_connect_error();
            return false;
        }
        //Charset a utf-8 (importantiiisimo!)
        $mysqli->set_charset('utf8');
        
        // Establecemos el 'autocommit' en falso (para permitir operaciones transaccionales)
        $mysqli->autocommit(false);
        
        // Recibiremos un array de diferente queries
        // Se ejecutaran una a una, verificando su estatus
        // Si alguna NO se ejecuta, se efectuara un rollback
        $i=0;
        foreach($queries as $query) {
            $results[$i]=$mysqli->query($query);
            if (!$results[$i]) {
                // No se pudo ejecutar la query
                // Se asignan las variables por referencias con la info del error
                $errno=mysqli_errno($mysqli);
                $errstr=mysqli_error($mysqli);
                
                // Se efectua el rollback
                $mysqli->rollback();
                
                // Se cierra la conexion con base de datos
                $mysqli->close();
                return false;
            }
            $i++;
        }
        // Si se llega a este punto, no ha habido ningun error por tanto
        // se puede hacer el commit final
        $mysqli->commit();
        // cerramos la conexion con la base de datos
        $mysqli->close();
        // Finalmente un return bonito ^^
        return true;
    }

    // Creamos una conexion simple en la variable global $db0
    // para el resto de las consultas a mysql
    $db0=@mysql_connect($db['host'].':'.(isset($db['port'])?$db['port']:'3306'),$db['usuario'],$db['pass']);
    if (!$db0) {
        $return=array('success'=>false,'error'=>'Error al conectar a base de datos','detalles'=>mysql_error());
        die(json_encode($return));
    }
    if (!@mysql_select_db($db['dbname'])) {
        $return=array('success'=>false,'error'=>'Error al conectar a base de datos','detalles'=>mysql_error());
        die(json_encode($return));
    }
    
    @mysql_set_charset('utf8');
    
    function error($errstr) {
        die($errstr);
    }
/** ------------------------------ */

    
    require 'plantilla/plantilla.php';
