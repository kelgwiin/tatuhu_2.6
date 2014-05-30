
var grado = getUrlVars()["grado"];
var area = getUrlVars()["area"];
var componente = getUrlVars()["componente"];

function abrirVentana (url){
	window.open(url, "nuevo", "width=1020, height=700 ,scrollbars=yes");
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
		$("span#titulo_cuerpo").html("Gesti&oacute;n de Riesgos <br>en "+area);
	}
	else{
		componente = "I";
		$("span#titulo_cuerpo").html("Inundaciones <br>en "+area);
	}
/**---------------------------------------------------------------------
 *  -----                    L E N G U A J E     -----------------------
 * ---------------------------------------------------------------------
 */

/**********************************************
* Listando contenidos de LENGUAJE 5to - 6to   *
***********************************************/
if (area == "Lenguaje"){ 
    switch(grado){
        
        case "5":
            //Gestion de RIESGOS
            if (componente=="GR" || componente=="GR#"){
                //Índice: Seleccione un Tema
                $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/ambiente.png" /></div><span>Conozcamos acerca del ambiente y sus componentes</span></a></div>\
                <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/cuidar.png" /></div><span>&iquest;C&oacute;mo podemos cuidar nuestro ambiente&#63;</span></a></div>\
                <div><a href="#" class="item" id ="3"><div class="icon"><img src="images/semaforo.png" /></div><span>Aprendamos todo sobre seguridad vial</span></a></div>\
                <div><a href="#" class="item" id ="4"><div class="icon"><img src="images/mapas.png" /></div><span>Aprendamos acerca de señales de tránsito</span></a></div>\
                ');
            
                //Índice: Seleccione una actividad 
                $("#Lact").append('<ul class="1 acts">\
                    <li><a href="actividadesComunes/visorLibros.html?libro=LibroAgua&paginas=41&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: El agua</a></li>\
                    <li><a href="actividadesComunes/miraClasifica.html?&componente='+componente+'"><img src="images/empty.gif" />Mira y clasifica</a></li>\
                    <li><a href="actividadesComunes/pareo.html?numero=4"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                    \
                    </ul>\
                    <ul class="2 acts">\
                    <li><a href="actividadesComunes/visorAnimaciones.html?animacion=Efecto_Invernadero&tipo=swf"><img src="images/empty.gif" />Mira y aprende: Efecto invernadero</a></li>\
                    <li><a href="actividadesComunes/sopadeletras.html?numero=5&nombre=Sopa_ambiental"><img src="images/empty.gif" />Sopa ambiental</a></li>\
                    <li><a href="actividadesComunes/miraClasifica.html?componente='+componente+'"><img src="images/empty.gif" />Mira y clasifica</a></li>\
                    <li><a href="actividadesComunes/miradescribe.html?numero=3&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                    </ul>\
                    \
                    <ul class = "3 acts">\
                        <li><a href="actividadesComunes/visorLibros.html?libro=LibroSegurVial&paginas=25&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Seguridad vial</a></li>\
                        <li><a href="actividadesComunes/miraydescribe.html?&componente=SegVial"><img src="images/empty.gif" />Mira y escribe</a></li>\
                        <li><a href="actividadesComunes/miradescribe.html?numero=6&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe: Funciones del semáforo</a></li>\
                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=el_semaforo.mp4"><img src="images/empty.gif" />Mira y aprende: El semáforo</a></li>\
                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=semaforo_peatones.mp4"><img src="images/empty.gif" />Mira y aprende: El semáforo de peatones</a></li>\
                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=cinturon_de_seguridad.mp4"><img src="images/empty.gif" />Mira y aprende: El cinturón de seguridad</a></li>\
                        <li><a href="actividadesComunes/escribe.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=5"><img src="images/empty.gif" />Escribe un relato</a></li>\
                    </ul>\
                    <ul class = "4 acts">\
                        <li><a href="actividadesComunes/visorLibros.html?libro=LibroSeTransito&paginas=14&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Señales de tránsito</a></li>\
                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=senales_transito.mp4"><img src="images/empty.gif" />Mira y aprende: Señales de tránsito</a></li>\
                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=semaforo_pasos_de_cebra.mp4"><img src="images/empty.gif" />Mira y aprende: Semáforos y el rayado</a></li>\
                        <li><a href="actividadesComunes/miradescribe.html?numero=7&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                        <li><a href="http://ninosyseguridadvial.com/juegos/el-juego-de-las-senales/"><img src="images/empty.gif" />Juega con las señales <small>(Requiere Internet)</small> </a></li>\
                    </ul>\
                    ')
            }//end of - Gestión de Riesgos

            //INUNDACIONES
            if (componente=="I" || componente=="I#"){
                    //Índice: Seleccione un Tema
                    $("#acordeon").append(
                        '<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/ciclo.png" /></div><span>El agua, su uso y conservación</span></a></div>\
                        <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/ciclo.png" /></div><span>&iquest;Qu&eacute; es el ciclo del agua&#63;</span></a></div>\
                        ');
                    //Índice: Seleccione una actividad 
                    $("#Lact").append('<ul class="1 acts">\
                                        <li><a href="actividadesComunes/visorLibros.html?libro=LibroICS1&paginas=21&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Ciclo del agua</a></li>\
                                        <li><a href="actividadesComunes/sopadeletras.html?numero=3&nombre=Sopa_del_agua"><img src="images/empty.gif" />Sopa del agua</a></li>\
                                        <li><a href="actividadesComunes/visorAnimaciones.html?animacion=Ciclo_del_Agua&tipo=swf"><img src="images/empty.gif" />Mira y aprende</a></li>\n\
                                        <li><a href="actividadesComunes/crucigrama.html?numero=4&nombre=CruciAgua"><img src="images/empty.gif" />CruciAgua</a></li>\
                        </ul>\
                        <ul class="2 acts">\
                                        <li><a href="actividadesComunes/visorAnimaciones.html?animacion=Ciclo_del_Agua&tipo=html&enunciado=Observa_la_imagen_y_luego_ordena_las_fases_del_Ciclo_del_Agua"><img src="images/empty.gif" />Completa el ciclo del agua</a></li>\
                        </u>\
                        ');
            }//end of - Inundaciones
            break;

        case "6":
            //Gestion de RIESGOS
            if (componente=="GR" || componente=="GR#"){
                //Índice: Seleccione un Tema
                $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/ambiente.png" /></div><span>Conozcamos acerca del ambiente y sus componentes</span></a></div>\
                <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/cuidar.png" /></div><span>&iquest;C&oacute;mo podemos cuidar nuestro ambiente&#63;</span></a></div>\
                ');
            
                //Índice: Seleccione una actividad 
                $("#Lact").append('<ul class="1 acts">\
                    <li><a href="actividadesComunes/visorLibros.html?libro=LibroInun&paginas=41&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende ---- (falta)</a></li>\
                    <li><a href="actividadesComunes/miraClasifica.html?&componente='+componente+'"><img src="images/empty.gif" />Mira y clasifica</a></li>\
                    <li><a href="actividadesComunes/pareo.html?numero=4"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                    \
                    </ul>\
                    <ul class="2 acts">\
                    <li><a href="actividadesComunes/visorAnimaciones.html?animacion=Efecto_Invernadero&tipo=swf"><img src="images/empty.gif" />Mira y aprende: Efecto invernadero</a></li>\
                    <li><a href="actividadesComunes/miraClasifica.html?componente='+componente+'"><img src="images/empty.gif" />Mira y clasifica</a></li>\
                    <li><a href="actividadesComunes/miradescribe.html?numero=3&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                    </ul>\
                    \
                    ');
            }//end of - Gestión de Riesgos

            //INUNDACIONES
            if (componente=="I" || componente=="I#"){
                    //Índice: Seleccione un Tema
                    $("#acordeon").append(
                        '<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/ciclo.png" /></div><span>El agua, su uso y conservación</span></a></div>\
                        <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/ciclo.png" /></div><span>&iquest;Qu&eacute; es el ciclo del agua&#63;</span></a></div>\
                        ');
                    //Índice: Seleccione una actividad 
                    $("#Lact").append('<ul class="1 acts">\
                                        <li><a href="actividadesComunes/visorLibros.html?libro=LibroAgua&paginas=41&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: El agua</a></li>\
                                        <li><a href="actividadesComunes/visorAnimaciones.html?animacion=Ciclo_del_Agua&tipo=swf"><img src="images/empty.gif" />Mira y aprende</a></li>\n\
                        </ul>\
                        <ul class="2 acts">\
                                        <li><a href="actividadesComunes/visorAnimaciones.html?animacion=Ciclo_del_Agua&tipo=html&enunciado=Observa_la_imagen_y_luego_ordena_las_fases_del_Ciclo_del_Agua"><img src="images/empty.gif" />Completa el ciclo del agua</a></li>\
                        </u>\
                        ');
            }//end of - Inundaciones

            break;
    }

    
}// end of - LENGUAJE




/**---------------------------------------------------------------------
 *  ---------                C I E N C I A S      ----------------------
 * ---------------------------------------------------------------------
 */


	
/**********************************************
* Listando contenidos de CIENCIAS 5to - 6to   *
***********************************************/
else if (area == "Ciencias"){
    switch(grado){
        case "5":
            if (componente=="GR" || componente=="GR#"){
                $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/ambiente.png" /></div><span>Aprendamos todo sobre las amenazas</span></a></div>\n\
                                <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/proteccion.png" /></div><span>Aprendamos todo sobre riesgos</span></a></div>');
                $("#Lact").append('<ul class="1 acts">\
                                <li><a href="actividadesComunes/visorLibros.html?libro=LibroRiesgos&paginas=51&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Gestión de riesgos</a></li>\
                                <li><a href="actividadesComunes/mapaMental.html?numero=2"><img src="images/empty.gif" />Mapa mental: Desastres naturales</a></li>\
                        </ul>\n\
                        <ul class="2 acts">\
                            <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=gestion_riesgos.ogv"><img src="images/empty.gif" />Mira y aprende: Gestión de riesgos</a></li>\
                            <li><a href="actividadesComunes/mapaMental.html?numero=3"><img src="images/empty.gif" />Mapa mental: Gestión de riesgos</a></li>\
                        </ul>');
            }//end of - Gestión de Riesgos

            //-------------
            //Inundaciones
            //-------------
            if (componente=="I" || componente=="I#"){
                $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/inundaciones.png" /></div><span>Aprendamos todo sobre las inundaciones</span></a></div>\
                    <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/globo_tierra.ico" /></div><span>Aprendamos todo sobre los sismos y terremotos</span></a></div>\
                ');

                $("#Lact").append('<ul class="1 acts">\
                                    <li><a href="actividadesComunes/visorLibros.html?libro=LibroInund&paginas=41&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Inundaciones</a></li>\
                                    <li><a href="actividadesComunes/sopadeletras.html?numero=3&nombre=Sopa_del_agua"><img src="images/empty.gif" />Sopa del agua</a></li>\
                                    <li><a href="actividadesComunes/crucigrama.html?numero=4&nombre=CruciAgua"><img src="images/empty.gif" />CrucInundaci&oacute;n</a></li>\
                                    <li><a href="actividadesComunes/miradescribe.html?numero=1&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                                    <li><a href="actividadesComunes/pareo.html?numero=4"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                                    <li><a href="actividadesComunes/mapaMental.html?numero=1"><img src="images/empty.gif" />Mapa mental: Inundaciones</a></li>\
                                    \
                            </ul>\n\
                            <ul class="2 acts">\n\
                                <li><a href="actividadesComunes/visorLibros.html?libro=LibroSismos&paginas=20&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Los sismos</a></li>\
                                <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=terremotos.mp4"><img src="images/empty.gif" />Mira y aprende: Los sismos</a></li>\
                                <li><a href="actividadesComunes/miradescribe.html?numero=9&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                                <li><a href=""><img src="images/empty.gif" />Completa palabras o lee y aprende - falta </a></li>\
                                <li><a href="actividadesComunes/escribe.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=6"><img src="images/empty.gif" />Escribe un relato</a></li>\
                            </ul>');
                }// end of - Inundaciones
            break;



        case "6":
            //Gestión de Riesgos
            if (componente=="GR" || componente=="GR#"){
                $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/ambiente.png" /></div><span>Aprendamos todo sobre las amenazas</span></a></div>\
                                <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/proteccion.png" /></div><span>Aprendamos todo sobre riesgos</span></a></div>');
                $("#Lact").append('<ul class="1 acts">\
                                    <li><a href="actividadesComunes/visorLibros.html?libro=LibroRiesgos&paginas=51&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Gestión de riesgos</a></li>\
                                    <li><a href="actividadesComunes/escribeReflexion.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=ciclo_desastre"><img src="images/empty.gif" />Reflexiona y escribe: ciclo del desastre</a></li>\
                                    <li><a href="actividadesComunes/mapaMental.html?numero=2"><img src="images/empty.gif" />Mapa mental: Desastres naturales</a></li>\
                                  </ul>\
                                  \
                                  <ul class = "2 acts">\
                                    <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=gestion_riesgos.ogv"><img src="images/empty.gif" />Mira y aprende: Gestión de riesgos</a></li>\
                                    <li><a href="actividadesComunes/escribeReflexion.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=reducir_riesgos"><img src="images/empty.gif" />Reflexiona y escribe: Ciclo del desastre</a></li>\
                                    <li><a href="actividadesComunes/mapaMental.html?numero=3"><img src="images/empty.gif" />Mapa mental: Gestión de riesgos</a></li>\
                                  </ul>');

            }//end of - Gestión de Riesgos



            //Inundaciones
            if (componente=="I" || componente=="I#"){
                $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/inundaciones.png" /></div><span>Aprendamos todo sobre las inundaciones</span></a></div>\
                    <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/globo_tierra.ico" /></div><span>Aprendamos todo sobre los sismos y terremotos</span></a></div>\
                ');

                $("#Lact").append('<ul class="1 acts">\
                                    <li><a href="actividadesComunes/visorLibros.html?libro=LibroInund&paginas=41&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Inundaciones</a></li>\
                                    <li><a href="actividadesComunes/sopadeletras.html?numero=3&nombre=Sopa_del_agua"><img src="images/empty.gif" />Sopa del agua</a></li>\
                                    <li><a href="actividadesComunes/crucigrama.html?numero=4&nombre=CruciAgua"><img src="images/empty.gif" />CrucInundaci&oacute;n</a></li>\
                                    <li><a href="actividadesComunes/miradescribe.html?numero=1&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                                    <li><a href="actividadesComunes/pareo.html?numero=4"><img src="images/empty.gif" />Asocia la definici&oacute;n</a></li>\
                                    <li><a href="actividadesComunes/mapaMental.html?numero=1"><img src="images/empty.gif" />Mapa mental: Inundaciones</a></li>\
                                    \
                            </ul>\n\
                            <ul class="2 acts">\n\
                                <li><a href="actividadesComunes/visorLibros.html?libro=LibroInund&paginas=41&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Inundaciones</a></li>\
                                <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=terremotos.mp4"><img src="images/empty.gif" />Mira y aprende sobre sismos</a></li>\
                                <li><a href="actividadesComunes/miradescribe.html?numero=9&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                                <li><a href="actividadesComunes/escribe.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=6"><img src="images/empty.gif" />Escribe un relato</a></li>\
                            </ul>');
             
                

            }//end of - Inundaciones

            break;
    }

   


}//end of - Ciencias 



/**---------------------------------------------------------------------
 *  ---------                 S O C I A L E S     ----------------------
 * ---------------------------------------------------------------------
 */



/**********************************************
* Listando contenidos de SOCIALES 5to - 6to   *
***********************************************/
else if (area == "Sociales"){
    switch(grado){
        //sólo 6to grado
        case '6':
            //Gestión de Riesgos
            if (componente=="GR" || componente=="GR#"){
            $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/semaforo.png" /></div><span>Aprendamos todo sobre la seguridad vial</span></a></div>\
                                    ');
             $("#Lact").append('<ul class="1 acts">\
                                    <li><a href="actividadesComunes/visorLibros.html?libro=LibroSegurVial&paginas=25&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Seguridad vial</a></li>\
                                    <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=el_semaforo.mp4"><img src="images/empty.gif" />Mira y aprende: El semáforo</a></li>\
                                    <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=semaforo_peatones.mp4"><img src="images/empty.gif" />Mira y aprende: El semáforo de peatones</a></li>\
                                    <li><a href="http://www.educacionvial.cl/consejos-a-peatones.html"><img src="images/empty.gif" />Mira y aprende: seguridad vial <small>(Requiere Internet)</small></a></li>\
                                    <li><a href="actividadesComunes/escribeReflexion.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=consejos_peatones"><img src="images/empty.gif" />Reflexiona y escribe: Consejo para peatones</a></li>\
                                    <li><a href="http://www.educacionvial.cl/transporte-escolar-seguro.php"><img src="images/empty.gif" />Mira y aprende: transporte escolar <small>(Requiere Internet)</small></a></li>\
                                    <li><a href="actividadesComunes/escribeReflexion.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=deberes_escolar"><img src="images/empty.gif" />Reflexiona y escribe: Deberes en transporte público</a></li>\
                                    <li><a href="http://www.educacionvial.cl/juegos.html"><img src="images/empty.gif" />Juegos de seguridad vial <small>(Requiere Internet)</small></a></li>\
                            </ul>\
                            ');
            }
            //Inundaciones
            if (componente=="I" || componente=="I#"){
            $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/mapas.png" /></div><span>Aprendamos acerca de las señales de tránsito</span></a></div>');
             $("#Lact").append('<ul class="1 acts">\
                                    <li><a href="http://www.educacionvial.cl/senales-de-transito.html"><img src="images/empty.gif" />Mira y aprende: señales de tránsito <small>(Requiere Internet)</small></a></li>\
                                    <li><a href="actividadesComunes/escribeReflexion.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=senales_patrullero_escolar"><img src="images/empty.gif" />Reflexiona y escribe: Señales del patrullero escolar</a></li>\
                                    <li><a href="http://www.rena.edu.ve/SegundaEtapa/ciudadania/PATRULLA.html"><img src="images/empty.gif" />Mira y aprende: Patrulla escolar <small>(Requiere Internet)</small></a></li>\
                                    <li><a href="actividadesComunes/escribeReflexion.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=importancia_patrullero"><img src="images/empty.gif" />Reflexiona y escribe: Importancia del patrullero</a></li>\
                                </ul>');
            }
            break;

        //Se coloca de forma opcional ya que Sociales es sólo para 6to
        case '5':
            break;
    }

}// end of - SOCIALES




/**---------------------------------------------------------------------
 *  ---------                D E P O R T E S      ----------------------
 * ---------------------------------------------------------------------
 */

/**********************************************
* Listando contenidos de DEPORTES 5to - 6to   *
***********************************************/
else if (area == "Deportes"){
    switch(grado){
        case "5":
            //Gestión de Riesgos
            if (componente=="GR" || componente=="GR#"){
             $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/edificio_icon.png" /></div><span>Aprendamos sobre las instituciones públicas  que prestan servicios de protección y seguridad</span></a></div>\n\
                                    <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/mapas.png" /></div><span>Elabora los mapas de riesgo de tu escuela y comunidad</span></a></div>');
             $("#Lact").append('<ul class="1 acts">\
                                    <li><a href="actividadesComunes/visorLibros.html?libro=LibroInstituPublicas&paginas=22&ancho=600&largo=300"><img src="images/empty.gif" />Lee y aprende: Instituciones públicas</a></li>\
                                    <li><a href="actividadesComunes/mapaMental.html?numero=5"><img src="images/empty.gif" />Mapa mental: Personas que nos pueden ayudar</a></li>\
                                    <li><a href="actividadesComunes/mapas.html?tipo=1&enunciado=1"><img src="images/empty.gif" />Ubica la ruta de evacuaci&oacute;n de tu escuela</a></li>\
                            </ul>\n\
                            <ul class="2 acts">\
                                <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=simulacro_desalojo.mp4"><img src="images/empty.gif" />Mira y aprende: Simulacro de desalojo</a></li>\
                                <li><a href="actividadesComunes/mapas.html?tipo=2&enunciado=2"><img src="images/empty.gif" />Dibuja el mapa de riesgo de tu comunidad</a></li>\
                            </ul>');
            }
            //Inundaciones
            if (componente=="I" || componente=="I#"){
                $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/globo_tierra.ico" /></div><span>¿Qué debemos hacer antes, durante y después de un sismo?</span></a></div>\
                                       <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/inundaciones.png" /></div><span>¿Qué debemos hacer antes, durante y después de una inundación?</span></a></div>\
                    ');
                $("#Lact").append('<ul class="1 acts">\
                                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=recomendacion_sismos.mp4"><img src="images/empty.gif" />Mira y aprende</a></li>\
                                        <li><a href="actividadesComunes/miraydescribe.html?&componente=Sismos"><img src="images/empty.gif" />Mira y escribe</a></li>\
                                        <li><a href="actividadesComunes/miradescribe.html?numero=8&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                                    </ul>\
                                    \
                                    <ul class = "2 acts">\
                                        <li><a href="actividadesComunes/miradescribe.html?numero=10&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=inundacion_antes.ogv"><img src="images/empty.gif" />Mira y aprende: Antes de una inundacion</a></li>\
                                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=inundacion_durante.ogv"><img src="images/empty.gif" />Mira y aprende: Durante de una inundacion</a></li>\
                                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=inundacion_despues.ogv"><img src="images/empty.gif" />Mira y aprende: Después de una inundacion</a></li>\
                                    </ul>'
                        );
                }//end of - inundaciones
            break;
        
        case "6":
            //Gestión de Riesgos
            if (componente=="GR" || componente=="GR#"){
             $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/edificio_icon.png" /></div><span>Aprendamos sobre las instituciones públicas  que prestan servicios de protección y seguridad</span></a></div>\n\
                                    <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/mapas.png" /></div><span>Elabora los mapas de riesgo de tu escuela y comunidad</span></a></div>');
             $("#Lact").append('<ul class="1 acts">\
                                    <li><a href=""><img src="images/empty.gif" />Lee y aprende (falta)</a></li>\
                                    <li><a href="actividadesComunes/mapaMental.html?numero=5"><img src="images/empty.gif" />Mapa mental: Personas que nos pueden ayudar</a></li>\
                            </ul>\n\
                            <ul class="2 acts">\
                                <li><a href="actividadesComunes/mapas.html?tipo=1&enunciado=1"><img src="images/empty.gif" />Ubica la ruta de evacuaci&oacute;n de tu escuela</a></li>\
                                <li><a href="actividadesComunes/mapas.html?tipo=2&enunciado=2"><img src="images/empty.gif" />Dibuja el mapa de riesgo de tu comunidad</a></li>\
                            </ul>');
            }
            //Inundaciones
            if (componente=="I" || componente=="I#"){
                $("#acordeon").append('<div><a href="#" class="item" id ="1"><div class="icon"><img src="images/globo_tierra.ico" /></div><span>¿Qué debemos hacer antes, durante y después de un sismo?</span></a></div>\
                                       <div><a href="#" class="item" id ="2"><div class="icon"><img src="images/inundaciones.png" /></div><span>¿Qué debemos hacer antes, durante y después de una inundación?</span></a></div>\
                    ');
                $("#Lact").append('<ul class="1 acts">\
                                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=recomendacion_sismos.mp4"><img src="images/empty.gif" />Mira y aprende</a></li>\
                                        <li><a href="actividadesComunes/miraydescribe.html?&componente=Sismos"><img src="images/empty.gif" />Mira y escribe</a></li>\
                                        <li><a href="actividadesComunes/miradescribe.html?numero=8&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                                    </ul>\
                                    \
                                    <ul class = "2 acts">\
                                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=inundacion_antes.ogv"><img src="images/empty.gif" />Mira y aprende: Antes de una inundacion</a></li>\
                                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=inundacion_durante.ogv"><img src="images/empty.gif" />Mira y aprende: Durante de una inundacion</a></li>\
                                        <li><a href="actividadesComunes/visorVideos.html?grado='+grado+'&area='+area+'&componente='+componente+'&nombre_video=inundacion_despues.ogv"><img src="images/empty.gif" />Mira y aprende: Después de una inundacion</a></li>\
                                        <li><a href="actividadesComunes/miradescribe.html?numero=10&nombre=Mira_y_describe"><img src="images/empty.gif" />Mira y describe</a></li>\
                                        <li><a href="actividadesComunes/escribeReflexion.html?grado='+grado+'&area='+area+'&componente='+componente+'&contenido=que_hacer_inun"><img src="images/empty.gif" />Reflexiona y escribe: Inundaciones en tu escuela</a></li>\
                                    </ul>'
                        );
                }//end of - inundaciones
            break;

    }

}// end of - DEPORTES

}
