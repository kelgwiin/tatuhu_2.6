<?php

require_once '../../funcMods/utils.php';
require '../../config.php';
$query = "";
if ($_SESSION["usuario"]["tipo"] == "ESTUDIANTE" && isset($_GET["idActividad"]) && $_GET["idActividad"]!=""
        && isset($_GET["idEstudiante"]) && $_GET["idEstudiante"]!=""){
  $query= "SELECT A.ruta, A.tipo, A.id_material
	FROM tbl_act_material AS A
	WHERE A.id_actividad ='".$_GET['idActividad']."'";
}
else if($_SESSION["usuario"]["tipo"] != "ESTUDIANTE"){
    if ($_SESSION["usuario"]["tipo"] == "ADMINISTRADOR"){
        $query= "SELECT A.ruta, A.tipo
	FROM tbl_act_material AS A
	WHERE A.id_actividad ='".$_GET['idLibro']."'";
    }
    else{
        $query= "SELECT A.ruta, A.tipo
	FROM tbl_act_material AS A
	WHERE A.id_material ='".$_GET['idLibro']."'";
    }
}
if($query!= ""){
if(!($q0=mysql_query($query))) error(mysql_error());
$material = mysql_fetch_assoc($q0);
$dir = video_ID($material["ruta"]);

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<script type="text/javascript" src="../resources/js/jquery.js"></script>
<script type="text/javascript" src="../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>
<style>
    body{color:#000;font-family: Arial, Helvetica, sans-serif; margin: 0 auto; max-width: 800px;}
</style>
    <script>
var progreso = new progress();
function openDialog(){
     $("#fin").dialog("open");
 }
$(document).ready(function(){
 $( "#fin" ).dialog({
  dialogClass: "no-close",
  height: 310,
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
 });
    </script>
</head>
<body>
        <div id="fin" title="Muy bien!">
        <div style="text-align: center;padding-right:20px;"> <img src="bien.png" ></div><br>
        <div id="retroalimentacion">&iquest;Terminaste de ver el video?<br> 
         <?php
            if ($_GET["ultima"] == "0"){
         ?>
            &iexcl;Pasemos a la siguiente Actividad!
         <?php
            }
         ?>
        </div>
    </div>
    <div style="margin: 0 auto; max-width: 700px;  text-align: center;">
    <?php
        if($_SESSION["usuario"]["tipo"] == "ESTUDIANTE"){
        ?> 
               <div style="font-weight: bold;">
                   Para pasar a la siguiente actividad o contenido haz clic en el bot&oacute;n:
               </div><br>
                <input type="button" value="Termin&eacute; de ver el video" onClick="javascript:openDialog()" >
                <br><br>
        <?php
        
        }
     ?>
      <iframe class="youtube-player" type="text/html" width="640" height="385" src="http://www.youtube.com/embed/<?php echo $dir;?>" frameborder="0">
       </iframe>
    </div>
</body>
</html>
<?php
}
?>