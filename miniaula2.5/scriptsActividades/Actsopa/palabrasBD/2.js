var opciones = new Array(new Array("AMBIENTE","AGUA","PLAYAS","CASAS","SOL","LAGOS", "PLANTA","TIERRA","PERSONAS"),
						new Array("FLORA","FAUNA","SOCIEDAD","RELIEVE","CLIMA","ECOLOGIA"),
						new Array("CONSERVACION","NATURALEZA","PARQUES", "RECURSOS","PRESERVAR","ECOSISTEMA"));
						
var pistas_opciones = new Array(new Array("AMBIENTE","AGUA","PLAYAS","CASAS","SOL","LAGOS", "PLANTA","TIERRA","PERSONAS"),
						new Array("FLORA","FAUNA","SOCIEDAD","RELIEVE","CLIMA","ECOLOG&Iacute;A"),
						new Array("CONSERVACI&Oacute;N","NATURALEZA","PARQUES", "RECURSOS","PRESERVAR","ECOSISTEMA")
					);
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Ahora sabes que el ambiente est&aacute; compuesto por plantas, lagos, r&iacute;os, playas, personas... y muchas cosas m&aacute;s!<br><br> <strong>Debemos cuidar a nuestro ambiente</strong></div>";
