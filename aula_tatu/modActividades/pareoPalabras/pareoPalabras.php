<?php
if (isset($_GET['idActividad']) && $_GET['idActividad']!="" && isset($_GET['idEstudiante']) && $_GET['idEstudiante']!=""){
require_once '../../config.php';
$query = "SELECT A.id_pareo,A.pistas,A.palabras, B.retroalimentacion  
          FROM tbl_act_pareopalabras A, tbl_actividades B 
          WHERE A.id_actividad='".$_GET['idActividad']."' AND A.id_actividad=B.id_actividad";
$exe=mysql_query($query);
if(!$exe){ die(mysql_error());}
$cant = mysql_num_rows($exe);
$exe = mysql_fetch_assoc($exe); 
if($cant>0){
    $pistas = explode("#",$exe["pistas"]);
    $palabras = explode("#",$exe["palabras"]);
    $orden = array();
    $cant = count($pistas);
    for ($i = 0; $i<$cant; $i++){
        $orden[] = $i;
    }
    $orden1 = $orden;
    shuffle($orden);
    shuffle($orden1);
?>
<!doctype html> 
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title></title>
  <link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" />
  <script src="../resources/js/jquery.js"></script>
  <script src="../resources/js/jquery-ui.js"></script>
  <script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>
  <style>
      body{font-family: Arial, Helvetica, sans-serif; font-size: 14px;}
        .trash, .origen{max-width: 200px; min-width: 200px; text-align: center; margin: 0 auto;}
        #pistas {margin: 0 auto;margin-bottom:20px;}
       #pistas tr {height: 50px;}
       #pistas td {max-width: 400px;}
       #gallery{
           background: url(images/fondo.png) no-repeat;
           width: 660px; height: 110px;
           padding: 10px;
       }
        .gallery div{border: 1px #000 solid;-webkit-border-radius: 15px;
             -moz-border-radius: 15px; float:left; margin: 2px; min-width: 150px; max-width: 150px; text-align: center;}
        .gallery div:hover{cursor: move;}
        #contenedorActividad{max-width: 700px; margin: 0 auto; }
        button{width: 150px;}
        #pistas .ui-state-default{background: #60E9D3 !important;font-weight:bold;  }
        .trash.ui-widget-content,  #gallery .ui-widget-content{
            max-width: 150px !important;
            min-height: 10px;
            border: 1px solid #ff8c40;
            -webkit-border-radius: 15px;
             -moz-border-radius: 15px;
        }
         #gallery .ui-widget-content:hover, .gallery div:hover{background:#d2cc9d;}
        .trash.ui-widget-content{
            max-width: 200px !important;
            min-height: 10px;
            border: 1px solid #ff8c40;
            -webkit-border-radius: 15px;
             -moz-border-radius: 15px;
        }
        
  </style>
  <script>    
var progreso = new progress();
$(document).ready(function() {
// there's the gallery and the trash
var $gallery = $( "#gallery" ),
 $trash1  = $( ".trash" );

// let the gallery items be draggable
$("#gallery div").draggable({
  cancel: "a.ui-icon", // clicking an icon won't initiate dragging
  revert: "invalid", // when not dropped, the item will revert back to its initial position
  containment: "document",
  helper: "clone",
  cursor: "move"
});

    // let the trash be droppable, accepting the gallery items
$( ".trash" ).droppable({
  accept: "#gallery div, .trash .gallery div",
  drop: function( event, ui ) {
        id = $(this).attr("id");
        if ($(this).children().length === 0 || $(this).children("span").children().length === 0){
                if($(this).children("span").length > 0){
                    $(this).children("span").remove();
                }
                deleteImage( ui.draggable, id);
        }
            
  }
});
 
    // let the gallery be droppable as well, accepting items from the trash
    $("#gallery").droppable({
      accept: ".gallery div",
      activeClass: "custom-state-active",
      drop: function( event, ui ) {
        recycleImage( ui.draggable);
      }
    });
 
    // image deletion function
    function deleteImage( $item, id ) {
      $item.fadeOut(10,function() {
        var $list = 
          $( "<span class='gallery ui-helper-reset'/>" ).appendTo($("#"+id));
        $item.appendTo( $list ).fadeIn(function() {
          $item
            .animate({ width: "150px" })
        });
      });
    }
 
    // image recycle function
    function recycleImage( $item ) {
      $item.fadeOut(10, function() {
        $item
          .find( "a.ui-icon-refresh" )
            .remove()
          .end()
          .appendTo("#gallery")
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
		if ($(this).find("span div").length>0){
			if ($(this).find("span div").attr("class").indexOf($(this).attr("id")) !== -1 )
				correctas = correctas + 1;
		}
	});
	if (correctas === <?php echo $cant; ?>){
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

<div id="contenedorActividad"> 
    <h3 style="color: #164f69;">Arrastra las respuestas dentro de los recuadros que correspondan</h3><br>
    <table id="pistas">
        <?php
            foreach($orden1 as $p){
        ?>
        <tr><td><?php echo $pistas[$p]; ?></td><td class="trash ui-widget-content ui-state-default" id="<?php echo ($p+1); ?>">Arrastra la respuesta aqu&iacute;</td></tr>
        <?php
            }
        ?>
    </table>
    <h3 style="text-align:center; color: #164f69; ">Respuestas:</h3>
    <div id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
         <?php
            foreach($orden as $p){
        ?>
            <div class="ui-widget-content ui-corner-tr <?php echo ($p+1); ?>"><?php echo $palabras[$p]; ?></div>
        <?php
            }
        ?>
    </div>
    <div style="margin: 0 auto; max-width: 300px; text-align: center;"><button onClick="verificarRespuestas();">Verificar mis respuestas</button></div>
</div>

</body>
</html>
<?php
}
}
?>