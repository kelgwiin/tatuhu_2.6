var opciones = new Array(
						  new Array("AMBIENTE", "COMUNIDAD", "FAMILIA", "CUIDAR")//,
						 // new Array()
						);
						
var pistas_opciones = new Array(
						  new Array("Todo lo que nos rodea", "Grupo de personas que viven en un mismo espacio territorial", "Grupo de personas con parentesco consangu&iacute;neo", "Sin&oacute;nimo de proteger")//,
						//  new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACI&Oacute;N", "NATURALEZA"));
						);
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Ahora sabes que el ambiente est&aacute; compuesto por plantas, lagos, r&iacute;os, playas, personas... y muchas cosas m&aacute;s!<br><br> <strong>Debemos cuidar a nuestro ambiente</strong></div>";
