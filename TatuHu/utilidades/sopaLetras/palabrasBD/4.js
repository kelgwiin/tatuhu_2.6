var opciones = new Array(new Array("AMBIENTE", "RIESGO", "SOLIDARIDAD", "AYUDA", "PELIGRO"),
						  new Array("BOMBEROS", "PROTECCION CIVIL", "POLICIA", "BRIGADAS", "COMUNIDAD"),
						  new Array("MEDICOS", "PROTECCION CIVIL", "POLICIAS", "EJERCITO", "BOMBEROS"),
						  new Array("TENER CALMA", "SER SOLIDARIO",  "COOPERAR", "SER RESPONSABLE", "BUSCAR AYUDA" ),
						  new Array("AMENAZA","DEBILIDAD","RIESGO","PREVENCION","DESASTRE"),
						  new Array("CALMA", "AYUDAR", "BUSCAR AYUDA", "BOMBEROS", "COMUNIDAD"),
						  new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACION", "NATURALEZA"),
						  new Array("BASURA", "CANALES", "RIOS", "IMPRUDENCIA", "CONSTRUCCIONES"),
						  new Array("CUIDAR", "AMBIENTE", "DESECHOS", "RESPONSABLE", "PROTEGER"),
						  new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACION", "NATURALEZA"),
						  new Array("AMBIENTE","AGUA","PLAYAS","CASAS","SOL","LAGOS", "PLANTA","TIERRA","PERSONAS")
						  
						);
						
var pistas_opciones = new Array(
							new Array("AMBIENTE", "RIESGO", "SOLIDARIDAD", "AYUDA", "PELIGRO"),
							new Array("BOMBEROS", "PROTECCI&Oacute;N CIVIL", "POL&Iacute;CIA", "BRIGADAS", "COMUNIDAD"),
							new Array("M&Eacute;DICOS", "PROTECCI&Oacute;N CIVIL", "POL&Iacute;CIAS", "EJ&Eacute;RCITO", "BOMBEROS"),
						    new Array("TENER CALMA", "SER SOLIDARIO",  "COOPERAR", "SER RESPONSABLE", "BUSCAR AYUDA" ),
							 new Array("AMENAZA","DEBILIDAD","RIESGO","PREVENCI&Oacute;N","DESASTRE"),
							 new Array("CALMA", "AYUDAR", "BUSCAR AYUDA", "BOMBEROS", "COMUNIDAD"),
							 new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACION", "NATURALEZA"),
						  new Array("BASURA", "CANALES", "RIOS", "IMPRUDENCIA", "CONSTRUCCIONES"),
						  new Array("CUIDAR", "AMBIENTE", "DESECHOS", "RESPONSABLE", "PROTEGER"),
						  new Array("CONVIVENCIA", "SOLIDARIO", "RESPETO", "COLABORACION", "NATURALEZA"),
						  new Array("AMBIENTE","AGUA","PLAYAS","CASAS","SOL","LAGOS", "PLANTA","TIERRA","PERSONAS")
						  );
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Ahora estamos listos para comenzar a prevenir los riesgos";