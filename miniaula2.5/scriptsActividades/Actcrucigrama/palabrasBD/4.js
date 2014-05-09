var opciones = new Array(
        new Array("INUNDACION",
"MAPA DE RIESGO",
"ESTAR CALMADO",
"BRIGADA ESCOLAR"
),
new Array("AMENAZA",
"COLABORAR",
"MAPA DE RIESGO",
"INUNDACION"
),
new Array("SOLIDARIDAD",
"CONTAMINAR",
"NATURALEZA",
"EMERGENCIA"
)
);
						
var pistas_opciones = new Array(
        new Array("Grandes masas de agua desbordada","Plan de evacuaci&oacute;n escolar","Sin&oacute;nimo de serenidad","Grupo escolar preparado ante emergencias"),
        new Array("Evento que puede poner en riesgo la vida","Acci&oacute;n de ayudar a otros que lo necesiten","Mapa con la ubicaci&oacute;n de salidas de escape escolar","Evento hidrol&oacute;gico que afecta hogares y comuidades"),
        new Array("Valor de apoyar a otros desinteresadamente","Acci&oacute;n de botar basura en afluentes hidrol&oacute;gicos","Lo que rodea al conjunto de seres vivos, del reino animal y vegetal","Incidencia u ocurrencia inesperada")
);
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Ahora estamos listos para comenzar a prevenir los riesgos";
