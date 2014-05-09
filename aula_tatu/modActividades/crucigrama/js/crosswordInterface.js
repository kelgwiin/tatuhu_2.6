/*
Obtenido en: https://github.com/satchamo/Crossword-Generator
modificado para el proyecto PEI #2012000190
Valencia, Venezuela
*/
//GLOBALS
var grid;
var cantCorrectas = 0;
var cantPistas = 1;
var pistaAnt = -1;
var dirAnt = "";
var pistaAnt_aux = -1;
var dirAnt_aux = "";

$(document).ready(function(){
    var words = ["CASA", "CARRO", "AVENIDA", "CONTAMINACION", "PLAYAS"];
    var clues = ["Lugar donde se puede vivir", "Vehiculo", "Calle principal", "Accion de contaminar", "Lugar donde uno se puede bañar"];
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

//Transforma a mayusculas la palabra del input - Converts to uppercase the words in the input
$("#respuesta").keyup(function() {
               $(this).val($(this).val().toUpperCase());
});

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
           if (cantCorrectas == words.length){
            $("#fin").dialog("open");
           }
       }
       else{                                     //wrong
           $("#error").html("<img src='img/cross.png'> Ups! La respuesta es incorrecta, vuelve a intentar");
       }
   }
   else{
       $("#error").html("Debes escribir una palabra");
   }

});

//Tell me the word, please
$("#pedirPista").click(function(){
 var index = $(this).attr("class").split(" ")[0].split("-")[1];
 var dir = $(this).attr("class").split(" ")[1].split("-")[1];
   if (cantPistas <=3){
       if (pistaAnt_aux !== index || dir !== dirAnt_aux){
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
        cantCorrectas++;
       }
   }
   else{
       $("#error").html("<img src='img/cross.png'> Ya no tienes m&aacute;s pistas");
       $("#pedirPista").attr("disabled","true");
   }
});

$( "#fin" ).dialog({
  height: 300,
  width: 400,
  autoOpen:false,
  open: function(){/*play("hover");*/ $("#retroalimentacion").html(retroalimentacion)},
  buttons: {
    "Cerrar": function(){ 
    $( this ).dialog( "close" );
   // stop("hover");
    top.location.reload();
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