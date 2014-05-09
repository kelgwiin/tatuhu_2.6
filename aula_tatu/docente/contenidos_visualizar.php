<?php
require '../config.php';
require '../auth.php';
if($_SESSION['usuario']['tipo'] != 'PROFESOR') die('No autorizado');
p_set_rel_path('../');
if (isset($_GET['id']) && $_GET['id']!= "" && isset($_GET['grado']) && $_GET['grado']!= ""){
  
$query = "SELECT A.nombre_actividad, C.tipo, A.usuario, C.id_material,A.id_contenido,
	    A.orden, A.tipo_actividad, A.id_actividad
	 FROM tbl_actividades AS A, sist_actividad AS B, tbl_act_material AS C,tbl_contenido AS D
	 WHERE C.id_actividad=A.id_actividad AND A.id_contenido=D.id_contenido
         AND D.id_componente='".$_GET['id']."' AND A.tipo_actividad=B.id_tipo
	 AND B.tipo_pedagogia='Lectura' ORDER BY (D.orden)";
if(!($q0=mysql_query($query))) error(mysql_error());
$contenido = "";
if (mysql_num_rows($q0)>0){
while ($i = mysql_fetch_assoc($q0)){
   $material["id"][] = $i["id_material"];
   $material["idA"][] = $i["id_actividad"];
   $material["nombre"][] = $i["nombre_actividad"];
   $material["tipo"][] = $i["tipo"];
   $material["audiencia"][] = $i["usuario"]=="ESTUDIANTE"?"Estudiante":"Docente";
   $material["contenido"][] = $i["id_contenido"];
   $material["orden"][] = $i["orden"];
}

//datos del componente
$query="SELECT A.id_area, A.componente, A.imagen, B.area_aprendizaje FROM tbl_componente 
    AS A, tbl_areasaprendizaje AS B WHERE A.id_componente='".$_GET['id']."' AND A.id_area = B.id_area";
if(!($q0=mysql_query($query))) error(mysql_error());
$componente=mysql_fetch_assoc($q0);

//Contenidos del Componente
$query = "SELECT contenido, id_contenido, orden FROM tbl_contenido 
    WHERE id_componente='".$_GET['id']."' ORDER BY(orden)";
if(!($q0=mysql_query($query))) error(mysql_error());
$tabs = "";
$sides = "";
$j = 1;

while ($i = mysql_fetch_assoc($q0)){
    if ($j == 1){
	$tabs .= '<li><a href="#sidetab-1" class="'.$i["id_contenido"].' contenido">'.$i["contenido"].'</a></li>';
	$id1= $i["id_contenido"];
    }
    else{
	$tabs .= '<li><a href="#sidetab-'.$j.'" class="'.$i["id_contenido"].' contenido">'.$i["contenido"].'</a></li>';
    }
    
    if (in_array( $i["id_contenido"],$material["contenido"])){
      $taC = '<table class="table responsive-table">
	       <thead>
		<tr>
		  <th scope="col">Nombre</th>
		  <th scope="col" width="15%" class="align-center hide-on-mobile">Dirigido a</th>
		  <th scope="col" width="15%" class="align-center hide-on-mobile-portrait">Tipo</th>
		</tr>
	       </thead><tbody>';
      $cantM = count($material["contenido"]);
      for ($k = 0; $k<$cantM; $k++){
	 if ($material["contenido"][$k] == $i["id_contenido"]){
	    $taC .= '<tr><td><a href="material_visualizar.php?id='.$material["id"][$k].'&idA='.$material["idA"][$k].'&nombre='.$material["nombre"][$k].'&componente='.$_GET['id'].'&grado='.$_GET['grado'].'">'.$material["nombre"][$k].'</a></td>
			<td>'.$material["audiencia"][$k].'</td>
			<td>'.$material["tipo"][$k].'</td></tr>';
	 }
      }
      $taC .= '</tbody></table>';
      $sides.='<div id="sidetab-'.$j.'" class="side'.$i["id_contenido"].'"><div style="margin: 20px;">'.$taC.'</div></div>';
    }
    else{
      $sides.='<div id="sidetab-'.$j.'" class="side'.$i["id_contenido"].'"><div style="margin: 20px;">
      <div style="color:red;"><img src="../plantilla/img/standard/error.png"> El contenido seleccionado no tiene materiales de lectura</div></div></div>';
    }
    
    
    $j++;
}

$contenido = '<div id="centro">
	<div id="areaProfesor">
	<table style="margin:0 auto;"><tr>
	    <td>
	    <div style="text-align:center; width:100%; height:120px; margin: 0 auto; margin-top:25px;">
		<a href="areas_visualizar.php">
		<img src="../plantilla/img/menuAA/previous.png" style="top:20px;"> 
		<br>Seleccionar otra &Aacute;rea</a>
		</div>
	    </td>
       	    <td width="80%" align="center">
		<div>
	    <img class="imgarea" src="'.p_get_rel_path().'/uploadImages/COMP/'.$componente['imagen'].'"</div><br>
		<span class="info">&Aacute;rea: </span>'.$componente['area_aprendizaje'].'<br>
		<span class="info">Grado: </span>'.$_GET['grado'].'<br>
	    </td>
	</tr></table>
	<span class="info">Contenidos:</span><br><br>
	<div class="side-tabs same-height margin-bottom" style="clear:both;">
	    <ul class="tabs">
		'.$tabs.' 
	    </ul>
	    <div class="tabs-content">
		'.$sides.' 
	    </div>
	</div>
	</div>
</div>';
}
else{
    $contenido .= '
        <div id="centro">
        <div id="areaProfesor">
            <table style="margin:0 auto;"><tr>
	    <td>
	    <div style="text-align:center; width:100%; height:120px; margin: 0 auto; margin-top:25px;">
		<a href="areas_visualizar.php">
		<img src="../plantilla/img/menuAA/previous.png" style="top:20px;"> 
		<br>Seleccionar otra &Aacute;rea</a>
		</div>
	    </td>
       	    <td width="80%" align="center">
                <br><br>
		<div style="color:red;"><img src="../plantilla/img/standard/error.png"> El componente seleccionado no tiene materiales de lectura</div>
	    </td>
	</tr></table>
        </div></div>';
}
p_contenido('centro',$contenido);

p_css_agregar_archivo("../plantilla/css/styles/table_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/areasAprendizajeInfo_tatu.css");

p_js_agregar_archivo("plantilla/js/developr.tabs.js");
p_con_shortcuts(true);
p_con_menu(true);

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');

p_con_pizarra(true);
p_contenido('pizarra','Contenidos por &Aacute;rea de Aprendizaje');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Contenidos');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();
}
?>