<?php
require '../config.php';
if($_SESSION['usuario']['tipo'] != 'PROFESOR') die('No autorizado');
p_set_rel_path('../');

if (isset($_GET['id']) && $_GET['id'] != ""
    && isset($_GET['grado']) && $_GET['grado'] != ""
    && isset($_GET['id_seccion']) && $_GET['id_seccion'] != ""){
$tab1="";
$tab2="";
$tab3="";
$tab4="";
/***************************************************************
 *   Informacion del Estudiante                                *
 ***************************************************************/
$query='SELECT A.nombre, A.apellido,A.fecha_nacimiento, A.sexo,A.correo,A.telefono,
        C.ruta_imagen, E.seccion,F.grado, G.nombre_colegio,
         TIMESTAMPDIFF(YEAR, A.fecha_nacimiento, NOW()) edad
	FROM tbl_personas AS A, sist_usuario AS B, tbl_avatar AS C,
        tbl_seccion E, sist_grado F, tbl_unidadeducativa G
	WHERE A.cedula ="'.$_GET['id'].'" AND B.cedula = A.cedula AND B.id_avatar = C.id_imagen
            AND E.id_seccion="'.$_GET["id_seccion"].'" AND E.id_grado=F.id_grado
            AND E.id_colegio= G.id_colegio';
if(!($q1=mysql_query($query))) error(mysql_error());
if(mysql_numrows($q1)>0){
    $datos_estudiante = mysql_fetch_assoc($q1);
    $datos_estudiante['sexo'] = $datos_estudiante['sexo']== 'MASCULINO'?'Masculino' : 'Femenino';
    //Fecha de nacimiento
    $dia = split("-" , $datos_estudiante['fecha_nacimiento'])[2];
    $mes = split("-" , $datos_estudiante['fecha_nacimiento'])[1];
    $anio = split("-" , $datos_estudiante['fecha_nacimiento'])[0];
    $tab1 = '<div style="margin:20px;"><h5>Datos personales de: '.$datos_estudiante['nombre'].' '.$datos_estudiante['apellido'].'</h5><br>
            <table class="info-usuario">
            <tr style="margin: 0 auto; max-width:700px;">
                <td style="width:70%; padding:10px;">
                  <p class="big-message" style="text-align:left; max-width:600px;">
                   <strong> '.$_GET['id'].'</strong></br>C&eacute;dula del Estudiante  </br></br>
                    <strong> '.$dia.'/'.$mes.'/'.$anio.'</strong></br>Fecha de Nacimiento  </br></br>
                    <strong> '.$datos_estudiante['edad'].'</strong></br>Edad  </br></br>
                    <strong> '.$datos_estudiante['sexo'].'</strong></br>Sexo  </br></br>
                    <strong> '.($datos_estudiante['correo']==""?"-":$datos_estudiante['correo']).'</strong></br>Correo  </br></br>
                        <strong> '.($datos_estudiante['telefono']==""|| $datos_estudiante['telefono']=="0"?"-":$datos_estudiante['telefono']).'</strong></br>Tel&eacute;fono  </br></br>
                    <strong> '.$datos_estudiante['nombre_colegio'].'</strong></br>Instituto  </br></br>
                    <strong> '.$datos_estudiante['grado'].'-'.$datos_estudiante['seccion'].'</strong></br>Secci&oacute;n  </br></br>   
                   </p><br>
                </td>
                <td style="width:30%;"><img src="../'.$datos_estudiante['ruta_imagen'].'"></td>
            </tr>
            </table>
            </div>';
    
    /***************************************************************
     *   Cantidad de actividades en el grado del estudiante        * 
     ***************************************************************/
    $query ="SELECT COUNT(DISTINCT C.id_actividad) AS total
             FROM tbl_actividades AS C, tbl_contenido AS D, tbl_componente AS E
             WHERE C.usuario = 'ESTUDIANTE' AND C.id_contenido = D.id_contenido
             AND D.id_componente = E.id_componente AND E.id_grado='".$_GET["grado"]."'";
    if(!($q1=mysql_query($query))) error(mysql_error());
    $cant_actSist = mysql_fetch_assoc($q1);
    if($cant_actSist >0){      
        /***************************************************************************
         *   Actividades completadas por el estudiante, clasificadas por tipo      *
         ***************************************************************************/       
        $query ='SELECT E.tipo_actividad, COUNT(DISTINCT C.id_actividad) AS total
                 FROM tbl_persona_actividad AS A, tbl_actividades AS C, sist_actividad AS E
                 WHERE A.id_persona="'.$_GET['id'].'" AND A.completada ="SI"
                 AND A.id_actividad=C.id_actividad AND C.tipo_actividad=E.id_tipo
                 GROUP BY C.tipo_actividad';
        if(!($q1=mysql_query($query))) error(mysql_error());
        $cant_actEst = 0;
            while( $a =  mysql_fetch_assoc($q1)){
                $actividades[] = array("tipo" => $a["tipo_actividad"], "total"=>$a["total"]);
                $cant_actEst += $a["total"];
            }
        if($cant_actEst >0){
                /***************************************************
                 *   Consulta de las Areas de Aprendizaje          *
                 ***************************************************/
                $query='SELECT id_area,area_aprendizaje,imagen FROM tbl_areasaprendizaje WHERE id_grado="'.$_GET["grado"].'"';
                if(!($q0=mysql_query($query))) error(mysql_error());
                $enlaces = "";
                while($qa0=mysql_fetch_assoc($q0)) {
                    $enlaces.='<a href="" id="'.$qa0['id_area'].'-'.$_GET['id'].'-'.$datos_estudiante['nombre'].' '.$datos_estudiante['apellido'].'-'.$_GET['grado'].'" alt="'.$qa0['area_aprendizaje'].'" class="area">
			       <img src="'.p_get_rel_path().'/uploadImages/AA/'.$qa0['imagen'].'" class="imgarea"></a>';
                }
                $tab3 = '<div style="margin:20px;">
                          <span class="info">Para ver la actividad del estudiante por &Aacute;rea de Aprendizaje haga click en una imagen:</span><br>
                          <div class="mensaje"></div>
                          <div id="areas">'.$enlaces.'</div>
                        </div>';
                $acts = '<div style="margin:20px;">
                            <div class="block large-margin-bottom" style="max-width:400px; margin:0 auto;">
			   <div class="block-title"><h3>Cantidad de Actividades por Tipo</h3></div>
			    <ul class="events">';
                foreach ($actividades as $valor){
                    $acts .= '<li><span class="event-date">'.$valor["total"].'</span>
		    <span class="event-description"><h4>'.$valor["tipo"].'</h4></span></li>'; 
                }
                $acts .= '</ul></div></div><br>';
        }
        else{//el estudiante no ha realizado actividades
            $tab3= $tab4 = '<div style="margin:20px;"><div style="text-align:center; color:red;"><img src="../plantilla/img/standard/error.png"> El estudiante no ha realizado actividades</div></div>';
        }
        
        $porc = round(($cant_actEst/$cant_actSist["total"])*100);
        $tab2 = '<div style="margin:20px;"> <p><span class="info">Actividad del Estudiante</span>
                  <span class="info-spot">
                   <span class="icon-info-round"></span>
                     <span class="info-bubble">
                      Este porcentaje representa una comparaci&oacute;n entre el n&uacute;mero
                      de actividades que ha realizado el estudiante y la cantidad total de
                      actividades que hay en su grado.
                    </span></span>
                    </p> <br><br>
                    <p><span class="demo-progress" data-progress-options=\'{"size":false,"barClasses":["blue-gradient","glossy"],"innerMarks":25,"topMarks":25,"topLabel":"[value]%","bottomMarks":[{"value":0,"label":"Ninguno"},{"value":25,"label":"Minimo"},{"value":50,"label":"Medio"},{"value":75,"label":"Bien"},{"value":100,"label":"Excelente"}],"insetExtremes":true}\'>'.$porc.'%</span></p>
                    <br><br>
                    <p>El estudiante ha realizado <span class="tip">'.$cant_actEst.'</span> actividades de
                    un total de <span class="tip">'.$cant_actSist["total"].'</span> del grado. 
                     </p>
                </div>'.$acts;
    }
    else{//no hay actividades en el sistema
        $tab2='<div style="text-align:center; color:red;"><img src="../plantilla/img/standard/error.png"> No hay actividades para este grado registradas en el sistema, contacte al administrador</div>';
    }
}
else{//no se encuentra al estudiante
   $tab1 = $tab2 = $tab3 = $tab4 = '<div style="text-align:center; color:red;"><img src="../plantilla/img/standard/error.png"> Hubo un error al recuperar los datos del estudiante, recargue la p&aacute;gina.<br>Si el error persiste, contacte al administrador</div>';
}
p_contenido('centro','     
<div id="centro">	
<div id="areaProfesor">
    <table style="margin:0 auto;">
            <tr>
                    <td>
                            <div style="text-align:center; width:150px; height:120px; margin: 0 auto;"><a href="estudiantes_visualizar.php"><img src="../plantilla/img/menuAA/previous.png" style="top:20px;"> <br>Seleccionar otro Estudiante</a></div>
                    </td>
                    <td width="80%" align="center">
                            <h3 class="thin"><span class="info">Informaci&oacute;n del Estudiante: </span>'.$datos_estudiante['nombre'].' '.$datos_estudiante['apellido'].'</h3>
                            <span class="info">'.$datos_estudiante['grado'].'-'.$datos_estudiante['seccion'].'</span>
                    </td>
            </tr>
    </table>
    <div class="side-tabs same-height margin-bottom" style="clear:both;">
        <ul class="tabs">
           <li><a href="#sidetab-1" class="1"><img src="../plantilla/img/icons_docente/user_go.png" alt="datos estudiante"> Datos Personales</a></li>
           <li><a href="#sidetab-2" class="1"><img src="../plantilla/img/icons_docente/award_star_gold_3.png" alt="rendimiento"> Actividad del Estudiante</a></li>
           <li><a href="#sidetab-3" class="1"><img src="../plantilla/img/icons_docente/star.png" alt="rendimiento"> Actividades por &Aacute;rea de Aprendizaje</a></li>
        </ul>
        <div class="tabs-content">
            <div id="sidetab-1" class="1">'.$tab1.'</div>
            <div id="sidetab-2" class="1">'.$tab2.'</div>
            <div id="sidetab-3" class="1">'.$tab3.'</div>
    </div>
</div>
</div>
');
$ruta = p_get_rel_path()."plantilla/img/standard/loaders/loading16.gif";
p_js_agregar_texto('
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
$(document).ready(function(){
  $(".demo-progress").progress();
  $(".area").click(function(event){
      event.preventDefault();
      var data = $(this).attr("id").split(\'-\'); 
      var idA = data[0];//
      var idE = data[1];//
      var nA = $(this).attr("alt");
      var nE = data[2];//
      var idG = data[3];//
     if (idA !="" && idE!=""){
       $.blockUI({ message: "<h4 class=\"thin\" style=\"padding:20px;\"><img src=\"../plantilla/img/standard/loaders/loading16.gif\" /> Recuperando informaci&oacute;n del Estudiante, por favor espere...</h4>" });
       $.get("procesos/rendimiento_estudiante_area.php", {id_area: idA, id_estudiante: idE, nombre_est: nE, nombre_are: nA, id_grado: idG})
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
p_css_agregar_archivo("../plantilla/css/styles/agenda_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/styles/progress-slider_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/areasAprendizaje_tatu.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/estadisticasTabs_tatu.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/perfilVer_tatu.css");

p_js_agregar_archivo("plantilla/js/developr.progress-slider.js");
p_js_agregar_archivo("plantilla/js/developr.modal.js");
p_js_agregar_archivo("plantilla/js/developr.scroll.js");
p_js_agregar_archivo("plantilla/js/libs/jquery.blockUI.min.js");
p_js_agregar_archivo("plantilla/js/developr.tabs.js");

p_con_shortcuts(true);
p_con_menu(true);

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');

p_con_pizarra(true);
p_contenido('pizarra','Informaci&oacute;n de Estudiante');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Estudiantes');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();  
}
else{
    header("location: index.php");
}
?>