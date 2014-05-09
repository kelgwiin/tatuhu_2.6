<?php
require '../../config.php';

if ($_SESSION['usuario']['tipo'] == 'ADMINISTRADOR'){
    $query="";
    if (isset($_GET['idLibro']) && $_GET['idLibro']!=""){
        $query = "SELECT A.terminos,A.significado,A.imagenes,B.retroalimentacion
         FROM tbl_act_diccionario A, tbl_actividades B 
         WHERE A.id_actividad='".$_GET['idLibro']."' ORDER BY A.terminos";
    }
}
else{ 
    if(isset($_GET['idActividad']) && $_GET['idActividad']!="" && isset($_GET['idEstudiante']) && $_GET['idEstudiante']!=""){

    require_once '../../config.php';
        $query = "SELECT A.id_diccionario,A.terminos,A.significado,A.imagenes,B.retroalimentacion
         FROM tbl_act_diccionario A, tbl_actividades B 
         WHERE A.id_actividad='".$_GET['idActividad']."' AND A.id_actividad=B.id_actividad ORDER BY A.terminos";
    }
}
if ($query != ""){
$exe=mysql_query($query);

if(!$exe){ die(mysql_error());}

$cant = mysql_num_rows($exe);
$exe = mysql_fetch_assoc($exe); 
$c = 0;
if ($cant>0){
    $palabras = explode("#",$exe["terminos"]);
    $significados = explode("#",$exe["significado"]);
    $imagenes = explode("#",$exe["imagenes"]);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Glosario Interactivo</title>
<link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<script type="text/javascript" src="../resources/js/jquery.js"></script>
<script type="text/javascript" src="../resources/js/jquery-ui.js"></script>
    <style type="text/css" media="screen">
        body{font-family: Arial, Helvetica, sans-serif; font-size: 14px;}
        ul.palabras {display:block; width:100%; padding:0; margin:0; list-style-type:none;}
        ul.palabras li {display:block; margin:10px; float: left; position:relative; overflow:hidden; cursor:default; font-size:0.9em; line-height:1.1em;}
        ul.palabras li a{color:#164f69}
        img {border:0px;}
       img:hover{opacity: 0.6;}
    </style>
</head>

<body> 
<audio id="hover" preload="auto"><source src="sound/clic.ogg" type="audio/ogg"></audio>
<div style="margin: 0 auto; max-width: 550px; text-align: center;">
    <h3 >Consulta el glosario interactivo de t&eacute;rminos. Haz clic sobre las im&aacute;genes para aprender los significados de las palabras.</h3>
<?php  if($_SESSION['usuario']['tipo'] == 'ESTUDIANTE'){ ?>
    <input type="button" value="Termin&eacute; de revisar el Glosario" id="termine"><br><br>
<?php } ?>
<!-- Significados -->
<ul  class="palabras" style="max-width: 500px;">
<?php
    foreach ($palabras as $indice => $elemento){
?>
       <li>
           <a class="palabra" href="" title="<?php echo $elemento; ?>" style="margin-top:0;text-decoration:none">
               <img src="<?php echo "../../".$imagenes[$indice]; ?>"><br>
               <?php echo $elemento; ?>
           </a>
           <div class="dialogo" id="<?php echo $elemento."_dialog" ?>" title="<?php echo $elemento; ?>">
                <?php echo $significados[$indice]; ?>
           </div>
       </li>
<?php
    }
?>
</ul>
<div id="fin" title="Excelente!">
     <div style="text-align: center;padding-right:20px;"> <img src="bien.png" ></div><br>
    <?php echo ($exe["retroalimentacion"]=="")?"Muy Bien!!":($exe["retroalimentacion"]); ?>
</div>
</div>

<script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>  
<script type="text/javascript">
<?php
    if ($exe["retroalimentacion"] != "") $exe["retroalimentacion"] = "Muy Bien!";
?>
    $(document).ready(function() {
        var progreso = new progress();
        	$.fx.speeds._default = 1000;	
                    function rep(){
                            audios = document.getElementById('hover');
                            audios.play();
                    }
		$( ".dialogo" ).dialog({
			width: 500,
			autoOpen: false,			
			modal: true,
			resizable:false
		});

		$( ".palabra" ).click(function(event) {
			event.preventDefault();
			rep();
			var d = $(this).attr("title");
			$( "#"+d+"_dialog" ).dialog( "open" );
			return false;
		});
                $( "#fin" ).dialog({
                    dialogClass: "no-close",
                      height: 300,
                      width: 400,
                      autoOpen:false,
                      buttons: {
                        "Cerrar": function(){ 
                            $( this ).dialog( "close" );
                            stop("hover");
                            
                            progreso.redireccion();
                        }
                      }
                 });
                 $("#termine").click(function(){
                    progreso.marcarProgreso("Lectura");
                    $( "#fin" ).dialog("open");
                 });
	});
</script>
</body>
</html>

<?php 
  }
} 
?>