<?php
if (isset($_GET['idActividad']) && $_GET['idActividad']!="" && isset($_GET['idEstudiante']) && $_GET['idEstudiante']!=""){
require_once '../../config.php';
$query = "SELECT A.palabras, A.pistas, B.retroalimentacion  FROM tbl_act_crucigramas A, tbl_actividades B 
          WHERE A.id_actividad='".$_GET['idActividad']."' AND A.id_actividad=B.id_actividad";

$exe=mysql_query($query);
if(!$exe){ die(mysql_error());}
$cant = mysql_num_rows($exe);
$exe = mysql_fetch_assoc($exe); 
$c = 0;
if ($cant>0){
    $palabras = explode("#",$exe["palabras"]);
    $palJS = "";
    foreach ($palabras as $i){
        $palJS .= '"'.$i.'",';
    }
    $palJS[strlen($palJS)-1] = " ";
    
    $pistas = explode("#",$exe["pistas"]);
    $pisJs = "";
    foreach ($pistas as $i){
        $pisJS .= '"'.$i.'",';
    }
    $pisJS[strlen($pisJS)-1] = " ";
    
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crucigrama</title>
<link href="crossword.css" rel="stylesheet"/>
<link rel="stylesheet" href="../resources/css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<script type="text/javascript" src="../resources/js/jquery.js"></script>
<script type="text/javascript" src="../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="js/crossword.js"></script>
<script type="text/javascript">
<?php
    if ($exe["retroalimentacion"] != "") $exe["retroalimentacion"] = "Muy Bien!";
?>
//GLOBALS
var grid;
var cantCorrectas = 0;
var cantPistas = 1;
var pistaAnt = -1;
var dirAnt = "";
var pistaAnt_aux = -1;
var dirAnt_aux = "";

$(document).ready(function(){
    
        var progreso = new progress();
var words = [<?php echo $palJS; ?> ];
var clues = [<?php echo $pisJS; ?>];
var cw = new Crossword(words, clues);
var tries = 5; 
    grid = cw.getSquareGrid(tries);
    if(grid === null){
        var bad_words = cw.getBadWords();
        var str = [];
        for(var i = 0; i < bad_words.length; i++){
            str.push(bad_words[i].word);
        }
        return;
    }
document.getElementById("crossword").innerHTML = CrosswordUtils.toHtml(grid, false);
var legend = cw.getLegend(grid);
addLegendToPage(legend);
	
/******** Interactividad del Crucigrama - Crossword Interactivity ******/
//funcionamiento al hacer clic en las pistas - on click in the clues
$(".pista").click(function(){
var cant=0;
var index = $(this).attr("class").split(" ")[1];
var dir = $(this).attr("class").split(" ")[2];
if (index !== pistaAnt || dir !== dirAnt){
    $("#respuesta").removeAttr("disabled");
    $("#aceptar").removeAttr("disabled");
    $("#pedirPista").removeAttr("class");
    $("#pedirPista").addClass("i-"+index);
    $("#pedirPista").addClass("i-"+dir);
    $("#botonPista").show();

    $(this).css("text-decoration","underline");
    $(this).css("color","blue");

    if (pistaAnt !== -1){
            $("."+pistaAnt+"."+dirAnt).css("text-decoration","none");
            $("."+pistaAnt+"."+dirAnt).css("color","black");
            var f = parseInt($("#"+pistaAnt).attr("title").split(",")[0]);
            var c = parseInt($("#"+pistaAnt).attr("title").split(",")[1]);
            colorearPalabra(f,c, dirAnt, false);
    }
    var f = parseInt($("#"+index).attr("title").split(",")[0]);
    var c = parseInt($("#"+index).attr("title").split(",")[1]);

    cant=colorearPalabra(f,c, dir, true);

    $("#postRespuesta").html("");
    $("#correcto").hide();

    var def = "<strong><span id='indice'>" +$("."+index+"."+dir).html().split(".")[0] +
            "</span> "+ ((dir==="across")?"Horizontal":"Vertical")
            + "</strong>: " + $("."+index+"."+dir).html().split(".")[1];
     $("#definicion").html(def);

     def = "Palabra de " + cant + " letras";
     $("#caracteristicas").html(def);

     $("#respuesta").attr("maxlength",cant)
     $('#input').show();
     $('#respuesta').focus();
     $('#respuesta').val("");

    pistaAnt = index;
    dirAnt = dir;
}
});

// Funcionamiento al hacer click en el boton "Aceptar" - on click in the button "Aceptar"
$("#aceptar").click(function(){
   var respuesta = $("#respuesta").val();
   if (respuesta !== ""){
       $("#error").html("");
       var index = parseInt($("#indice>strong").html());
       var dir = $(".pista."+index).attr("class").split(" ")[2];
       var f = parseInt($("#"+index).attr("title").split(",")[0]);
       var c = parseInt($("#"+index).attr("title").split(",")[1]);
       if (comprobarPalabra(respuesta, f, c, dir)){ // la palabra es correcta - the word is correct
            deshabilitaPista(index,dir);
            colocarPalabra(respuesta, f, c, dir);
           $("#input").hide();
           $("#postRespuesta").html(respuesta);
           $("#correcto").show();
           cantCorrectas++;
           if (cantCorrectas === words.length){  
             progreso.marcarProgreso("Juego");
             $("#fin").dialog("open");
           }
       }
       else{                                     //wrong
           $("#error").html("<img src='img/cross.png'> Ups! La respuesta es incorrecta, vuelve a intentar");
       }
   }
   else{$("#error").html("Debes escribir una palabra");}
});

//Tell me the word, please
$("#pedirPista").click(function(){
 var index = $(this).attr("class").split(" ")[0].split("-")[1];
 var dir = $(this).attr("class").split(" ")[1].split("-")[1];
   if (cantPistas <=3){
       if (pistaAnt_aux !== index || dir !== dirAnt_aux){
           cantCorrectas++;
        $("#respuesta").attr("disabled","true");
        $("#aceptar").attr("disabled","true");
        var f = parseInt($("#"+index).attr("title").split(",")[0]);
        var c = parseInt($("#"+index).attr("title").split(",")[1]);
        deshabilitaPista(index, dir);
        colocarPalabra(null,f,c,dir);
        $(".pist."+cantPistas).attr("src","img/usada.png");
        cantPistas++;
        pistaAnt_aux = index;
        dirAnt_aux = dir;
       }
       if (cantCorrectas === words.length){
            progreso.marcarProgreso("Juego");
            $("#fin").dialog("open");
       }
   }
   else{
       $("#error").html("<img src='img/cross.png'> Ya no tienes m&aacute;s pistas");
       $("#pedirPista").attr("disabled","true");
   }
});

$( "#fin" ).dialog({
dialogClass: "no-close",
  height: 300,
  width: 400,
  autoOpen:false,
  open: function(){play("hover");},
  buttons: {
    "Cerrar": function(){ 
        $( this ).dialog( "close" );
        stop("hover");
        progreso.redireccion();
    }
  }
});

});

//dibuja la palabra dentro del crucigrama  -  Draw the word into the crossword
function colocarPalabra (palabra, fila, columna, direccion){
        var j =0;
       if (palabra){
            if (direccion === "across"){
                    for (i = columna; i< grid[fila].length && grid[fila][i] !== null; i++){
                        $("td[title='"+fila+", "+i+"']").html(palabra[j].toUpperCase());
                        j++;
                    }
            }
            else if (direccion === "down"){
                    for (i = fila; i< grid.length && grid[i][columna] !== null; i++){
                        $("td[title='"+i+", "+columna+"']").html(palabra[j].toUpperCase());
                        j++;
                    }
            }
       }
       else{
            if (direccion === "across"){
                    for (i = columna; i< grid[fila].length && grid[fila][i] !== null; i++){
                        $("td[title='"+fila+", "+i+"']").html(grid[fila][i].char);
                        j++;
                    }
            }
            else if (direccion === "down"){
                    for (i = fila; i< grid.length && grid[i][columna] !== null; i++){
                        $("td[title='"+i+", "+columna+"']").html(grid[i][columna].char);
                        j++;
                    }
            }
       }
}

// Comprueba si la palabra es correcta -  checks if the word is correct or not
function comprobarPalabra(palabra, fila, columna, direccion){
    var j=0;
    if (direccion === "across"){
		for (i = columna; i< grid[fila].length && grid[fila][i] !== null; i++){
                   try{ 
                    if (grid[fila][i].char !== palabra[j].toUpperCase())
                            return false;
                   }
                   catch(error){
                     return false;
                   }
                    j++;
		}
	}
    else if (direccion === "down"){
            for (i = fila; i< grid.length && grid[i][columna] !== null; i++){
                try{
                if (grid[i][columna].char !== palabra[j].toUpperCase())
                        return false;
                }
                catch(error){
                    return false;
                }
                j++;
            }
    }
    return true;
}

//Colorea la palabra seleccionada en el crucigrama - Color the selected word in the crossword
function colorearPalabra(fila, columna, direccion, colorear){
var color = (colorear)?"2px 2px 15px green":"none";
var cantLetras = 0;
if (direccion === "across"){
    for (i = columna; i< grid[fila].length && grid[fila][i] !== null; i++){
                    $("td[title='"+fila+", "+i+"']").css("-webkit-box-shadow",color);
                    $("td[title='"+fila+", "+i+"']").css("-moz-box-shadow",color);
                    $("td[title='"+fila+", "+i+"']").css("box-shadow",color);
                    if(colorear) cantLetras++;
    }
}
else if (direccion === "down"){
    for (i = fila; i< grid.length && grid[i][columna] !== null; i++){
                    $("td[title='"+i+", "+columna+"']").css("-webkit-box-shadow",color);
                    $("td[title='"+i+", "+columna+"']").css("-moz-box-shadow",color);
                    $("td[title='"+i+", "+columna+"']").css("box-shadow",color);
                    if(colorear) cantLetras++;
    }
}
    return cantLetras;
        
}

function deshabilitaPista(index, dir){
   $("."+index+"."+dir).unbind();
   $("."+index+"."+dir).append(" <img src='img/accept.png'>");
   $("."+index+"."+dir).css("color","green");
   $("."+index+"."+dir).css("text-decoration","none");
   $("."+index+"."+dir).attr("class","");
}

function addLegendToPage(groups){
    for(var k in groups){
        var html = [];
        for(var i = 0; i < groups[k].length; i++){
            html.push("<li class='pista "+groups[k][i]['position']+ " " + k+"'><strong>" + groups[k][i]['position'] + ".</strong> " + groups[k][i]['clue'] + "</li>");
        }
        document.getElementById(k).innerHTML = html.join("\n");
    }
}
</script>
</head>

<body> 
<audio id="hover" preload="auto"><source src="../../plantilla/sound/bien.ogg" type="audio/ogg"></audio>
Selecciona una pista y luego escribe la respuesta:<br/><br>
<p><strong>Pistas:</strong></p>
<div id="contenedorPistas">
    <table id="clues">
            <thead><tr><th>Horizontal</th><th>Vertical</th></tr></thead>
            <tbody><tr><td><ul id="across"></ul></td><td><ul id="down"></ul></td></tr></tbody>
    </table>
    <div id="input">
        <div id="pista">
            <span id="definicion"></span><br/>
            <span id="caracteristicas"></span>
            <span id="estructura"></span>
        </div>
        <br/>
                Escribe tu Respuesta: 
                <input type="text" id="respuesta" maxlength="1"/> 
                <button id="aceptar">Aceptar</button><br/>
                <span id="error" style="color:red"></span>
                <br/>
                <div id="botonPista">
                    <button id="pedirPista">Dime la palabra,<br> por favor</button><br>
                        <img src="img/disp.png" class="pist 1"><img src="img/disp.png" class="pist 2"><img src="img/disp.png" class="pist 3">
                </div>
    </div>
<div style="" id="correcto">Correcto! La respuesta es: <span id="postRespuesta"></span></div>
</div>
<div id="crossword"></div>
<div id="fin" title="Excelente! Resolviste el Crucigrama">
     <div style="text-align: center;padding-right:20px;"> <img src="img/bien.png" ></div><br>
    <?php echo ($exe["retroalimentacion"]=="")?"Muy Bien!!":($exe["retroalimentacion"]); ?>
</div>
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/marcarProgreso.js"></script>
<script type="text/javascript" src="../../plantilla/js/jsUsuarios/playSound.js"></script>
</body>
</html>

<?php 
  }
} 
?>