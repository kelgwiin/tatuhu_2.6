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
if($query!=""){
if(!($q0=mysql_query($query))) error(mysql_error());
$material = mysql_fetch_assoc($q0);
if (!valida_nombre_libro($material["ruta"]) && !valida_extension_video($material["ruta"])){
    die('La direcci&oacute;n del video debe contener solo letras, n&uacute;meros, 
        underscore y gui&oacute;n (Ej. Libro-1)');
}
$dir = ruta_libro($material["ruta"]);
$ext = extension_video($material["ruta"]);
$ext = ($ext=="ogv")?"ogg":$ext;
?>

<!DOCTYPE html>
<html>
<head>
 <title></title>
<link href="video-js.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<script src="video.js"></script>
<script type="text/javascript" src="../resources/js/jquery.js"></script>
<script type="text/javascript" src="../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>
<style>
    body{color:#000;font-family: Arial, Helvetica, sans-serif; margin: 0 auto; max-width: 800px;}
</style>
  <!-- Unless using the CDN hosted version, update the URL to the Flash SWF -->
<script>
var progreso = new progress();
$(document).ready(function(){
    var videoPlayer = _V_("example_video_1", {}, function(){
      this.on("ended", function(){
<?php
    if ($_SESSION["usuario"]["tipo"] == "ESTUDIANTE"){
?>
        $("#fin").dialog("open");
<?php
    }
?>
      });
    });
   
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
            $("#info").show();
          $( this ).dialog( "close" );
          }
        }
    });
 });
 
 function openDialog(){
     $("#fin").dialog("open");
 }
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

    <div style="margin: 0 auto; max-width: 700px;text-align: center">
    <?php
        if($_SESSION["usuario"]["tipo"] == "ESTUDIANTE"){
        ?> 
               <div style="margin-left: -100px; font-weight: bold;" id="info">
                   Para pasar a la siguiente actividad o contenido haz click en el bot&oacute;n:
               </div><br>
                <input type="button" value="Termin&eacute; de ver el video" onClick="javascript:openDialog()" style="margin-left: -100px;">
                <br><br>
        <?php
        }
     ?>
           <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="600" height="300"
              data-setup="{}">
            <source src="<?php echo $dir; ?>" type='video/<?php echo $ext; ?>' />
          </video> 
    </div>
</body>
</html>
<?php
}
?>