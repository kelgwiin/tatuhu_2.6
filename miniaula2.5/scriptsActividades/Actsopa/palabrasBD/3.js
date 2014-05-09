var opciones = new Array(new Array("RIOS", "AGUA", "LLUVIA", "COLABORACION", "INUNDACION", "SOLIDO","LIQUIDO", "GASEOSO"),
						 new Array("CONDENSACION", "LLUVIA","NUBES","PRECIPITACION","EVAPORACION","ABSORCION","SOL"),
						 new Array("GRANIZO","NIEVE","ATMOSFERA","MARES","OCEANOS","LAGOS","SUELO","VAPOR")
						);
						
var pistas_opciones = new Array(new Array("R&Iacute;OS", "AGUA", "LLUVIA", "COLABORACI&Oacute;N", "INUNDACI&Oacute;N", "S&Oacute;LIDO","L&Iacute;QUIDO", "GASEOSO"),
						new Array("CONDENSACI&Oacute;N", "LLUVIA","NUBES","PRECIPITACI&Oacute;N","EVAPORACI&Oacute;N","ABSORCI&Oacute;N","SOL"),
						 new Array("GRANIZO","NIEVE","ATM&Oacute;SFERA","MARES","OCE&Aacute;NOS","LAGOS","SUELO","VAPOR")
						);
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Recuerda cuidar el agua, el el l&iacute;quido vital para la vida";