<?php
require '../config.php';
require '../auth.php';

if($_SESSION['usuario']['tipo'] != 'ADMINISTRADOR' && $_SESSION['usuario']['tipo'] != 'ADMINISTRADOR DE ESCUELA') die('No autorizado');
p_set_rel_path('../');
$tab1 = $tab2 = $tab3 = $tab4 = $tab5 = "";
/*********************************
 * Estadisticas de las pestanias *
 *********************************/
//Cantidad de Usuarios, clasificados por activos y total
if ($_SESSION['usuario']['tipo'] == 'ADMINISTRADOR'){
	$query = 'SELECT COUNT(cedula) AS total, SUM(IF (activo="SI",1,0))as activos,  
           SUM(IF (activo="SI" AND tipo="PROFESOR",1,0)) as prof_act,
           SUM(IF (activo="SI" AND tipo="ESTUDIANTE",1,0)) as estd_act  FROM sist_usuario';
}
else{

	$query = 'SELECT COUNT(DISTINCT A.cedula) AS total, SUM(IF (A.activo="SI",1,0))as activos,  
           SUM(IF (A.activo="SI" AND A.tipo="PROFESOR",1,0)) as prof_act,
           SUM(IF (A.activo="SI" AND A.tipo="ESTUDIANTE",1,0)) as estd_act  FROM sist_usuario A, tbl_personas_seccion B, tbl_seccion C
		   WHERE A.cedula=B.id_persona AND B.id_seccion=C.id_seccion AND C.id_colegio="'.$_SESSION["datos_educativos"]["id_escuela"].'"';
}
if(!($q0=mysql_query($query))) error(mysql_error());
$cant =mysql_fetch_assoc($q0);
$cantU = $cant["total"];
$cantUA = $cant["activos"] - 1;
$cantPA = $cant["prof_act"] - 1;
$cantEAA = $cant["estd_act"];

//Cantidad de grados
$query = 'SELECT COUNT(id_grado) AS total FROM sist_grado WHERE activo="ACTIVO"';
if(!($q0=mysql_query($query))) error(mysql_error());
$cant =mysql_fetch_assoc($q0);
$cantG = $cant['total'];

if ($_SESSION['usuario']['tipo'] == 'ADMINISTRADOR'){
	//Cantidad de Institutos, clasificados por activos y total
	$query = 'SELECT COUNT(id_colegio) AS total, SUM(IF (activo="ACTIVO",1,0)) as activos FROM tbl_unidadeducativa';
	if(!($q0=mysql_query($query))) error(mysql_error());
	$cant =mysql_fetch_assoc($q0);
	$cantE = $cant["total"];
	$cantEA = $cant["activos"];
	//Porcentaje de escuelas ACTIVAS con usuarios registrados
	$query = 'SELECT COUNT(DISTINCT A.id_colegio) as cant_escuelas
			  FROM tbl_unidadeducativa A, tbl_personas_seccion B, tbl_seccion AS C 
			  WHERE B.id_seccion = C.id_seccion AND C.id_colegio=A.id_colegio AND A.activo="ACTIVO"';
	if(!($q0=mysql_query($query))) error(mysql_error());
	$cant =mysql_fetch_assoc($q0);
	$cantEE = $cant['cant_escuelas'];
}
//Cantidad de areas de aprendizaje 
$query = 'SELECT COUNT(id_area) as cant_areas FROM tbl_areasaprendizaje';
if(!($q0=mysql_query($query))) error(mysql_error());
$cant =mysql_fetch_assoc($q0);
$cantAA = $cant['cant_areas'];

/*********************************
 * Contenido    de las pestanias *
 *********************************/
//TAB 1: INFO GENERAL
if ($_SESSION['usuario']['tipo'] == 'ADMINISTRADOR'){
$tab1 = '<h5>Estad&iacute;sticas Generales:</h5><br><div class="facts clearfix secc">
        <div class="fact">
            <span class="fact-value">
            '.$cantU.'<span class="fact-unit">'.($cantU == 1 ? "Usuario": "Usuarios").'</span>
            </span> Cantidad de usuarios
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantE.'<span class="fact-unit">'.($cantE == 1 ? "Escuela": "Escuelas").'</span>
            </span> Cantidad de escuelas
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantEE.'<span class="fact-unit">'.(($cantEE==1)?"Escuela" : "Escuelas").'</span>
            </span> Escuelas con usuarios registrados
            <br>
        </div>
      </div> ';
}
//TAB 5: GRADOS
if($cantG>0){
//Cantidad de secciones
	if ($_SESSION['usuario']['tipo'] == 'ADMINISTRADOR'){
		$query = 'SELECT COUNT(id_seccion) AS total FROM tbl_seccion WHERE activa="SI"';
		if(!($q0=mysql_query($query))) error(mysql_error());
		$cant =mysql_fetch_assoc($q0);
		$cantS = $cant['total'];
		if ($cantS > 0){
			//Cantidad de Secciones con usuarios
			$query = 'SELECT COUNT(DISTINCT A.id_seccion) AS total FROM tbl_personas_seccion A, tbl_seccion B WHERE
					  A.id_seccion=B.id_seccion AND B.activa="SI"'; 
			if(!($q0=mysql_query($query))) error(mysql_error());
			$cant =mysql_fetch_assoc($q0);
			$cantPS = $cant['total'];
		}	
	}
	else{
		$query = 'SELECT COUNT(id_seccion) AS total FROM tbl_seccion WHERE activa="SI" AND id_colegio="'.$_SESSION["datos_educativos"]["id_escuela"].'"';
		if(!($q0=mysql_query($query))) error(mysql_error());
		$cant =mysql_fetch_assoc($q0);
		$cantS = $cant['total'];
		if ($cantS > 0){
			//Cantidad de Secciones con usuarios
			$query = 'SELECT COUNT(DISTINCT A.id_seccion) AS total FROM tbl_personas_seccion A, tbl_seccion B 
			          WHERE A.id_seccion=B.id_seccion AND B.id_colegio="'.$_SESSION["datos_educativos"]["id_escuela"].'" AND B.activa="SI"';
			if(!($q0=mysql_query($query))) error(mysql_error());
			$cant =mysql_fetch_assoc($q0);
			$cantPS = $cant['total'];
		}	
	}
$tab5 = '<h5>Estad&iacute;sticas de los Grados/Secciones:</h5><br><div class="facts clearfix secc">
        <div class="fact">
            <span class="fact-value">
            '.$cantG.'<span class="fact-unit">'.($cantG == 1 ? "Grado": "Grados").'</span>
            </span> Cantidad de Grados
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantS.'<span class="fact-unit">'.($cantS == 1 ? "Secci&oacute;n": "Secciones").'</span>
            </span> Cantidad de Secciones Activas
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantPS.'<span class="fact-unit">'.($cantPS == 1 ? "Secci&oacute;n": "Secciones").'</span>
            </span> Cantidad de Secciones con Usuarios 
            <br>
        </div>
      </div> ';
}
else{
    $tab2 = '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay grados registrados en el sistema</div>';
}
//TAB 2: USUARIOS 
if ($cantU > 0){
$porc =  round(($cantUA / $cantU)*100);
$i[0] =  round(($cantU * 25)/100);
$i[1] =  round(($cantU * 50)/100);
$i[2] =  round(($cantU * 75)/100);
$tab2 = '<h5>Estad&iacute;sticas de los Usuarios:</h5><br><div class="facts clearfix secc">
        <div class="fact">
            <span class="fact-value">
            '.$cantU.'<span class="fact-unit">'.($cantU == 1 ? "Usuario": "Usuarios").'</span>
            </span> Cantidad Total de Usuarios
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantUA.'<span class="fact-unit">'.($cantUA == 1 ? "Usuario": "Usuarios").'</span>
            </span> Cantidad de usuarios activos
            <br>
        </div>
       <div class="fact">
            <span class="fact-value">
            '.$cantPA.'<span class="fact-unit">'.($cantPA==1 ? "Profesor":"Profesores").'</span>
            </span> Cantidad de profesores activos
        </div>
       <div class="fact">
            <span class="fact-value">
            '.$cantEAA.'<span class="fact-unit">'.($cantEAA==1?"Estudiante":"Estudiantes").'</span>
            </span> Cantidad de estudiantes activos
        </div>
      </div>
      <p class="grafico" style="text-align:center;"><span class="info">Porcentaje de usuarios activos:</span><br><br>
      <span class="demo-progress" data-progress-options=\'{"size":false,"barClasses":["blue-gradient","glossy"],"innerMarks":25,"topMarks":25,"topLabel":"[value]%","bottomMarks":[{"value":0,"label":"0"},{"value":25,"label":"'.$i[0].'"},{"value":50,"label":"'.$i[1].'"},{"value":75,"label":"'.$i[2].'"},{"value":100,"label":"'.$cantU.'"}],"insetExtremes":true}\'>'.$porc.'%</span>
        <br><br>
        <p><span class="tip">'.$porc.'%</span> de usuarios activos ('.$cantUA.' '.($cantUA==1?"Usuario":"Usuarios").')<br>
            <strong>Total: </strong>'.$cantU.' '.$aux.'
      </p></p><br>';
}
else{
  $tab2 = '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay usuarios registrados en el sistema</div>';
}
//TAB 3: ESCUELAS
if ($cantE > 0){
$porc =  round(($cantEA / $cantE)*100, 2);
$i[0] =  round(($cantE * 25)/100);
$i[1] =  round(($cantE * 50)/100);
$i[2] =  round(($cantE * 75)/100);
  $tab3 = '<h5>Estad&iacute;sticas de las Escuelas:</h5><br><div class="facts clearfix secc">
        <div class="fact">
            <span class="fact-value">
            '.$cantE.'<span class="fact-unit">'.($cantE == 1 ? "Escuela": "Escuelas").'</span>
            </span> Cantidad Total de Escuelas
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantEA.'<span class="fact-unit">'.($cantEA == 1 ? "Escuela": "Escuelas").'</span>
            </span> Cantidad de Escuelas Activas
            <br>
        </div>
      </div>
       <p class="grafico" style="text-align:center;"><span class="info">Porcentaje de escuelas activas:</span><br><br>
      <span class="demo-progress" data-progress-options=\'{"size":false,"barClasses":["blue-gradient","glossy"],"innerMarks":25,"topMarks":25,"topLabel":"[value]%","bottomMarks":[{"value":0,"label":"0"},{"value":25,"label":"'.$i[0].'"},{"value":50,"label":"'.$i[1].'"},{"value":75,"label":"'.$i[2].'"},{"value":100,"label":"'.$cantE.'"}],"insetExtremes":true}\'>'.$porc.'%</span>
        <br><br>
        <p><span class="tip">'.$porc.'%</span> de escuelas activas ('.$cantEA.' '.($cantEA==1?"Escuela":"Escuelas").')<br>
            <strong>Total: </strong>'.$cantE.' '.($cantE == 1 ? "Escuela": "Escuelas").'
      </p></p><br>';
}
else{
  $tab3 = '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay escuelas registradas en el sistema</div>';
}
//TAB 4: AREAS DE APRENDIZAJE - CONTENIDOS
if($cantAA > 0){

$query = 'SELECT COUNT(id_componente) as cant_compo FROM tbl_componente';
if(!($q0=mysql_query($query))) error(mysql_error());
$cant =mysql_fetch_assoc($q0);
$cantComp = $cant['cant_compo'];
if ($cantComp > 0){
    $query = 'SELECT COUNT(id_contenido) as cant_content FROM tbl_contenido';
    if(!($q0=mysql_query($query))) error(mysql_error());
    $cant =mysql_fetch_assoc($q0);
    $cantC = $cant['cant_content'];
} else $cantC = 0;
if ($cantC>0){
     $query = 'SELECT COUNT(id_actividad) as cant_act FROM tbl_actividades';
    if(!($q0=mysql_query($query))) error(mysql_error());
    $cant =mysql_fetch_assoc($q0);
    $cantACT = $cant['cant_act'];
}
    $tab4 = '<h5>Estad&iacute;sticas de las &Aacute;reas de Aprendizaje:</h5><br><div class="facts clearfix secc">
        <div class="fact">
            <span class="fact-value">
            '.$cantAA.'<span class="fact-unit">'.($cantAA == 1 ? "&Aacute;rea": "&Aacute;reas").'</span>
            </span> Cantidad de &Aacute;reas de Aprendizaje
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantComp.'<span class="fact-unit">Comp.</span>
            </span> Cantidad de Componentes
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantC.'<span class="fact-unit">'.(($cantC==1)?"Contenido" : "Contenidos").'</span>
            </span> Cantidad de Contenidos (Temas)
            <br>
        </div>
        <div class="fact">
            <span class="fact-value">
            '.$cantACT.'<span class="fact-unit">'.(($cantACT==1)?"Act/Mat" : "Act/Mat").'</span>
            </span> Cantidad de Actividades y Materiales
            <br>
        </div>
      </div> ';
}
else{
  $tab4 = '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay escuelas registradas en el sistema</div>';
}

if ($_SESSION['usuario']['tipo'] == 'ADMINISTRADOR'){
p_contenido('centro','
      <div id="centro">
	    <div class="side-tabs same-height margin-bottom" style="clear:both;">
			 <ul class="tabs">
				<li><a href="#sidetab-1"> <img src=""><img src="../plantilla/img/icons_docente/chart_organisation.png"> Informaci&oacute;n General</a></li>
				<li><a href="#sidetab-2"> <img src=""><img src="../plantilla/img/icons_docente/user_go.png"> Usuarios</a></li>
				<li><a href="#sidetab-3"> <img src=""><img src="../plantilla/img/icons_docente/door_open.png"> Escuelas</a></li>
				<li><a href="#sidetab-5"> <img src=""><img src="../plantilla/img/icons_docente/award_star_gold_3.png"> Grados/Secciones</a></li>
				<li><a href="#sidetab-4"> <img src=""><img src="../plantilla/img/icons_docente/page_white_star.png"> Contenidos</a></li>
			 </ul>
			 <div class="tabs-content">
				<div id="sidetab-1" class=""><div class="tab-interno">'.$tab1.'</div></div>
				<div id="sidetab-2" class=""><div class="tab-interno">'.$tab2.'</div></div>
				<div id="sidetab-3" class=""><div class="tab-interno">'.$tab3.'</div></div>
				<div id="sidetab-4" class=""><div class="tab-interno">'.$tab4.'</div></div>
				<div id="sidetab-5" class=""><div class="tab-interno">'.$tab5.'</div></div>
			 </div>
		 </div>
		 </div>');
}
else{
p_contenido('centro','
      <div id="centro">
	    <div class="side-tabs same-height margin-bottom" style="clear:both;">
			 <ul class="tabs">
				<li><a href="#sidetab-2"> <img src=""><img src="../plantilla/img/icons_docente/user_go.png"> Usuarios</a></li>
				<li><a href="#sidetab-5"> <img src=""><img src="../plantilla/img/icons_docente/award_star_gold_3.png"> Grados/Secciones</a></li>
				<li><a href="#sidetab-4"> <img src=""><img src="../plantilla/img/icons_docente/page_white_star.png"> Contenidos</a></li>
			 </ul>
			 <div class="tabs-content">
				<div id="sidetab-2" class=""><div class="tab-interno">'.$tab2.'</div></div>
				<div id="sidetab-4" class=""><div class="tab-interno">'.$tab4.'</div></div>
				<div id="sidetab-5" class=""><div class="tab-interno">'.$tab5.'</div></div>
			 </div>
		 </div>
		 </div>');
}

p_js_agregar_texto('
	  $(document).ready(function(){
	  $(".demo-progress").progress();
	  });
	  ');

p_css_agregar_archivo("../plantilla/css/styles/progress-slider_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/estadisticasTabs_tatu.css");

p_js_agregar_archivo("plantilla/js/developr.progress-slider.js");
p_js_agregar_archivo("plantilla/js/developr.tabs.js");

p_con_shortcuts(true);
p_con_menu(true);

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');        //EH

p_con_pizarra(true);
if ($_SESSION['usuario']['tipo'] == 'ADMINISTRADOR')
	p_contenido('pizarra','Estad&iacute;sticas del Sistema');
else 
	p_contenido('pizarra','Estad&iacute;sticas de la escuela: '.$_SESSION["datos_educativos"]["nombre_colegio"]);
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Inicio');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();        
?>