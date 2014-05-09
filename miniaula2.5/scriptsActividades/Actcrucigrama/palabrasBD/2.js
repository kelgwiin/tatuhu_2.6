var opciones = new Array(
        new Array("COMUNIDAD", "PEDIR AYUDA", "SOLIDARIDAD", "COLABORACION"),
        new Array("RIESGO","PREVEER","AMENAZA","VULNERABILIDAD"),
	new Array("BRIGADA","BOMBEROS","PROTECCION CIVIL","COMUNIDAD"),
        new Array("DESASTRE","PREVENCION","NATURALEZA","EMERGENCIA"),
		new Array ("VULNERABILIDAD","DESASTRE","MITIGACION","LLUVIA","APRENDER")
);
						
var pistas_opciones = new Array(
        new Array("Lugar donde viven un grupo de personas sin parentesco", "Acci&oacute;n de buscar apoyo de personas", "Valor de socorrer a quien lo necesite ","Valor de ayudar a otros"),
        new Array("Probabilidad de que ocurra un desastre","Acci&oacute;n de prevenir", 
        "Alta probabilidad de que un fen&oacute;meno natural se produzca ocasionando da&ntilde;os",
        "Est&aacute; relacionado directamente con el grado de exposici&oacute;n de las personas o sus recursos frente a las amenazas"),
        new Array("Conjunto de personas preparadas ante emergencias" ,"Ente p&uacute;blico que se encarga de apagar incendios y apoyar en situaciones de emergencia","Organismo p&uacute;blico encargado de proteger y atender desastres naturales","Grupo de personas que viven en un mismo espacio territorial"),
		new Array("Singular de situaci&oacute;n desastrosa","Acci&oacute;n de prevenir","Lo que rodea al conjunto de seres vivos, del reino animal y vegetal","Incidencia u ocurrencia inesperada"),
		new Array("Es la fragilidad para soportar o enfrentar una amenaza",
		"Acontecimiento peligroso o grave de una comunidad o sociedad que causa p&eacute;rdidas humanas, materiales, econ&oacute;micas y/o ambientales",
		"Son medidas para reducir la vulnerabilidad frente a ciertas  amenazas",
		"Gotas que caen del cielo al llover","Acci&oacute;n del aprendizaje")
);
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Ahora sabes que el ambiente est&aacute; compuesto por plantas, lagos, r&iacute;os, playas, personas... y muchas cosas m&aacute;s!<br><br> <strong>Debemos cuidar a nuestro ambiente</strong></div>";
