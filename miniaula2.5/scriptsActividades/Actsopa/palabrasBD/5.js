var opciones = new Array(new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACION", "NATURALEZA"),
						  new Array("BASURA", "CANALES", "RIOS", "IMPRUDENCIA", "CONSTRUCCIONES","BIODEGRADABLE"),
						  new Array("POBLACION","CULTURA","CUIDAR","EDUCACION","RESPETO","CONTAMINACION","RECICLAJE","MANTENIMIENTO")
						);
						
var pistas_opciones = new Array(
							new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACI&Oacute;N", "NATURALEZA"),
							new Array("BASURA", "CANALES", "R&Iacute;OS", "IMPRUDENCIA", "CONSTRUCCIONES","BIODEGRADABLE"),
							new Array("POBLACI&Oacute;N","CULTURA","CUIDAR","EDUCACI&Oacute;N","RESPETO","CONTAMINACI&Oacute;N","RECICLAJE","MANTENIMIENTO")
						  );
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Ahora estamos listos para comenzar a prevenir los riesgos";
