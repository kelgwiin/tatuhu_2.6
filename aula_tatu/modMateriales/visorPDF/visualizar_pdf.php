<?php
require_once '../../funcMods/utils.php';
require '../../config.php';
$query="";
//Datos que se pasan por GET segun usuario
if (isset($_GET["idLibro"]) && $_GET["idLibro"]!=""){
    if($_SESSION["usuario"]["tipo"] == "PROFESOR"){
        $query= "SELECT A.ruta, A.tipo
	FROM tbl_act_material AS A
	WHERE A.id_material ='".$_GET['idLibro']."'";
    }
    else if($_SESSION["usuario"]["tipo"] == "ADMINISTRADOR" ){
        $query= "SELECT A.ruta, A.tipo, A.id_material
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

if ($query!= ""){
/*$query= "SELECT A.ruta, A.tipo
	FROM tbl_act_material AS A
	WHERE A.id_material ='".$_GET['idLibro']."'";*/
if(!($q0=mysql_query($query))) error(mysql_error());
$material = mysql_fetch_assoc($q0);
 if (!valida_nombre_libro($material["ruta"])){
        die('La direcci&oacute;n del libro debe contener solo letras, n&uacute;meros, 
            underscore y gui&oacute;n (Ej. Libro-1)');
 }
 $dir = ruta_libro($material["ruta"]);
$script = '
      window.onload = function (){
	var myPDF = new PDFObject({ 
	    url: "'.$dir.'",
			pdfOpenParams: {
				navpanes: 0,
				toolbar: 0,
				statusbar: 0,
				view: "FitV"
			}
		
		}).embed("pdf");
      };
';

?>
<html>
  <head>
    <script type="text/javascript" src="js/pdfobject.js"></script>
    <style type="text/css">
        body{margin: 0; font-family: sans-serif; font-size: 12px; color:#164f69;}
    </style>
    <link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
    <script type="text/javascript" src="../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../resources/js/jquery-ui.js"></script>
    <script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>
    <script type="text/javascript">
            <?php  echo $script; ?>
    </script>
  </head> 
  <body>
    <div style="text-align:center;">
        <?php
        if($_SESSION["usuario"]["tipo"] == "ESTUDIANTE"){
        ?> 
				<h3>Despu&eacute;s de leer el libro presiona "Termin&eacute; de Leer" para ganar recompensas:</h3>
                <input type="button" value="Termin&eacute; de Leer" onClick="javascript:openDialog()">
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
        <?php
        }
        ?>
    </div>
    <div id="pdf">
        <p>No tienes instalado Adobe Reader en tu navegador.<br>
	<a href="<?php echo $dir;?>">Haz Click para descargar el PDF</a></p>
    </div>
  </body>
<?php
if($_SESSION["usuario"]["tipo"] == "ESTUDIANTE"){
?> 
<script type="text/javascript">
function openDialog(){
    $("#fin").dialog("open");
}
$(window).ready(function() {
var progreso = new progress();
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
});

</script>   
<?php
}
?>
</html>
<?php
}
?>
