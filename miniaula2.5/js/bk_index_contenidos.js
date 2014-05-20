
var grado = getUrlVars()["grado"];
var area = getUrlVars()["area"];
var componente = getUrlVars()["componente"];

function abrirVentana (url){
	window.open(url, "nuevo", "width=1020, height=600");
}

$(document).ready(function(){
$(".acts li a").click(function(event){
	event.preventDefault();
	link = $(this).attr("href");
	abrirVentana(link)
	});
});

if (area != undefined){
	if (componente=="GR" || componente=="GR#"){
		componente = "GR";
		$("#titulo").html("Actividades de Gesti&oacute;n de Riesgos en "+area);
	}
	else{
		componente = "I";
		$("#titulo").html("Actividades de Inundaciones en "+area);
	}

/**********************************************
* Listando contenidos de lenguaje 5to - 6to   *
***********************************************/
if (area == "Lenguaje"){ 
//Gestion de Riesgos
if (componente=="GR" || componente=="GR#"){
$("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/desastre.png" /></div><span>&iquest;Qu&eacute; desastres han ocurrido en esta zona? &iquest;Qu&eacute; sucedi&oacute;? &iquest;Cu&aacute;ndo? &iquest;Qu&eacute; hizo la gente?</span></a></div>\
                       <div><a href="#" class="item" id="2"><div class="icon"><img src="images/desastre.png" /></div><span>&iquest;Podemos evitar los desastres?</span></a></div>');
 $("#Lact").append('<ul class="1 acts">\
                        <li><a href=""><img src="images/empty.gif" />Lee y aprende</a></li>\
                        <li><a href="actividadesComunes/escribe.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=1"><img src="images/empty.gif" />Escribe un relato</a></li>\
                        <li><a href="actividadesComunes/miraydescribe.html?&componente='+componente+'"><img src="images/empty.gif" />Mira y escribe</a></li>\
                </ul>\
                <ul class="2 acts">\
                	<li><a href=""><img src="images/empty.gif" />Lee y aprende</a></li>\
                	<li><a href="actividadesComunes/ordenaPalabras.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=2"><img src="images/empty.gif" />Ordena palabras</a></li>\
               		<li><a href="actividadesComunes/escribe.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=4"><img src="images/empty.gif" />Escribe un relato</a></li>\
                </ul>')
}
//Inundaciones
if (componente=="I" || componente=="I#"){
 $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/desastre.png" /></div><span>&iquest;Qu&eacute; habr&iacute;a que hacer para evitar que se produzca un desastre hidrol&oacute;gico en el futuro?</span></a></div>');
 $("#Lact").append('<ul class="1 acts">\
                            <li><a href=""><img src="images/empty.gif" />Lee y aprende</a></li>\
                        <li><a href="actividadesComunes/escribe.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=3"><img src="images/empty.gif" />Escribe un relato</a></li>\
                        <li><a href="actividadesComunes/miraydescribe.html?&componente='+componente+'"><img src="images/empty.gif" />Mira y escribe</a></li>\
                </ul>');

}
}
	
/**********************************************
* Listando contenidos de ciencias 5to - 6to   *
***********************************************/
else if (area == "Ciencias"){
if (componente=="GR" || componente=="GR#"){
 $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/ambiente.png" /></div><span>Conozcamos acerca del ambiente</span></a></div>\n\
                        <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/ambiente.png" /></div><span>Principales componentes del ambiente</span></a></div>\n\
                        <div><a href="#" class="item" id ="3"><div class="icon"><img src="images/cuidar.png" /></div><span>&iquest;C&oacute;mo podemos cuidar nuestro ambiente&#63;</span></a></div>\n\
                        <div><a href="#" class="item" id ="4"><div class="icon"><img src="images/proteccion.png" /></div><span>&iquest;C&oacute;mo estar seguros ante un riesgo&#63;</span></a></div>');
 $("#Lact").append('<ul class="1 acts">\
                        <li><a href="actividadesComunes/visorLibros.html?libro=LibroGRCS1&paginas=7&ancho=300&largo=600"><img src="images/empty.gif" />Libro interactivo</a></li>\
                        <li><a href="actividadesComunes/sopadeletras.html?numero=1&nombre=Sopa_ambiental"><img src="images/empty.gif" />Sopa ambiental</a></li>\
                        <li><a href="actividadesComunes/miradescribe.html?numero=2&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                </ul>\n\
                <ul class="2 acts">\
                    <li><a href=""><img src="images/empty.gif" />Lee y aprende</a></li>\
                    <li><a href="actividadesComunes/sopadeletras.html?numero=2&nombre=Sopa_ambiental"><img src="images/empty.gif" />Sopa ambiental</a></li>\n\
                    <li><a href="actividadesComunes/crucigrama.html?numero=1&nombre=CruciAmbiente"><img src="images/empty.gif" />CruciAmbiente</a></li>\n\
                </ul>\n\
                <ul class="3 acts">\
                    <li><a href=""><img src="images/empty.gif" />Lee y aprende</a></li>\
                    <li><a href="actividadesComunes/visorAnimaciones.html?animacion=Efecto_Invernadero&tipo=swf"><img src="images/empty.gif" />Animaci&oacute;n</a></li>\n\
                    <li><a href="actividadesComunes/sopadeletras.html?numero=5&nombre=Sopa_ambiental"><img src="images/empty.gif" />Sopa ambiental</a></li>\n\
                    <li><a href="actividadesComunes/miraClasifica.html?componente='+componente+'"><img src="images/empty.gif" />Mira y clasifica</a></li>\
        <li><a href="actividadesComunes/miradescribe.html?numero=3&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                </ul>\n\
                <ul class="4 acts">\
                    <li><a href="#"><img src="images/empty.gif" />Libro interactivo</a></li>\n\
                    <li><a href="scriptsActividades/ActDiccionario/diccionario.html?palabras=GR1"><img src="images/empty.gif" />Glosario interactivo</a></li>\n\
                    <li><a href="actividadesComunes/sopadeletras.html?numero=4&nombre=Sopa_de_riesgos"><img src="images/empty.gif" />Sopa de riesgos</a></li>\n\
                    <li><a href="actividadesComunes/crucigrama.html?numero=2&nombre=CruciAmbiente"><img src="images/empty.gif" />CruciRiesgos</a></li>\
                    <li><a href="actividadesComunes/pareo.html?numero=3"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                </ul>');
}
//Inundaciones
if (componente=="I" || componente=="I#"){
$("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/ciclo.png" /></div><span>&iquest;Qu&eacute; es el ciclo del agua&#63;</span></a></div>\n\
                        <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/inundaciones.png" /></div><span>Aprendamos todo sobre las inundaciones</span></a></div>');
 $("#Lact").append('<ul class="1 acts">\
                        <li><a href="actividadesComunes/visorLibros.html?libro=LibroICS1&paginas=21&ancho=800&largo=350"><img src="images/empty.gif" />Libro interactivo</a></li>\
                        <li><a href="actividadesComunes/visorAnimaciones.html?animacion=Ciclo_del_Agua&tipo=swf"><img src="images/empty.gif" />El ciclo del agua</a></li>\n\
						<li><a href="actividadesComunes/visorAnimaciones.html?animacion=Ciclo_del_Agua&tipo=html&enunciado=Observa_la_imagen_y_luego_ordena_las_fases_del_Ciclo_del_Agua"><img src="images/empty.gif" />Completa el ciclo del agua</a></li>\n\
                        <li><a href="actividadesComunes/sopadeletras.html?numero=3&nombre=Sopa_del_agua"><img src="images/empty.gif" />Sopa del agua</a></li>\n\
                        <li><a href="actividadesComunes/crucigrama.html?numero=3&nombre=CruciAgua"><img src="images/empty.gif" />CruciAgua</a></li>\
                        <li><a href="actividadesComunes/miraClasifica.html?&componente='+componente+'"><img src="images/empty.gif" />Mira y clasifica</a></li>\
        <li><a href="actividadesComunes/pareo.html?numero=4"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                </ul>\n\
                <ul class="2 acts">\n\
                    <li><a href="#"><img src="images/empty.gif" />Libro interactivo</a></li>\
                    <li><a href="actividadesComunes/visorLibros.html?libro=AddI01&paginas=4&ancho=300&largo=600"><img src="images/empty.gif" />Libro interactivo: Tipos de inundaciones</a></li>\
                    <li><a href="actividadesComunes/sopadeletras.html?numero=6&nombre=Sopa_de_inundaciones"><img src="images/empty.gif" />Sopa de inundaciones</a></li>\
                    <li><a href="actividadesComunes/crucigrama.html?numero=4&nombre=CruciAgua"><img src="images/empty.gif" />CrucInundaci&oacute;n</a></li>\
                    <li><a href="actividadesComunes/miradescribe.html?numero=1&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                    <li><a href="actividadesComunes/pareo.html?numero=5"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                </ul>');
}
}
/**********************************************
* Listando contenidos de SOCIALES 5to - 6to   *
***********************************************/
else if (area == "Sociales"){
if (componente=="GR" || componente=="GR#"){
$("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/normas.png" /></div><span>Pongamos en pr&aacute;ctica las normas de seguridad en nuestra escuela, hogar y comunidad</span></a></div>\
                        <div><a href="#" class="item" id ="3"><div class="icon"><img src="images/mapas.png" /></div><span>&iquest;Conozcamos para qu&eacute; son las im&aacute;genes de precauci&oacute;n o de peligro? &iquest;Qu&eacute; advierten y a qui&eacute;n?</span></a></div>');
 $("#Lact").append('<ul class="1 acts">\
                    <li><a href=""><img src="images/empty.gif" />Libro interactivo</a></li>\
                    <li><a href="actividadesComunes/miraClasifica.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=1"><img src="images/empty.gif" />Mira y clasifica</a></li>\
                    <li><a href="actividadesComunes/miradescribe.html?numero=4&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                </ul>\
                <ul class="3 acts">\
                     <li><a href=""><img src="images/empty.gif" />Libro interactivo</a></li>\
                    <li><a href="actividadesComunes/miradescribe.html?numero=5&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                    <li><a href="actividadesComunes/pareo.html?numero=1"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                 </ul>');
}
//Inundaciones
if (componente=="I" || componente=="I#"){
$("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/normas.png" /></div><span>&iquest;Conoces de alg&uacute;n evento hidrol&oacute;gico que haya ocurrido cerca de tu escuela o comunidad? &iquest;Cu&aacute;ndo? &iquest;Qu&eacute; hizo la gente?</span></a></div>');
 $("#Lact").append('<ul class="1 acts">\
                     <li><a href=""><img src="images/empty.gif" />Libro interactivo</a></li>\
                    <li><a href="actividadesComunes/pareo.html?numero=2"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                </ul>');
}
}
/**********************************************
* Listando contenidos de deportes 5to - 6to   *
***********************************************/
else if (area == "Deportes"){
if (componente=="GR" || componente=="GR#"){
 $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/desastre.png" /></div><span>Repasemos acerca de los desastres</span></a></div>\n\
                        <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/mapas.png" /></div><span>&iquest;Para qu&eacute; sirve un mapa de riesgo? Manos a la obra y crea un mapa de riesgo de tu comunidad</span></a></div>');
 $("#Lact").append('<ul class="1 acts">\
                        <li><a href=""><img src="images/empty.gif" />Libro interactivo</a></li>\
                        <li><a href="actividadesComunes/mapaMental.html?numero=2"><img src="images/empty.gif" />Mapa mental: Desastres naturales</a></li>\
                        <li><a href="actividadesComunes/mapaMental.html?numero=3"><img src="images/empty.gif" />Mapa mental: Gesti&oacute;n de riesgos</a></li>\
                        <li><a href="actividadesComunes/mapaMental.html?numero=4"><img src="images/empty.gif" />Mapa mental: &iquest;Qu&eacute; hacer ante desastres naturales?</a></li>\
                </ul>\n\
                <ul class="2 acts">\
                     <li><a href=""><img src="images/empty.gif" />Libro interactivo</a></li>\
                    <li><a href="actividadesComunes/mapas.html?tipo=1&enunciado=1"><img src="images/empty.gif" />Ubica la ruta de evacuaci&oacute;n de tu escuela</a></li>\
                    <li><a href="actividadesComunes/mapas.html?tipo=2&enunciado=2"><img src="images/empty.gif" />Dibuja el mapa de riesgo de tu comunidad</a></li>\
                </ul>');
}
//Inundaciones
if (componente=="I" || componente=="I#"){
     $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/inundaciones.png" /></div><span>&iquest;Qu&eacute; personas de tu escuela y comunidad podr&iacute;an ayudar en caso de un evento adverso de origen hidrol&oacute;gico?</span></a></div>');
 $("#Lact").append('<ul class="1 acts">\
                            <li><a href=""><img src="images/empty.gif" />Libro interactivo</a></li>\
                            <li><a href="actividadesComunes/mapaMental.html?numero=1"><img src="images/empty.gif" />Mapa mental: Inundaciones</a></li>\
                            <li><a href="actividadesComunes/mapaMental.html?numero=5"><img src="images/empty.gif" />Mapa mental: Personas que nos pueden ayudar</a></li>\
                </ul>');
}
}
}
