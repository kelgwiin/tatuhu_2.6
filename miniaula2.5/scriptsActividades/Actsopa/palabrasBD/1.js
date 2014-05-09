var opciones = new Array(
						  new Array("CUIDAR", "AMBIENTE", "DESECHOS", "RESPONSABLE", "PROTEGER","COMUNIDAD"),
						  new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACION", "NATURALEZA", "CLIMA", "CULTURA")
						);
						
var pistas_opciones = new Array(
						  new Array("CUIDAR", "AMBIENTE", "DESECHOS", "RESPONSABLE", "PROTEGER","COMUNIDAD"),
						  new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACI&Oacute;N", "NATURALEZA", "CLIMA", "CULTURA"));
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Ahora sabes que el ambiente est&aacute; compuesto por plantas, lagos, r&iacute;os, playas, personas... y muchas cosas m&aacute;s!<br><br> <strong>Debemos cuidar a nuestro ambiente</strong></div>";
