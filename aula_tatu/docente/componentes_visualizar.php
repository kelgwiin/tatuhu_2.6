<?php
require '../config.php';
require '../auth.php';
if($_SESSION['usuario']['tipo'] != 'PROFESOR') die('No autorizado');
p_set_rel_path('../');

//Consulta de las areas de aprendizaje en la BD
if (isset($_GET['area']) && $_GET['area']!='')
{
$query='SELECT id_componente,componente, descripcion, imagen FROM tbl_componente WHERE id_area="'.$_GET['area'].'"';
if(!($q0=mysql_query($query))) error(mysql_error());
$enlaces = "";
while($qa0=mysql_fetch_assoc($q0)) {
    $enlaces.='<a href="contenidos_visualizar?area='.$_GET['area'].'&componente='.$qa0['id_componente'].'" id="'.$qa0['id_componente'].'" alt="'.$qa0['componente'].'" class="area"><img src="'.p_get_rel_path().'/images/'.$qa0['imagen'].'" class="imgarea"></a>';
}

p_contenido('centro','
<div id="centro">
	<div id="areaProfesor">
	<span class="info">Selecciona un  para ver sus componentes:</span><br><br>
	<div id="areas">'.
		$enlaces
	.'</div>
	<div id="componentes" style="display:none"></div>
	</div>
</div>
');

p_css_agregar_texto('
	#centro{
		padding:20px;
	}
	#areaProfesor{ width: 100%; margin: 0 auto; text-align:center; }
	.imgarea{width:150px; height:150px; margin:10px; opacity: 0.8;}
	.imgarea:hover{opacity: 1;}
	.info{font-weight:bold;}
	
');

p_js_agregar_texto('
  /*  $(".area").click(function(e){
      e.preventDefault();
      id = $(this).attr("id");
      if(id != ""){
	$.get("procesos/componentes_area.php", { id_area: id})
		.done(function(data) {
	  if (data != "0"){
	    $("#componentes").html(data);
	    $(".info").html("Ahora selecciona un componente para ver los contenidos y actividades:");
	    $("#areas").hide();
	    $("#componentes").show("slow");
	  }
	  else{
	    $(".info").html("El &aacute;rea seleccionada no tiene componentes");
	    $("#areas").hide();
	  }
	
	});
      }
    });*/
');

p_con_shortcuts(true);
p_con_menu(true);

p_contenido('titulo_1','Aula Virtual TATU HU');
p_contenido('titulo_grande_1','Bienvenido al Aula Tatu H&uacute;');

$meses=array(1=>'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago','Sep','Oct','Nov','Dic');
p_contenido('titulo_grande_2',$meses[(date('m')+0)].' <strong>'.date('d').'</strong>');
p_con_pizarra(true);
p_contenido('pizarra','Pizarra de Contenidos');
p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].', '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_agregar('Area de Aprendizaje','../','shortcut-agenda');
p_shortcuts_set_activo('Inicio');


p_set_menu_archivo('menu_tatu.php');

// Iconos de acceso (barra derecha)
p_bacceso_agregar_icono(1,'Bandeja de Entrada','icon-inbox');
p_bacceso_agregar_icono(4,'Salir','<img src="'.p_get_rel_path().'/images/salir.png" width="25" style="position: relative; top: 5px;"/>',p_get_rel_path().'logout.php');

p_dibujar();        
}
else{
}