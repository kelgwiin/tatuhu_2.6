<?php
require_once '../../funcMods/utils.php';
require '../../config.php';
$query = "";
//Datos que se pasan por GET segun usuario
if (isset($_GET["idLibro"]) && $_GET["idLibro"]!=""){
    if ($_SESSION["usuario"]["tipo"] == "PROFESOR"){
        $query= "SELECT A.ruta, A.tipo
	FROM tbl_act_material AS A
	WHERE A.id_material ='".$_GET['idLibro']."'";
    }
    else if ($_SESSION["usuario"]["tipo"] == "ADMINISTRADOR"){
        $query= "SELECT A.ruta, A.tipo
	FROM tbl_act_material AS A
	WHERE A.id_actividad ='".$_GET['idLibro']."'";
    }
}
else if ($_SESSION["usuario"]["tipo"] == "ESTUDIANTE" && isset($_GET["idActividad"]) && $_GET["idActividad"]!=""
        && isset($_GET["idEstudiante"]) && $_GET["idEstudiante"]!=""){
  $query= "SELECT A.ruta, A.tipo, A.id_material
	FROM tbl_act_material AS A
	WHERE A.id_actividad ='".$_GET['idActividad']."'";
}

if ($query != ""){
if(!($q0=mysql_query($query))) error(mysql_error());
$material = mysql_fetch_assoc($q0);
    if (!valida_nombre_libro($material["ruta"])){
        die('La direcci&oacute;n del libro debe contener solo letras, n&uacute;meros, 
            underscore y gui&oacute;n (Ej. Libro-1)');
    }
    $dir = directorio_libro($material["ruta"]);
    if( !$dir ) die('No se pudo leer el directorio "'.$material["ruta"].'"');
    $pages = paginas_libro($dir,$material["ruta"]);
    if($pages != false){
?>
<html>
<head>	
<link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<script type="text/javascript" src="../resources/js/jquery.js"></script>
<script type="text/javascript" src="../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/playSound.js"></script>
<style type="text/css">
        body{margin: 0; font-family: sans-serif; font-size: 12px; color:#164f69;}
        #libro{background-color:#fff;max-width: 700px;margin: 0 auto;max-height:500px;}
        #libro div img{max-height: 500px;width: auto;}
        #libro .hard{-webkit-box-shadow:inset 0 0 5px #666;-moz-box-shadow:inset 0 0 5px #666;-o-box-shadow:inset 0 0 5px #666;
            -ms-box-shadow:inset 0 0 5px #666;
            box-shadow:inset 0 0 5px #666;}
        .turn-page{max-height:500px;}
</style>

</head>
<body>
    <div style="text-align:center;">
        <h3>Pasa las p&aacute;ginas del Libro haciendo click en las esquinas:</h3>
        <?php
        if($_SESSION["usuario"]["tipo"] == "ESTUDIANTE"){
        ?> 
                <input type="button" value="Termin&eacute; de Leer" onClick="javascript:openDialog()">
        <?php
        }
        ?>
    </div>
        <audio id="hover" preload="auto"><source src="page_turn.ogg" type="audio/ogg"></audio>
    <br>
	<div id="libro">
	    <?php
	    $j =0;
	    foreach($pages as $p) {
		    echo '<div><img src="'.$p.'"></div>';
                    $j++;
	    }
	    ?>
	</div>
    <div id="fin" title="Muy bien!">
        <div style="text-align: center;padding-right:20px;"> <img src="Cachicamo2.png" ></div><br>
        <div id="retroalimentacion">&iquest;Finalizaste tu libro?<br> 
        <?php
            if ($_GET["ultima"] == "0"){
         ?>
            &iexcl;Pasemos a la siguiente Actividad!
         <?php
            }
         ?>
        </div>
    </div>
	<script type="text/javascript" src="js/turn.js/turn.min.js"></script>
<script type="text/javascript">
function openDialog(){
    $("#fin").dialog("open");
}
$(window).ready(function() {
var progreso = new progress();

$('#libro').turn({
    width:680,
    display: 'double',
    acceleration: true,
    gradients: !$.isTouch,
    elevation:50,
    when: {
     turned: function(e, page) {
       if ($("#libro").turn("page") != '1'){
            audios = document.getElementById("hover");
            audios.play();
       }
<?php
        if($_SESSION["usuario"]["tipo"] == "ESTUDIANTE"){
            echo 'if ($("#libro").turn("page") == '.($j-1).'){ 
                setInterval(openDialog,60000);
            }';
        }
?>
       },
       turning: stop("hover")
    }
});
$( "#fin" ).dialog({
  dialogClass: "no-close",
  height: 300,
  width: 400,
    autoOpen:false,
    buttons: {
      "Si": function(){ 
        $( this ).dialog( "close" );
        progreso.marcarProgreso("Lectura");
        progreso.redireccion();
      },
      "No": function(){ 
      $( this ).dialog( "close" );
      }
    }
  });
  $(window).bind('keydown', function(e){
        if (e.keyCode==37)
                $('#libro').turn('previous');
        else if (e.keyCode==39)
                $('#libro').turn('next');

});
});

</script>      
</body>
</html>
<?php
    }
}
?>