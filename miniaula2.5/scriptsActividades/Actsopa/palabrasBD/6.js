var opciones = new Array(new Array("TENER CALMA", "SER SOLIDARIO",  "COOPERAR", "SER RESPONSABLE", "BUSCAR AYUDA"),
			new Array("BASURA", "CANALES", "RIOS", "IMPRUDENCIA", "CONSTRUCCIONES", "PREVENCION","MITIGACION","PREPARACION", "ALERTA"),
                        new Array("CALMA", "AYUDAR", "BUSCAR AYUDA", "BOMBEROS", "COMUNIDAD"),
                        new Array("MEDICOS", "PROTECCION CIVIL", "POLICIAS", "BOMBEROS", "BRIGADAS", "ENFERMERAS", "CRUZ ROJA", "PAREMEDICOS", "VOLUNTARIOS"));
						
var pistas_opciones = new Array(new Array("TENER CALMA", "SER SOLIDARIO",  "COOPERAR", "SER RESPONSABLE", "BUSCAR AYUDA"),
                        new Array("BASURA", "CANALES", "R&Iacute;OS", "IMPRUDENCIA", "CONSTRUCCIONES", "PREVENCI&Oacute;N","MITIGACI&Oacute;N","PREPARACI&Oacute;N", "ALERTA"),
                        new Array("CALMA", "AYUDAR", "BUSCAR AYUDA", "BOMBEROS", "COMUNIDAD"),
                        new Array("M&Eacute;DICOS", "PROTECCI&Oacute;N CIVIL", "POLICIAS", "BOMBEROS", "BRIGADAS", "ENFERMERAS", "CRUZ ROJA", "PAREM&Eacute;DICOS", "VOLUNTARIOS"));
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Recuerda cuidar el agua, el el l&iacute;quido vital para la vida";