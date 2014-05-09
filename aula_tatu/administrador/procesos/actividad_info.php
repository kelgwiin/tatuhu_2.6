<?php
if (isset($_GET['actividad']) && $_GET['actividad'] != "" && 
    isset($_GET['tipo']) && $_GET['tipo'] != ""){
require '../../config.php';

//Querys segun el tipo de actividad
$query="";
$data="";
if ($_GET['tipo']=="sopaletras"){
    //TODO 
    $query="SELECT A.id_actividad,A.nombre_actividad,B.id_sopa,
            A.retroalimentacion, B.palabras, 
            C.contenido,D.componente,E.area_aprendizaje, F.tipo_actividad
            FROM tbl_actividades A
            JOIN 
            (SELECT B.palabras,B.id_sopa,B.id_actividad FROM tbl_act_sopadeletras B 
            WHERE B.id_actividad='".$_GET['actividad']."') B 
            ON B.id_actividad=A.id_actividad
            JOIN 
            (SELECT C.contenido,C.id_contenido,C.id_componente FROM tbl_contenido C) C
            ON A.id_contenido=C.id_contenido
            JOIN 
            (SELECT D.componente,D.id_componente,D.id_area FROM tbl_componente D) D
            ON C.id_componente=D.id_componente
            JOIN 
            (SELECT E.id_area,E.area_aprendizaje FROM tbl_areasaprendizaje E) E
            ON E.id_area=D.id_area
            JOIN
            (SELECT F.tipo_actividad,F.id_tipo FROM sist_actividad F) F
            ON A.tipo_actividad=F.id_tipo";
    $q0=mysql_query($query);
    if(!$q0){echo "0"; die(mysql_error());   }
    else{
        $row_datos =mysql_fetch_assoc($q0);
        $data="<strong>".$row_datos['palabras']."</strong><br>
               Palabras de la Sopa de Letras <br><br>";
    }
}
else if($_GET['tipo']=="crucigrama"){
        $query="SELECT A.id_actividad,B.palabras,B.pistas,A.nombre_actividad,
                A.retroalimentacion,C.contenido,D.componente,
                E.area_aprendizaje, F.tipo_actividad
                FROM tbl_actividades A
                JOIN 
                (SELECT B.palabras,B.pistas,B.id_actividad FROM tbl_act_crucigramas B 
                WHERE B.id_actividad='".$_GET['actividad']."') B 
                ON B.id_actividad=A.id_actividad
                JOIN 
                (SELECT C.contenido,C.id_contenido,C.id_componente FROM tbl_contenido C) C
                ON A.id_contenido=C.id_contenido
                JOIN 
                (SELECT D.componente,D.id_componente,D.id_area FROM tbl_componente D) D
                ON C.id_componente=D.id_componente
                JOIN 
                (SELECT E.id_area,E.area_aprendizaje FROM tbl_areasaprendizaje E) E
                ON E.id_area=D.id_area
                JOIN
                (SELECT F.tipo_actividad,F.id_tipo FROM sist_actividad F) F
                ON A.tipo_actividad=F.id_tipo";
    $q0=mysql_query($query);
    if(!$q0){echo "0"; die(mysql_error());   }
    else{
        $row_datos=mysql_fetch_assoc($q0);
        $palabras=split("#",$row_datos["palabras"]);  
        $pistas=split("#",$row_datos["pistas"]);
        $data="<strong>";
        $cant=count($palabras);
        for ($i=0; $i<$cant; $i++){
            $data.="<span style='color:green'>".$palabras[$i]."</span>: ";
            $data.=$pistas[$i]."<br>";
        }
        $data.="</strong><br>Palabras y Pistas del Crucigrama <br><br>";
    }
}
else if($_GET['tipo']=="pareo"){
    $query="SELECT A.id_actividad,B.imagenes,B.pistas,A.nombre_actividad,
        A.retroalimentacion,C.contenido,D.componente,
        E.area_aprendizaje, F.tipo_actividad
        FROM tbl_actividades A
        JOIN 
        (SELECT B.imagenes,B.pistas,B.id_actividad FROM tbl_act_pareo B 
        WHERE B.id_actividad='".$_GET['actividad']."') B 
        ON B.id_actividad=A.id_actividad
        JOIN 
        (SELECT C.contenido,C.id_contenido,C.id_componente FROM tbl_contenido C) C
        ON A.id_contenido=C.id_contenido
        JOIN 
        (SELECT D.componente,D.id_componente,D.id_area FROM tbl_componente D) D
        ON C.id_componente=D.id_componente
        JOIN 
        (SELECT E.id_area,E.area_aprendizaje FROM tbl_areasaprendizaje E) E
        ON E.id_area=D.id_area
        JOIN
        (SELECT F.tipo_actividad,F.id_tipo FROM sist_actividad F) F
        ON A.tipo_actividad=F.id_tipo";
    $q0=mysql_query($query);
    if(!$q0){echo "0"; die(mysql_error());   }
    else{
        $row_datos=mysql_fetch_assoc($q0);
        $img=split("#",$row_datos["imagenes"]);  
        $pistas=split("#",$row_datos["pistas"]);
        $data="<strong>";
        $cant=count($img);
        for ($i=0; $i<$cant; $i++){
            $data.="<span style='color:green'>".$pistas[$i]."</span>: ";
            $data.="<a href='../uploadActividades/".$img[$i]."' target='_blank' style=\"font-size:12px\">Clic para ver la Imagen</a><br>";
        }
        $data.="</strong><br>Palabras y Pistas del Pareo <br><br>";
    }
}
else if($_GET['tipo']=="pareodepalabras"){
    $query="SELECT A.id_actividad,B.palabras,B.pistas,A.nombre_actividad,
            A.retroalimentacion,C.contenido,D.componente,
            E.area_aprendizaje, F.tipo_actividad
            FROM tbl_actividades A
            JOIN 
            (SELECT B.palabras, B.pistas,B.id_actividad FROM tbl_act_pareopalabras B 
            WHERE B.id_actividad='".$_GET['actividad']."') B 
            ON B.id_actividad=A.id_actividad
            JOIN 
            (SELECT C.contenido,C.id_contenido,C.id_componente FROM tbl_contenido C) C
            ON A.id_contenido=C.id_contenido
            JOIN 
            (SELECT D.componente,D.id_componente,D.id_area FROM tbl_componente D) D
            ON C.id_componente=D.id_componente
            JOIN 
            (SELECT E.id_area,E.area_aprendizaje FROM tbl_areasaprendizaje E) E
            ON E.id_area=D.id_area
            JOIN
            (SELECT F.tipo_actividad,F.id_tipo FROM sist_actividad F) F
            ON A.tipo_actividad=F.id_tipo";
    $q0=mysql_query($query);
    if(!$q0){echo "0"; die(mysql_error());   }
    else{
        $row_datos=mysql_fetch_assoc($q0);
        $palabras=split("#",$row_datos["palabras"]);  
        $pistas=split("#",$row_datos["pistas"]);
        $data="<strong>";
        $cant=count($palabras);
        for ($i=0; $i<$cant; $i++){
            $data.="<span style='color:green'>".$palabras[$i]."</span>: ";
            $data.=$pistas[$i]."<br>";
        }
        $data.="</strong><br>Palabras y Pistas del Pareo <br><br>";
    }
}
?>
<h3 class="thin"> <span style="font-weight: bold;">Actividad: </span><?php echo $row_datos['nombre_actividad']; ?> </h3>
<div style="margin: 0 auto; max-width: 600px;">
<div style="min-width:200px;max-width:600px; margin: 0 auto;">
	<p class="big-message">
		<strong><?php echo $row_datos['tipo_actividad'];  ?></strong><br>
                Tipo de Actividad <br><br>
		<strong><?php echo (($row_datos['retroalimentacion']=="")?"-": $row_datos['retroalimentacion']); ?></strong><br>
                Retroalimentaci&oacute;n <br><br>
		<strong><?php echo $row_datos['area_aprendizaje'];   ?></strong><br>
                &Aacute;rea de Aprendizaje <br><br>
		<strong><?php echo $row_datos['componente'];   ?></strong><br>
                Componente <br><br>
		<strong><?php echo $row_datos['contenido'];   ?></strong><br>
                Contenido <br><br>
                <?php echo $data; ?>
	</p>
</div >
</div>
<?php
}

//}
else{
    echo "-1";
}
?>