<?php
require '../../config.php';
p_set_rel_path('../');
if (isset($_GET["id_area"]) && $_GET["id_area"] != "" &&
    isset($_GET["id_seccion"]) && $_GET["id_seccion"] != "" &&
    isset($_GET["nombre_seccion"]) && $_GET["nombre_seccion"] != "" &&
    isset($_GET["nombre_area"]) && $_GET["nombre_area"] != "" &&
    isset($_GET["id_grado"]) && $_GET["id_grado"] != ""){
echo '<h3 style="text-align:center;">Actividades de la secci&oacute;n '.$_GET["nombre_seccion"].' en el &aacute;rea: '.$_GET["nombre_area"].'</h3><br>';

//Cantidad de actividades en total del area y de los grados del profesor
$query ='SELECT COUNT(C.id_actividad) AS total
	 FROM tbl_actividades AS C, tbl_contenido AS D, tbl_componente AS E
	 WHERE C.usuario = "ESTUDIANTE" AND C.id_contenido = D.id_contenido
	 AND D.id_componente = E.id_componente AND E.id_grado ="'.$_GET["id_grado"].'"
	 AND D.id_area ="'.$_GET["id_area"].'"';
if(!($q0=mysql_query($query))) error(mysql_error());
$j =  mysql_fetch_assoc($q0);
$j = $j["total"];
if ($j > 0){
//Cantidad de actividades realizadas por los estudiantes de la seccion en un area de aprendizaje
$query ='SELECT E.tipo_actividad, COUNT(DISTINCT C.id_actividad) AS total
	 FROM tbl_persona_actividad AS A, tbl_personas_seccion AS B, tbl_actividades AS C,
	 tbl_contenido AS D, sist_actividad AS E
	 WHERE A.id_persona=B.id_persona AND B.id_seccion="'.$_GET["id_seccion"].'"
	 AND A.completada ="SI" AND A.id_actividad=C.id_actividad
	 AND C.id_contenido = D.id_contenido
	 AND D.id_area ="'.$_GET["id_area"].'" AND C.tipo_actividad=E.id_tipo
	 GROUP BY C.tipo_actividad';

if(!($q0=mysql_query($query))) error(mysql_error());
if (mysql_numrows($q0) >0){
    $tEst = 0;
    while( $a =  mysql_fetch_assoc($q0)){
	$actividades[] = array("tipo" => $a["tipo_actividad"], "total"=>$a["total"]);
	$tEst += $a["total"];
    }
	echo '<link rel="stylesheet" href="../plantilla/css/stylesUsuarios/docente.css">
	      <script src="../plantilla/js/developr.progress-slider.js"></script>
		   <script>
			$(".demo-progress2").progress();
		   </script>';
	$rend_general = round(($tEst/$j)*100); 
	$text1 = $cant==1? 'actividad' : 'actividades';
	echo '<p><span class="demo-progress2" data-progress-options=\'{"size":false,"barClasses":["blue-gradient","glossy"],"innerMarks":25,"topMarks":25,"topLabel":"[value]%","bottomMarks":[{"value":0,"label":"Ninguno"},{"value":25,"label":"Minimo"},{"value":50,"label":"Medio"},{"value":75,"label":"Bien"},{"value":100,"label":"Excelente"}],"insetExtremes":true}\'>'.$rend_general.'%</span></p>';
	$text2 = $j==1? 'actividad' : 'actividades';
	echo '<br><p style="text-align:center;">Los estudiantes han realizado en total <span class="tip">'.$tEst.'</span> '.$text1.' del &aacute;rea.<br>
		     El &aacute;rea <i>'.$_GET["nombreAre"].'</i> tiene <span class="tip">'.$j.'</span> '.$text2.'.
                </p>
	    <h5>Cantidad de Actividades realizadas por los estudiantes seg&uacute;n el tipo: </h5><br>';
	    $tablaACT .= '<div class="block large-margin-bottom" style="max-width:400px; margin:0 auto;">
			   <div class="block-title"><h3>Cantidad de Actividades por Tipo</h3></div>
			    <ul class="events">';
			    foreach($actividades as $valor){
			       $tablaACT .='<li><span class="event-date">'.$valor["total"].'</span>
					   <span class="event-description"><h4>'.$valor["tipo"].'</h4></span></li>';
			       
			    }
	    $tablaACT .= "</ul></div>";
	    echo $tablaACT;
    }
    else{
	echo '<div style="text-align:center; color:red;"><img src="../plantilla/img/standard/error.png"> Los estudiantes no han realizado actividades en esta &aacute;rea de aprendizaje</div>';
    }
}
else{
	echo '<div style="text-align:center; color:red;"><img src="../plantilla/img/standard/error.png"> El &aacute;rea seleccionada no tiene actividades registradas</div>';
}
}
else{
    echo "0";
}
?>