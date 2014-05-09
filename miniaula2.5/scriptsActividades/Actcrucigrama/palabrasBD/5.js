var opciones = new Array(new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACION", "NATURALEZA"),
						  new Array("BASURA", "CANALES", "RIOS", "IMPRUDENCIA", "CONSTRUCCIONES")
						  
						);
						
var pistas_opciones = new Array(
							new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACI&Oacute;N", "NATURALEZA"),
							new Array("BASURA", "CANALES", "R&Iacute;OS", "IMPRUDENCIA", "CONSTRUCCIONES")
						  );
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Ahora estamos listos para comenzar a prevenir los riesgos";
