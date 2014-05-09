var opciones = new Array(new Array("INUNDACION",
"LLUVIA",
"CICLO DEL AGUA",
"BASURA"
),
new Array(
        "AGUA",
"LLUVIA",
"COMUNIDAD",
"PLANIFICAR"
)
);
						
var pistas_opciones = new Array(
        new Array("Sin&oacute;nimo de desastre hidrol&oacute;gico" ,"Gotas de agua que caen del cielo","Ciclo en donde se dan procesos de: evaporaci&oacute;n, precipitaci&oacute;n y condensaci&oacute;n ","Sin&oacute;nimo de desechos s&oacute;lidos"),
new Array("L&iacuteMquido vital que tomamos al darnos sed","Agua que cae en gotas del cielo ","Grupo de personas que viven en un mismo espacio territorial","Acci&oacute;n de hacer un plan")
);
						
var index = Math.floor(Math.random() * (opciones.length));
var palabras = opciones[index];
var pistas = pistas_opciones[index];

var retroalimentacion = "Recuerda cuidar el agua, el el l&iacute;quido vital para la vida";