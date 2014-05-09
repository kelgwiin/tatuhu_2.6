<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'PROFESOR') die('No autorizado');
p_set_rel_path('../');
$secc="";
$tabIns = "";
//Preparando datos educativos almacenados en $_SESSION
foreach ($_SESSION['datos_educativos'] as $val){
    $secc[] = $val["id_seccion"];
    $grad[] = $val["id_grado"];
    $nombresGrad[] = $val["nombre_grado"].'-'.$val["nombre_seccion"];
    $tabIns .= '<li><span class="event-date" style="font-size:20px;">'.$val["nombre_grado"].'-'.$val["nombre_seccion"].'</span>
			  <span class="event-description"><h4>'.$val["nombre_colegio"].'</h4></span></li>';
}
/*************************************************************
 *   Consulta de los grados/secciones que maneja el Docente, *
 *   asi como tambien de la cantidad de estudiantes activos  *
 *   que tiene cada una					     *
 *************************************************************/
$query = 'SELECT A.id_seccion, COUNT( A.id_persona ) -1 total FROM tbl_personas_seccion A
INNER JOIN ( SELECT B.id_seccion FROM tbl_personas_seccion B
INNER JOIN tbl_seccion C ON B.id_seccion = C.id_seccion AND B.id_seccion IN('.implode(",",$secc).')
INNER JOIN sist_grado D ON C.id_grado = D.id_grado AND D.activo="ACTIVO"
WHERE B.id_persona = "'.$_SESSION["persona"]["cedula"].'" AND C.activa = "SI") secciones
ON secciones.id_seccion = A.id_seccion
INNER JOIN sist_usuario U ON A.id_persona = U.cedula AND U.activo = "SI"
GROUP BY A.id_seccion';

if(!($q0=mysql_query($query))) error(mysql_error());
$cantidad_secciones = mysql_numrows($q0);
$contenido = "";
if ($cantidad_secciones > 0){
  $tab1 = "";
  $graf = "";
  $cantidad_totalEST = 0;
  $datos_seccion =  Array();
  $i = 0;
    while($qa0=mysql_fetch_assoc($q0)){
	  $datos_seccion[$i]["nombre"] = $nombresGrad[$i];
	  $datos_seccion[$i]["cant_est"] = $qa0['total'];
	  $datos_seccion[$i]["id_seccion"] = $qa0['id_seccion'];
	  $datos_seccion[$i]["id_grado"] = $grad[$i];
         //Nombre de las secciones para mostrar en tab1
	  $text2 .= '<span class="fact-value">'.$qa0['grado'].'
                    <span class="fact-unit">'.$qa0['seccion'].'</span>
                    </span>';
	  $cantidad_totalEST += $qa0['total'];
          $i++;
    }
    $text1 = $cantidad_secciones == 1? 'Secci&oacute;n' : 'Secciones';
    $text2 .= "Secciones<br>";
    $text3 = $cantidad_totalEST == 1? 'Estudiante' : 'Estudiantes';
    if ($cantidad_totalEST >0){
      $tabs = "";
      $pest = "";
       /***************************************************************************
       *   Consulta de la cantidad total de Actividades para estudiantes          *
       *   en los GRADOS del profesor, Clasificadas por grado	                  * 					    *
       ****************************************************************************/
       $query = 'SELECT B.id_grado, COUNT( A.id_actividad ) AS total FROM tbl_actividades A, tbl_componente B, tbl_contenido C
		 WHERE A.id_contenido = C.id_contenido AND C.id_componente = B.id_componente AND
		 B.id_grado IN ('.implode(',',$grad).') AND A.usuario ="ESTUDIANTE" GROUP BY B.id_grado';
	if(!($q0=mysql_query($query))) error(mysql_error());
	$cantidad_totalACT = 0;
	while($qa0=mysql_fetch_assoc($q0)){
	    $actividades_grado["grado"][] = $qa0["id_grado"];
	    $actividades_grado["cant_act"][] = $qa0["total"];
	    $cantidad_totalACT += $qa0["total"];
	}

       /***************************************************************************
       *   Consulta de la cantidad total de Actividades realizada por estudiantes *
       *   en las SECCIONES del profesor, Clasificadas por seccion                * 					    *
       ****************************************************************************/
      $query = 'SELECT B.id_seccion, COUNT(DISTINCT A.id_actividad) AS total
                  FROM tbl_persona_actividad AS A, tbl_personas_seccion AS B, sist_usuario AS C
                  WHERE C.cedula=A.id_persona AND C.activo="SI" AND A.id_persona=B.id_persona
                  AND B.id_seccion IN ('.implode(',',$secc).') AND A.completada="SI"
		  GROUP BY B.id_seccion';
      if(!($q0=mysql_query($query))) error(mysql_error());
      $cantidad_totalACTEST = 0;
      while($qa0=mysql_fetch_assoc($q0)){
	  $actividades_seccion["id_seccion"][] = $qa0["id_seccion"];
	  $actividades_seccion["cant_act"][] = $qa0["total"];
	  $cantidad_totalACTEST += $qa0["total"];
      }
      if ($cantidad_totalACTEST > 0){
	
      /****************************************************************************
       *  Cantidad de Actividades realizadas por los estudiantes por actividad    *
       *  y por seccion								  *
       ****************************************************************************/
      $query = 'SELECT acts.id_seccion, A.tipo_actividad, A.id_tipo, COUNT( A.id_tipo ) AS total
		  FROM sist_actividad A INNER JOIN (
		  SELECT DISTINCT B.id_actividad, E.tipo_actividad, C.id_seccion
		  FROM tbl_persona_actividad B
		  INNER JOIN tbl_actividades E ON E.id_actividad = B.id_actividad AND B.completada = "SI"
		  INNER JOIN tbl_personas_seccion C ON B.id_persona = C.id_persona AND C.id_seccion IN ('.implode(',',$secc).')
		  INNER JOIN sist_usuario U ON U.cedula = C.id_persona
		  AND U.activo = "SI")acts ON acts.tipo_actividad = A.id_tipo
		  GROUP BY acts.id_seccion, A.id_tipo';
	if(!($q0=mysql_query($query))) error(mysql_error());
	$cantAct = mysql_numrows($q0);
	if ($cantAct>0){
	    while($qa0 = mysql_fetch_assoc($q0)){
		$actividades_tipo_seccion[$qa0["id_seccion"]][] = array("nombre"=> $qa0["tipo_actividad"], "id_tipo" => $qa0["id_tipo"],"total"=> $qa0["total"]);
	    }
	}
	
       /***************************************************************************
       *                       Consulta de las Areas de Aprendizaje               *
       ****************************************************************************/
       $query='SELECT DISTINCT id_area,area_aprendizaje, imagen,id_grado FROM tbl_areasaprendizaje 
              WHERE activo="SI" AND id_grado IN('.implode(',',$grad).')';
       if(!($q0=mysql_query($query))) error(mysql_error());
       $datos_area= array();
       $cant_areas = mysql_numrows($q0);
        while($qa0=mysql_fetch_assoc($q0)) {
	  $datos_area["id_area"][] = $qa0['id_area'];
	  $datos_area["nombre"][] = $qa0['area_aprendizaje'];
          $datos_area["id_grado"][] = $qa0['id_grado'];
	  $datos_area["imagen"][] = p_get_rel_path().'/uploadImages/AA/'.$qa0['imagen'];
	}
      }
      //Creando tabs para cada seccion
      for ($i = 0; $i<$cantidad_secciones; $i++){
         $tab = "";
	 $tablaACT = "";
	 $pest .='<li><a href="#sidetab-'.($i+2).'">
		  <img src="../plantilla/img/icons_docente/award_star_gold_3.png"> Secci&oacute;n '.$nombresGrad[$i].'</a></li>';
	    if ($datos_seccion[$i]["cant_est"] == 0){
		$tab = '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay estudiantes registrados en esta secci&oacute;n, para mayor informaci&oacute;n consulte al administrador del sistema</div>';;
	    }
	    else{
	      $aux = $datos_seccion[$i]["cant_est"]==1 ? 'Estudiante':'Estudiantes';
	      $tab .= '<div class="facts clearfix secc">
			<div class="fact">
			    <span class="fact-value">
			    '.$datos_seccion[$i]["cant_est"].'<span class="fact-unit">'.$aux.'</span>
			    </span> Cantidad de estudiantes de la secci&oacute;n
			    <br>
			</div>
		      </div><br><span class="info">Porcentaje General de Actividades realizadas:</span>
			  <span class="info-spot">
			    <span class="icon-info-round"></span>
			      <span class="info-bubble">
				  Este rendimiento representa una comparaci&oacute;n entre el n&uacute;mero
				  de actividades que han realizado los estudiantes de esta secci&oacute;n
				  y la cantidad total de actividades que hay en el grado.
			      </span>
			    </span><br><br><br>';
	      	
	      if (($pos1=array_search($datos_seccion[$i]["id_grado"], $actividades_grado["grado"])) !== false ){
		$rend_seccion = 0;
		$AS = 0;
		if (($pos2 = array_search($datos_seccion[$i]["id_seccion"], $actividades_seccion["id_seccion"])) !== false ){
		  //calculo del rendimiento por seccion
		  $rend_seccion = round((($actividades_seccion["cant_act"][$pos2]/
					  $datos_seccion[$i]["cant_est"])/
					 $actividades_grado["cant_act"][$pos1])* 100);
		  $AS = $actividades_seccion["cant_act"][$pos2];
		}
		if($AS){
		  if ($cant_areas > 0){//Creando enlaces de las areas de aprendizaje
		    $enlaces = "";
		    for ($j = 0; $j < $cant_areas; $j++){
                      if ($datos_area["id_grado"][$j] == $datos_seccion[$i]["id_grado"])
		      $enlaces.='<a href="" id="'.$datos_area["id_area"][$j].'/'.$datos_seccion[$i]["id_seccion"].'/'.
				$datos_seccion[$i]["nombre"].'/'.$datos_seccion[$i]["id_grado"].'" alt="'.$datos_area["nombre"][$j].'" class="area"><img src="'.$datos_area["imagen"][$j].'" class="imgarea"></a>';
		    }
		  }
		  $tab .= '<p><span class="demo-progress" data-progress-options=\'{"size":false,"barClasses":["blue-gradient","glossy"],"innerMarks":25,"topMarks":25,"topLabel":"[value]%","bottomMarks":[{"value":0,"label":"Ninguno"},{"value":25,"label":"Minimo"},{"value":50,"label":"Medio"},{"value":75,"label":"Bien"},{"value":100,"label":"Excelente"}],"insetExtremes":true}\'>'.$rend_seccion.'%</span></p>
			  <br><br>
			  <p>Los estudiantes han realizado en total <span class="tip">'.$AS.'</span> actividades.<br>
				 Este grado tiene un total de <span class="tip">'.$actividades_grado["cant_act"][$pos1].'</span> actividades.
			  </p>
			  <h5>Porcentaje General de Actividades por &Aacute;rea de Aprendizaje</h5><br><div id="areas"><div class="mensaje"></div>'.$enlaces.'</div>';
		  if (isset($actividades_tipo_seccion[$datos_seccion[$i]["id_seccion"]])){
		      //tabla con actividades por seccion
		     $tablaACT .= '<div class="block large-margin-bottom" style="max-width: 500px; margin:0 auto;">
				    <div class="block-title"><h3>Cantidad de Actividades por Tipo</h3></div>
				    <ul class="events">';
		     foreach($actividades_tipo_seccion[$datos_seccion[$i]["id_seccion"]] as $valor){
			$tablaACT .='<li><span class="event-date">'.$valor["total"].'</span>
				    <span class="event-description"><h4>'.$valor["nombre"].'</h4></span></li>';
			
		     }
		     $tablaACT .= "</ul></div>";
		     $tab .= $tablaACT;
		  }
		}
		else{
		  $tab .= '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> Los estudiantes de esta secci&oacute;n no han realizado actividades</div>';
		}
	      }
	      else{ //NO hay actividades registradas en el grado
		$tab .= '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay actividades registradas en este grado, para mayor informaci&oacute;n consulte al administrador del sistema</div>';
	      }
	    }
	    $tabs .= '<div id="sidetab-'.($i+2).'">
		      <div class="tab-interno">
			<h4>Secci&oacute;n: '.$nombresGrad[$i].'</h4>
                        <h6>Escuela: '.$_SESSION["datos_educativos"][$i]["nombre_colegio"].'</h6><br>
			'.$tab.'
		  </div></div>';
      }
      //Contenidos del tab1 
      if ($cantidad_totalACT >0){
	$rend_general = round((($cantidad_totalACTEST/$cantidad_totalEST)/$cantidad_totalACT)* 100);
	$graf = '<br><p><span class="info">Porcentaje General de Actividades realizadas de las Secciones</span>
		        <span class="info-spot">
                        <span class="icon-info-round"></span>
                          <span class="info-bubble">
                              Este rendimiento representa una comparaci&oacute;n entre el n&uacute;mero
                              de actividades que han realizado los estudiantes y la cantidad total de
                              actividades que hay en los grados a su cargo.
                          </span>
                        </span></p><br>
                      <p><span class="demo-progress" data-progress-options=\'{"size":false,"barClasses":["blue-gradient","glossy"],"innerMarks":25,"topMarks":25,"topLabel":"[value]%","bottomMarks":[{"value":0,"label":"Ninguno"},{"value":25,"label":"Minimo"},{"value":50,"label":"Medio"},{"value":75,"label":"Bien"},{"value":100,"label":"Excelente"}],"insetExtremes":true}\'>'.$rend_general.'%</span></p>
                        <br><br>
                        <p>Los estudiantes han realizado en total <span class="tip">'.$cantidad_totalACTEST.'</span> actividades.<br>
                           Los grados a su cargo tienen un total de <span class="tip">'.$cantidad_totalACT.'</span> actividades.
                      </p>';
      }
      else{
	$graf = '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay actividades registradas en los grados, para mayor informaci&oacute;n consulte al administrador del sistema</div>';
      }
      
      //Tab 1: se muestra informacion de las seciones del profesor
      $tab1 = '<h5>Informaci&oacute;n General de las Secciones</h5><br>
            <div class="facts clearfix">
                <div class="tab-inter">
                <div class="fact">
                    <span class="fact-value">
                    '.$cantidad_secciones.'<span class="fact-unit">'.$text1.'</span>
                    </span> Cantidad de Secciones a su cargo
                    <br>
                </div>
                <div class="fact">
                    <span class="fact-value">
                      '.$cantidad_totalEST.'<span class="fact-unit">'.$text3.'</span>
                    </span> Total de Estudiantes
                    <br>
                </div>
                </div>
	         </div>
       <div class="block large-margin-bottom" style="max-width:400px; margin:0 auto;">
       <div class="block-title"><h3>Secciones y Escuelas</h3></div>
	<ul class="events">'.$tabIns.'</ul></div>'.$graf;
      $contenido='<div class="side-tabs same-height margin-bottom" style="clear:both;">
		 <ul class="tabs">
                    <li><a href="#sidetab-1"> <img src="../plantilla/img/icons_docente/chart_organisation.png"> Informaci&oacute;n General</a></li>
		  '.$pest.'
		 </ul>
		 <div class="tabs-content">
		    <div id="sidetab-1" class=""><div class="tab-interno">'.$tab1.'</div></div>
		  '.$tabs.'
	         </div>';
    }
    else{
      $contenido = '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No hay estudiantes registrados en las secciones, para mayor informaci&oacute;n consulte al administrador del sistema</div>';
    }
  }
  else{
   $contenido = '<div style="color:red;"><img src="../plantilla/img/standard/error.png"> No tiene secciones asignadas, o sus secciones est&aacute;n inactivas. Para m&aacute;s informaci&oacute;n, consulte al administrador del sistema</div>';
  }

p_contenido('centro','
	<div id="centro">
		<h3 class="thin" style="text-align:center;"><span class="info">Informaci&oacute;n de las Secciones</span></h3><br>
		<div id="areaProfesor">
                 '.$contenido.'
		</div>
	</div>
');
p_js_agregar_texto('
$(document).ready(function(){
$(".demo-progress").progress();

function abrirModal(data){
$(".mensaje").html(" ");
$.modal({
    content: data,
    title: "",
    width: 800,
    height: 600,
    scrolling: false,
    actions: {
            "Cerrar" : {
                    color: "red",
                    click: function(win) { win.closeModal(); }
            }
    },
    buttons: {
            "Cerrar": {
                    classes:"huge blue-gradient glossy full-width",
                    click:	function(win) { win.closeModal(); }
            }
    },
    buttonsLowPadding: true
});
}

$(".area").click(function(event){
event.preventDefault();
var data = $(this).attr("id").split(\'/\'); 
var idA = data[0];//
var idS = data[1];//
var noS = data[2];//
var idG = data[3];//
var noA = $(this).attr("alt");//
if (idA !="" && idS!="" && noS!="" && idG!="" && noA!="" ){
$.blockUI({ message: "<h4 class=\"thin\" style=\"padding:20px;\"><img src=\"../plantilla/img/standard/loaders/loading16.gif\" /> Cangando informaci&oacute;n, por favor espere...</h4>" });
$.get("procesos/rendimiento_area.php", {id_area: idA, nombre_area: noA, id_seccion: idS, nombre_seccion: noS, id_grado:idG })
.done(function(data) {
$.unblockUI();
if (data != "0"){
abrirModal(data);
}
else{
$(".mensaje").html("<div style=\"text-align:center; color:red;\"><img src=\"../plantilla/img/standard/error.png\"> Hubo un error al tratar de recuperar el rendimiento, recargue la p&aacute;gina e intente nuevamente</div>");
}
});
}
});
});
');

p_con_shortcuts(true);
p_con_menu(true);

p_css_agregar_archivo("../plantilla/css/styles/agenda_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/dashboard_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/progress-slider_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/areasAprendizaje_tatu.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/estadisticasTabs_tatu.css"); 

p_js_agregar_archivo("plantilla/js/developr.modal.js");
p_js_agregar_archivo("plantilla/js/developr.scroll.js");
p_js_agregar_archivo("plantilla/js/developr.progress-slider.js");
p_js_agregar_archivo("plantilla/js/libs/jquery.blockUI.min.js");
p_js_agregar_archivo("plantilla/js/developr.tabs.js");

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');

p_con_pizarra(true);
p_contenido('pizarra','Resumen del Rendimiento Estudiantil');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Inicio');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();  

?>