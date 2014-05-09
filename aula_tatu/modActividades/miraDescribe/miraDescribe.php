<?php
if (isset($_GET['idActividad']) && $_GET['idActividad']!="" && isset($_GET['idEstudiante']) && $_GET['idEstudiante']!=""){
require_once '../../config.php';
$query = "SELECT A.imagenes, A.pistas, B.retroalimentacion  FROM tbl_act_pareo A, tbl_actividades B 
          WHERE A.id_actividad='".$_GET['idActividad']."' AND A.id_actividad=B.id_actividad";
$exe=mysql_query($query);
if(!$exe){ die(mysql_error());}
$cant = mysql_num_rows($exe);
$exe = mysql_fetch_assoc($exe); 
if($cant>0){
    $pistas = explode("#",$exe["pistas"]);
    $imagenes = explode("#",$exe["imagenes"]);
    $orden = array();
    $cant = count($pistas);
    for ($i = 0; $i<$cant; $i++){
        $orden[] = $i;
    }
    shuffle($orden);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
  <title></title>
<link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<script type="text/javascript" src="../resources/js/jquery.js"></script>
<script type="text/javascript" src="../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>
<style>
body{font-family: Arial, Helvetica, sans-serif; font-size: 14px;}
li{max-width:250px;}
.ui-widget-content:hover{cursor:move;}
/*#gallery { height: 100px; margin: 0 auto;max-width: 800px;margin-left: -50px; background-color: #ccc;webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;}*/
#gallery{
           background: url(images/fondo.png) no-repeat;
           width: 660px; height: 110px;
           padding: 10px;margin-left: -60px;
       }
#gallery li { float: left; min-width: 150px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; cursor:pointer; -webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;}
#gallery li img { width: 100%; cursor: move; }

.trash { background-color:#ffffa3; height:110px; margin: 0 auto; margin-top:5px; border: 1px solid #ff8c40; line-height: 16px; -webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;}
.imagen { border: 1px solid #ff8c40; height:150px; -webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;}
.imagen img {width: auto; height: 150px; max-width:150px; -webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;}
.trash .gallery { margin: 0 auto; width: 150px; }

.ui-draggable-draggaing{width: 200px !important;}

#contenedorActividad{margin:0 auto; width:95%;}
#imagenes{width:95%;max-width:800px; margin:0 auto; text-align:center; margin-left:10%;}
.pistas{ margin: 0 auto; max-width:600px; text-align:center; clear:both; width:70%;}
.cont{float: left; width: 25%;  height: 300px; margin: 0 auto; margin-right:10px; text-align:center; max-width: 350px;}
.cont .trash .gallery li {width:150px; margin-top: 5px;}
.boton{margin: 0 auto; text-align:center; width:150px; clear:both;}
.gallery li{-webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;}
</style>
<script>
$.fx.speeds._default = 1000;	
function rep(){
        audios = document.getElementById('check');
        audios.play();
}
var progreso = new progress();
$(document).ready(function() {
<?php  if ($exe["retroalimentacion"] != ""){ ?>
        var retroalimentacion = "<?php echo $exe["retroalimentacion"]; ?>";
<?php }else{ ?>
        var retroalimentacion = "Excelente! Completaste correctamente la actividad";
<?php } ?>

var $gallery = $( "#gallery" ), $trash1 = $( ".trash" );
$( "li", $gallery ).draggable({
  cancel: "a.ui-icon",
  revert: "invalid",
  containment: "document",
  helper: "clone",
  cursor: "move"
});

$( ".trash" ).droppable({
  accept: "#gallery > li, .gallery > li",
  drop: function( event, ui ) {
        id = $(this).attr("id");
            if ($("ul", $("#"+id)).length === 0 || $("ul li", $("#"+id)).length === 0){
                    deleteImage( ui.draggable, id);
                    rep();
            }
  }
});

$gallery.droppable({
  accept: ".trash li",
  activeClass: "custom-state-active",
  drop: function( event, ui ) {
    recycleImage( ui.draggable);
  }
});

function deleteImage( $item, id ) {
  $item.fadeOut(10,function() {
    var $list = $( "ul", $("#"+id) ).length ?
      $( "ul", $("#"+id)) :
      $( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $("#"+id));
    $item.appendTo( $list ).fadeIn(function() {
      $item
        .animate({ width: "150px" })
    });
  });
}

function recycleImage( $item ) {
  $item.fadeOut(10, function() {
    $item
      .find( "a.ui-icon-refresh" )
        .remove()
      .end()
      .appendTo( $gallery )
      .fadeIn(5);
  });
}

$( "#fin" ).dialog({
  dialogClass: "no-close",
  height: 300,
  width: 400,
  autoOpen:false,
  open: function(){$("#retroalimentacion").html(retroalimentacion)},
  buttons: {
    "Cerrar": function(){
    $( this ).dialog( "close" );
    progreso.redireccion();
    }
  }
});

$( "#error" ).dialog({
  height: 200,
  width: 400,
  autoOpen:false,
  buttons: {
    "Cerrar": function(){ 
    $( this ).dialog( "close" );
    }
  }
});

});
function verificarRespuestas(){
    correctas = 0;
    $(".trash").each(function(){
            if ($(this).find("span").attr("class") !== "undefined"){
                    if ($(this).find("span").attr("class") === $(this).attr("id"))
                            correctas = correctas + 1;
            }
    });
    if (correctas === 3){
            progreso.marcarProgreso("Juego");
            $("#fin").dialog("open");
    }
    else
            $("#error").dialog("open");

}

  </script>
</head>
<body>
<div id="fin" title="Muy bien!">
    <div style="text-align: center;padding-right:20px;"> <img src="images/bien.png" ></div><br>
    <div id="retroalimentacion"><?php echo $exe["retroalimentacion"]; ?></div>
</div>

<div id="error" title="Vuelve a intentarlo!">
    <img src="images/error.png" style="margin:5px;" > Ups! tu respuesta es incorrecta... vuelve a intentarlo!
</div>
    
<audio id="check">
  <source src="sound/check.ogg" type="audio/ogg">
</audio> 
<p style="color:#164f69; font-weight: bold;">Arrastra las pistas dentro de las imagenes que correspondan:</p> <br><br>
<div class="boton"><button onClick="verificarRespuestas();">Aceptar</button></div><br>
<!-- Obligatorio para marcar el progreso del estudiante -->
<div id="contenedorActividad">
<div id="imagenes">
<?php 
    $j =0;
    foreach ($imagenes as $i){
?>
<div class="cont">
	<div class="imagen"><img style="width:130; height: auto;" src="<?php echo "../../uploadActividades/".$i; ?>"></div>
	<div class="trash" id="<?php echo $j;?>" class="ui-widget-content ui-state-default">

        </div>
</div>
<?php
    $j++;
    }
?>
</div>
<div class="pistas">
    <p style="font-weight:bold;">Pistas</p>
<ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
  <?php 
    $j =1;
    foreach ($orden as $i){
  ?>
    <li class="ui-widget-content ui-corner-tr">
         <span class="<?php echo $i; ?>"><?php echo $pistas[$i]; ?></span>
   </li>
  <?php 
    $j++;
    }
  ?>
</ul>
 </div>
</div>


</body>
</html>
<?php
}
}
?>