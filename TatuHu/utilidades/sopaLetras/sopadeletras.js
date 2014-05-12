/* Generador de Sopas de Letras
 * Proyecto PEI Tatu Hu
 * Realizado por: EH
 * Genera sopas de letras dada una lista de palabras
 */

//Variables Globales
var letras = new Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","&Ntilde;","O","P","Q","R","S","T","U","V","W","X","Y","Z");
var sopa;
var tam = 0;
var pistas_usadas = 0;
	$.fx.speeds._default = 1000;	
	function rep(){
		audios = document.getElementById('clic');
		audios.play();
	}

/*****************************************
 *                                       *
 *     GENERADOR DE SOPA DE LETRAS       *
 *****************************************/

function inicializar(palabras) {
    //verificamos el tamao de la palabra mas grande
    var N = palabras.length;
	
    var max = 0;
    for (var i = 0; i<N; i++) {
        if (palabras[i].length>max) {
            max = palabras[i].length; //los caracteres especiales cuentan como uno
        }
    }
    //tamanio de la matricula
    window.tam = max>=15 ? max + 2 : max + 3;  

    //inicializamos la cuadricula de la sopa
    sopa = new Array(window.tam);
    for (var i = 0; i< window.tam; i++) {
        window.sopa[i] = new Array(window.tam);
    }
    for (var i = 0; i<window.tam; i++) {
        for (var j=0; j<window.tam; j++) {
            window.sopa[i][j] = "0";
        }
    }
}

function colocarPalabra(palabra) {
    if (palabra.sentido === 1) {
     for (var k = palabra.columna, j = 0; j<palabra.longitud; k++, j++) { //poner horizontal
		  window.sopa[palabra.fila][k] = palabra.letras[j];		
	 }
   }
   else{
     for (var k = palabra.fila, j = 0; j<palabra.longitud ; k++, j++) { //poner horizontal
        window.sopa[k][palabra.columna] = palabra.letras[j];
    }
   }
    return true;
}

function libre(palabra) {
var puntos = {};
    if (palabra.sentido === 1) {
        for (var j = palabra.columna; j<palabra.longitud+palabra.columna; j++) { //if cabe horizontal
            if ( window.sopa[palabra.fila][j] != "0")
                return false;
        }
    }
    else{
        for (var j = palabra.fila; j<palabra.longitud + palabra.fila; j++) { //if cabe horizontal
               if ( window.sopa[j][palabra.columna] !== "0")
                  return false;
        }       
    }
    return true;
}

function ubicarPalabra(act) { // Ubicacion de cada palabra en la cuadricula los Datos de cada palabra se almacenan en un registro
var palabra = {};
palabra.longitud = act.length;
palabra.letras = act;
enc = false;
while (!enc) {
    palabra.sentido = Math.floor(Math.random()*2); //sentido
    pos1 = Math.floor(Math.random()*(window.tam - palabra.longitud));
    pos2 =  Math.floor(Math.random()*(window.tam));
    inicio = 0;
    if (palabra.sentido === 1) {
        palabra.fila = pos2;
        palabra.columna = pos1;
    }
    else{
        palabra.fila = pos1;
        palabra.columna = pos2;
    }
    if (libre(palabra)) {
        colocarPalabra(palabra);
        return palabra;
    }
}
    return palabra;
}

function generarsopa(palabras) {   //Generacion de la sopa, llenado de la cuadricula, ubicacion de la sopa y pistas dentro del HTML
var N = palabras.length;
var datosPalabras = new Array(N);
inicializar(palabras);
    if (window.tam > 0) {
        for (var i = 0; i<N; i++) {
                datosPalabras[i] = ubicarPalabra(palabras[i]);             
        } 
    }
dibujarSopa();
dibujarPistas(palabras);
return datosPalabras;
}

/*****************************************
 *                                       *
 *     FUNCIONES PARA LA UI              *
 *****************************************/
function dibujarSopa() {  //dibujado de la sopa dentro de una tabla
    var sopita = "<table id='sopa'>";
        for (var i =0; i<window.tam; i++) {
            sopita = sopita + "<tr>"
            for (var j = 0; j<window.tam; j++) {
                if (window.sopa[i][j] !== "0") {
                   sopita = sopita + "<td class='"+ window.sopa[i][j] + "' id='" + i + ","+ j  +"'> " + window.sopa[i][j] + " </td>"; 
                }
                else{
                    var random = Math.floor(Math.random()*27);
                    sopita = sopita + "<td class='"+ window.sopa[i][j] + "' id='" + i + ","+ j  +"'> " + letras[random]+ "</td>"; /* */
                }
                
            }
            sopita = sopita + "</tr>";
        }
    document.getElementById("contenedorSopa").innerHTML = sopita;
}

function dibujarPistas(palabras) { //Escribe las pistas en la intefaz
    var pisticas = "<table id='pistas'>";
    n = pistas.length;
    for (var i = 0; i<n; i++) {
        pisticas = pisticas + "<tr>" + "<td class='" + palabras[i] +"'>" + pistas[i] + "</td>";
    }
    pisticas = pisticas + "</table>";
    document.getElementById("contenedorPistas").innerHTML = pisticas;
}

//VALIDACIONES - FUNCIONAMIENTO - Tomando en cuenta caracteres especiales
function buscar(palabra){    //Busca que un conjunto de letras seleccionadas sea una palabra
  var n = palabras.length;
   for (var i =0; i<n; i++) {
        if (palabra.indexOf(palabras[i]) >= 0) 
		   return true;
   }
  return false;
 } 

function buenCamino(x,y){ //verifica que la coordenada inicial seleccionada sea de una palabra
    var pos = posiciones.length;
    for (var i=0; i<pos; i++){
        if ((posiciones[i].fila === parseInt(x) && posiciones[i].columna === parseInt(y)))
            return posiciones[i];
    }
    return false;
}

function seleccionandoPalabra(seleccion,posicion){ //verificamos que este seleccionando correctamente la palabra
   var sel = seleccion.length;
   j=0;
   for (var i = 0; i< sel; i++){
		if (seleccion[i] !== posicion.letras[i])
			return false;
   }
   return true;
}

function buscarPista(){   //Muestra una pista al usuario
var n = posiciones.length;
for (var i =0; i<n; i++) {
       if (document.getElementById("sopa").getElementsByTagName("tr")[posiciones[i].fila].getElementsByTagName("td")[posiciones[i].columna].className !== "correcta") {
         document.getElementById("sopa").getElementsByTagName("tr")[posiciones[i].fila].getElementsByTagName("td")[posiciones[i].columna].style.background = "rgb(65, 185, 65)";
         return true;
   }
}
}

/*****************************************
 *                                       *
 *         INICIO                        *
 *****************************************/
$(document).ready(function(){
	if (palabras == undefined)
		window.location.reload();
    posiciones = generarsopa(window.palabras);
    var x = new Array();
    var y = new Array();
    var tam = 0;
    var inc = 0; 
    var encontradas = 0;
	var marcada = "";
	
$("#pista").click(function(){

    if (pistas_usadas < 3) {
     if (buscarPista()){
		 window.pistas_usadas++;
         $("#pista"+pistas_usadas).attr("src","images/usada.png");
	 }
    }
	if (pistas_usadas == 3){
		$("#pista").attr("disabled", "disabled");
        $("#mensajessopa").html("<span style='color:rgb(253, 181, 141);'><img src='images/cross.png' style='margin-bottom: -5px;'> Ups! ya no tienes m&aacute;s pistas</span>");
    }
   
 });
 
$("#sopa tr td").click(function(){
	
   $(this).css("background","rgb(199, 140, 140)");
   
   marcada = marcada + $(this).attr("class");

   var coord = $(this).attr("id").split(","); //obtenemos las coordenadas de lo que se esta marcando a traves del class del elemento de la tabla
   x[tam] = coord[0];
   y[tam] = coord[1];
   tam++;

   if (marcada.length === 1 )
      posCorrecta = buenCamino(x[tam-1], y[tam-1]);

   if (posCorrecta !== false) {
      if(buscar(marcada)){
         for (var i = 0; i< tam; i++) {
            document.getElementById("sopa").getElementsByTagName("tr")[x[i]].getElementsByTagName("td")[y[i]].style.background = "#7DCACE";
            document.getElementById("sopa").getElementsByTagName("tr")[x[i]].getElementsByTagName("td")[y[i]].className = "correcta";
         }
         $(".correcta").unbind("click");
         //marcamos la palabra encontrada en las pistas
         var clase = marcada.split(" ");
         var nombreClase = "";
            for (var k = 0; k<clase.length; k++) {
                    nombreClase += ".";
                    nombreClase += clase[k];
            }
         $("#pistas tr td" +nombreClase).css("color","#7DCACE"); 
         $("#pistas tr td" +nombreClase).css("font-weight","bold");
         $("#pistas tr td" +nombreClase).append(" <img src='images/accept.png'>");
         x = [];
         y = [];
         tam = 0;
         inc = 0;
         marcada = "";
         $("#mensajessopa").html("<span style='color:#7DCACE;'><img src='images/accept.png' style='margin-bottom: -5px;'> &iexcl;Muy bien! </span>");
         
         encontradas++;
         if (encontradas === palabras.length)
             $( "#fin" ).dialog( "open" );
      }
      else{
          if (!seleccionandoPalabra(marcada, posCorrecta))
              inc = 4000;
      }
   }
   else if(posCorrecta === false){
      document.getElementById("sopa").getElementsByTagName("tr")[x[tam-1]].getElementsByTagName("td")[y[tam-1]].style.background = "red";
      inc++;
   }
   if (inc > 1){
       for (var i =0; i< tam; i++) 
           document.getElementById("sopa").getElementsByTagName("tr")[x[i]].getElementsByTagName("td")[y[i]].style.background = "transparent";
        marcada = ""
        tam = 0;
        x = [];
        y = [];
        if (inc !== 4000)
            $("#mensajessopa").html("<span style='color:rgb(253, 181, 141);'><img src='images/cross.png' style='margin-bottom: -5px;'> Ups! por ah&iacute; no est&aacute; la palabra</span>");
        else
            $("#mensajessopa").html("<span style='color:rgb(196, 229, 252);'><img src='images/nota.png'> &iexcl;&Aacute;nimo! est&aacute;s cerca</span>");
        
        inc = 0;
   }
});

$( "#fin" ).dialog({
  height: 250,
  width: 400,
 /* modal: true,*/
  autoOpen:false,
  open: function(){$("#retroalimentacion").html(retroalimentacion); rep();},
  buttons: {
    "Cerrar": function() {
      audios.pause();
	  $( this ).dialog( "close" );
	  
    },
    "Hacer otra sopa": function(){ 
    $( this ).dialog( "close" );
    location.reload();
    }
  }
});

});