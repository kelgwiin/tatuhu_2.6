<?php
require '../config.php';
require '../auth.php';
if($_SESSION['usuario']['tipo'] != 'PROFESOR') die('No autorizado');
p_set_rel_path('../');

/***************************************************
 *    grados que maneja el Docente                 *
 ***************************************************/
$i = 0;
foreach ($_SESSION["datos_educativos"] as $val){
    if (!(in_array($val["id_grado"], $aux))){
        $gradoN[$i]["nombre"] = $val["nombre_grado"];
        $gradoN[$i]["id"] = $val["id_grado"];
        $aux[] = $val["id_grado"];
        $i++;
    }
}
if (count($gradoN)>0){
/***************************************************
 *   Consulta de las Areas de Aprendizaje          *
 ***************************************************/
$query='SELECT * FROM tbl_areasaprendizaje WHERE activo="SI" AND id_grado IN ('.implode(",",$aux).')';
if(!($q0=mysql_query($query))) error(mysql_error());
$enlaces = "";
while($qa0=mysql_fetch_assoc($q0)) {
	$cont='<div style=\'width:300px; text-align: justify;\'>'.$qa0["descripcion"].'</div>';
	$enlaces.='<a style="display:none;" data-tooltip-content="'.$cont.'" data-tooltip-options=\'{"onShow":"fixTooltip"}\' href="" id="'.$qa0['id_area'].'" alt="'.$qa0['area_aprendizaje'].'" class="area with-tooltip tooltip-bottom '.$qa0["id_grado"].'"><img src="'.p_get_rel_path().'/uploadImages/AA/'.$qa0['imagen'].'" class="imgarea"></a>';
}
$opciones_grado.='';
if (count($gradoN) > 1) { //El profesor tiene mas de un grado se imprimen en un select
    foreach($gradoN as $qa1){
	    $opciones_grado.='<option value="'.$qa1['id'].'">'.$qa1['nombre'].'</option>';
    }
    p_contenido('centro','
	    <div id="centro">	
			    <span class="info">Paso 1: Seleccione el Grado:</span><br><br>
			    <select class="select" name="grado" id="grado">
			    <option value="">Seleccione un grado</option>
				    '.$opciones_grado.'
			    </select><br><br>
		    <div class="error">Por favor seleccione un grado para poder listar los contenidos</div>
		    <div id="listarAC" style="display:none;">
		    <span class="info">Paso 2: Seleccione un &Aacute;rea de Aprendizaje para ver sus componentes:</span><br>
		    <div id="areas">'.$enlaces.'</div>
		    <div id="componentes"></div>
		    </div>
	    </div>
	    
    ');
}else{
$qa1=$gradoN[0];
p_js_agregar_texto('
$(document).ready(function(){
    var gradoAux ="'.$qa1['id'].'";
})
');
p_contenido('centro',' 
    <div id="centro">	
            <div id="areaProfesor">
                    <span class="info">Contenidos para: '.$qa1['nombre'].' grado</span><br><br><br>
                    <input id="grado" name="grado" value="'.$qa1['id'].'" style="display:none;" disabled="disabled">
            <div id="listarAC">
            <span class="info">Paso 1: Seleccione un &Aacute;rea de Aprendizaje para ver sus componentes:</span><br>
                <div id="areas">'.
                        $enlaces
                .'</div>
                <div id="componentes"></div>
            </div>
            </div>
    </div>
');
}

$ruta = p_get_rel_path()."plantilla/img/standard/loaders/loading16.gif";
$js = '
$(document).ready(function() {
var gradoA;
var ant = 0;
var antG = 0;
var antGG = 0;
$(".area").click(function(event){
event.preventDefault();
var id = $(this).attr("id");
if (id != ant && id != ""){
$.blockUI({ message: "<h4 class=\"thin\" style=\"padding:20px;\"><img src=\"../plantilla/img/standard/loaders/loading16.gif\" /> Cargando componentes. Por favor espere...</h4>" });
if ($("select").length > 0){
    if ($("select option:selected").val() != "" ){
        $(".error").hide();
        var nombreA = $(this).attr("alt");
        if(id != ""){
            if (ant != 0){
                $("#"+ant+" img").css("opacity","0.5");
            }
            $("#componentes").html("<img src=\"'.$ruta.'\" alt=\"cargando\"> Cargando componentes, por favor espere.");
            $.get("procesos/componentes_area.php", { id_area: id, nombre: nombreA, grado: gradoA, paso:"3" })
                            .done(function(data) {
                              if (data != "0"){
                                    $("#componentes").html(data);
                                    $("#componentes").show();
                                    $("#"+id+" img").css("opacity","1");
                              }
                              else{
                                    $("#componentes").html("Error al obtener los componentes, intente nuevamente");
                                    $("#componentes").show();
                              }
                              $.unblockUI();
                            });
            }
        ant = id;
    }
    else{
        $(".error").show();

    }
}
else{
if ($("input#grado").val() != ""){
gradoAux = $("input#grado").val();
$(".error").hide();
var nombreA = $(this).attr("alt");
if(id != ""){
if (ant != 0){
$("#"+ant+" img").css("opacity","0.5");
}
$("#componentes").html("<img src=\"'.$ruta.'\" alt=\"cargando\"> Cargando componentes, por favor espere.");
$.get("procesos/componentes_area.php", { id_area: id, nombre: nombreA, grado: gradoAux, paso:"2" })
    .done(function(data) {
      if (data != "0"){
            $("#componentes").html(data);
            $("#componentes").show();
            $("#"+id+" img").css("opacity","1");
      }
      else{
            $("#componentes").html("Error al obtener los componentes, intente nuevamente");
            $("#componentes").show();
      }
      $.unblockUI();
    });
}
ant = id;
}
}
}
});
$("#grado").change(function(){
    var id = $(this).val();
    $("#listarAC").hide();
    $("#componentes").html("")
    $("#componentes").hide();
    if (ant != 0)
    $("#"+ant+" img").css("opacity","0.5");
    if ($(this).val() != ""){ 
        $("."+id).show();
        if (antGG !== 0 && antGG != id) $("."+antGG).hide();
        antGG=id;
            gradoA = id;
            $("#listarAC").show();
            $(".error").hide();
     }
    else{
        $(".area").hide();
        $("#listarAC").hide();
        $("#componentes").html("");
        $("#componentes").hide();
        $(".error").show();
    }
});
if ($("input#grado").length>0 && $("input#grado").val() !== ""){
    var id = $("input#grado").val();
    $("#listarAC").hide();
    $("#componentes").html("")
    $("#componentes").hide();
    if (ant != 0)
    $("#"+ant+" img").css("opacity","0.5");
    if (id){ 
        $("."+id).show();
        if (antGG !== 0 && antGG != id) $("."+antGG).hide();
        antGG=id;
            gradoA = id;
            $("#listarAC").show();
            $(".error").hide();
     }
    else{
        $(".area").hide();
        $("#listarAC").hide();
        $("#componentes").html("");
        $("#componentes").hide();
        $(".error").show();
    }
}

});';

p_js_agregar_texto($js);
p_js_agregar_texto('
function fixTooltip(tt) {
  $("#tooltips .message").css("white-space","normal");
}
');
}
else{
p_contenido('centro',' 
        <div id="centro">	
                <div id="areaProfesor">
                    <div style="color:red;"><img src="../images/icons/error.png"> No tiene secciones asignadas, o sus secciones est&aacute;n inactivas. Para m&aacute;s informaci&oacute;n, consulte al administrador del sistema</div>
                </div>
        </div>
');
}
p_css_agregar_archivo("../plantilla/css/styles/form_59edcbff.css");
p_css_agregar_archivo("../plantilla/css/stylesTatu/areasAprendizaje_tatu.css");

p_js_agregar_archivo("plantilla/js/developr.input.js");
p_js_agregar_archivo("plantilla/js/developr.tooltip.js");
p_js_agregar_archivo("plantilla/js/libs/jquery.blockUI.min.js");
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

?>
