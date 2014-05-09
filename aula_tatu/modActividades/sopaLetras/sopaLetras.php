<?php
if (isset($_GET['idActividad']) && $_GET['idActividad']!="" && isset($_GET['idEstudiante']) && $_GET['idEstudiante']!=""){
require_once '../../config.php';
$query = "SELECT A.palabras, B.retroalimentacion  FROM tbl_act_sopadeletras A, tbl_actividades B 
          WHERE A.id_actividad='".$_GET['idActividad']."' AND A.id_actividad=B.id_actividad";

$exe=mysql_query($query);
if(!$exe){ die(mysql_error());}
$cant = mysql_num_rows($exe);
$c = 0;
?>
<!DOCTYPE html>
<html>
<head>	
<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
<link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<script type="text/javascript" src="../resources/js/jquery.js"></script>
<script type="text/javascript" src="../resources/js/jquery-ui.js"></script>
<style>
    #sopaBody{color:#000;font-family: Arial, Helvetica, sans-serif; margin: 0 auto; max-width: 800px;}
    #sopa tr td{ width: 20px; text-align:center; cursor: pointer; color:#000 !important;-moz-border-radius:15px;-webkit-border-radius: 15px;border:hidden;}
    #sopa tr td:hover{-moz-border-radius:15px;-webkit-border-radius: 15px;background-color: rgb(77, 175, 0);}
    #mensajessopa{ padding-top: 10px;}
    table#sopa { border: 1px solid #5882FA;-moz-border-radius:15px;-webkit-border-radius: 15px;}
    #columna1{float:left; padding: 20px 10px;}
    #columna2{ padding: 15px 10px;}
    #contenedorSopa{padding-left:0px;padding-bottom: 5px;overflow: hidden;}
    #pista{margin-left:15px;}    
</style>
</head>
<body id="sopaBody">
    <div id="fin" title="Muy bien!">
        <div style="text-align: center;padding-right:20px;"> <img src="images/bien.png" ></div><br>
        <div id="retroalimentacion"><?php echo $i["retroalimentacion"]; ?></div>
    </div>
    <audio id="hover" preload="auto"><source src="../../plantilla/sound/bien.ogg" type="audio/ogg"></audio>
	<h3 style="text-align:center; font-size:16px;">Encuentra las palabras escondidas en la sopa de letras. Haz clic sobre cada una de las letras hasta conformar la palabra. Puedes usar las pistas.</h3 ><br><br>
	<div style="margin:0 auto;">
            <div id="columna1"><div id="contenedorSopa"></div></div>
            <div id="columna2">
                <strong>Encuentra las siguientes palabras en la sopa:</strong><br>
            <div id="contenedorPistas" style=""></div>
            <br>
            <button id="pista">Dame una pista,<br>por favor</button>
                <div><img src="images/disp.png" id="pista1"><img src="images/disp.png" id="pista2"><img src="images/disp.png" id="pista3"></div>
                <div id="mensajessopa"></div><br>
            </div>  
	</div>
</body>
<script>
    <?php
            $i = mysql_fetch_assoc($exe); 
            //print_r($i);
            if ($i["retroalimentacion"]=="") $i["retroalimentacion"] = "¡Muchas Felicitaciones!";
            $palabras = explode(",", $i['palabras']);
            $cantpal = count($palabras);
                    echo "var opciones =new Array(";
                    for ($j = 0; $j<$cantpal; $j++){
                            echo '"'.$palabras[$j].'"';
                            if ($j<$cantpal-1)
                                    echo ",";
                    }
                    echo ");";
    ?>
   // var index = Math.floor(Math.random() * (opciones.length));
    var palabras = opciones;
    var retroalimentacion = "<?php echo $i["retroalimentacion"]; ?>";
</script>
<!-- Obligatorio para marcar el progreso del estudiante -->
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>

<script type="text/javascript" src="js/sopadeletras.js"></script>
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/playSound.js"></script>

</html>
<?php } ?>