var grado = getUrlVars()["grado"];
var area = getUrlVars()["area"];
var componente = getUrlVars()["componente"];
var contenido = getUrlVars()["contenido"];

if (contenido != undefined)
	prefix = "../../../";
else
	prefix = "";

	//Menu superior
	$("#nav").append("<div class='act'><a href='"+prefix+"index.html'>Grados </div></a>\
					  <div class='Actsig'> > </div>");
	if (grado != undefined ){
			if (grado == "5"){
				$("body").css("background-color", "#c0ffef");
				img = 'images/quinto.png';
			}
			else{
				$("body").css("background-color", "#fad8a8");
				img = 'images/sexto.png';
			}
		}
	if (area == undefined){
		$("#nav").append("<div class='act'><a href='"+prefix+"grados.html?grado="+grado+"' class='current'>"+grado+"&deg; Grado</a></div>");
		//Menu circular
		
		if (grado == "6"){
		
		$("#myRoundabout").append("<li><a href='areas.html?grado="+grado+"&area=Lenguaje'><img src='images/lenguaje.png' alt=''></a></li>\
								  <li><a href='areas.html?grado="+grado+"&area=Sociales'><img src='images/csSociales.png' alt=''></a></li>\
							 <li><a href='areas.html?grado="+grado+"&area=Ciencias'><img src='images/matematicas.png' alt=''></a></li>\
							 <li><a href='areas.html?grado="+grado+"&area=Deportes'><img src='images/deportes.png' alt=''></a></li>");

		//Menu Auxiliar Inferior
		$("#areaslinks").append("<a href='areas.html?grado="+grado+"&area=Lenguaje'>Lenguaje, Comunicaci&oacute;n y Cultura</a>\
								&nbsp;-&nbsp;<a href='areas.html?grado="+grado+"&area=Sociales'>Ciencias Sociales, Ciudan&iacute;a e Identidad</a>&nbsp;-&nbsp;<br>\
								<a href='areas.html?grado="+grado+"&area=Ciencias'>Matem&aacute;ticas, Ciencias Naturales y Sociedad </a>&nbsp;-&nbsp;\
								<a href='areas.html?grado="+grado+"&area=Deportes'>Educaci&oacute;n F&iacute;sica, Deporte y Recreaci&oacute;n</a>\
								<br><br><a href='index.html'>< Atr&aacute;s</a>\
								<br><br><a href='creditos.html'>Conoce a Tatu H&uacute;</a>");
		
		}
		else{
			$("#myRoundabout").append("<li><a href='areas.html?grado="+grado+"&area=Lenguaje'><img src='images/lenguaje.png' alt=''></a></li>\
							 <li><a href='areas.html?grado="+grado+"&area=Ciencias'><img src='images/matematicas.png' alt=''></a></li>\
							 <li><a href='areas.html?grado="+grado+"&area=Deportes'><img src='images/deportes.png' alt=''></a></li>");

		//Menu Auxiliar Inferior
			$("#areaslinks").append("<a href='areas.html?grado="+grado+"&area=Lenguaje'>Lenguaje, Comunicaci&oacute;n y Cultura</a>\
								<a href='areas.html?grado="+grado+"&area=Ciencias'>Matem&aacute;ticas, Ciencias Naturales y Sociedad </a>&nbsp;-&nbsp;\
								<a href='areas.html?grado="+grado+"&area=Deportes'>Educaci&oacute;n F&iacute;sica, Deporte y Recreaci&oacute;n</a>\
								<br><br><a href='index.html'>< Atr&aacute;s</a>\
								<br><br><a href='creditos.html'>Conoce a Tatu H&uacute;</a>");
		}
	}
	else{
		//menu dock
		$('<li class="foo2"><a class="dockItem" href="'+prefix+'grados.html?grado='+grado+'"><img src="'+img+'" alt="Areas '+grado+'to" title="'+grado+'&deg; Grado" /></a></li>').insertAfter(".foo")
		
		$("#nav").append("<div class='act'><a href='"+prefix+"grados.html?grado="+grado+"'>"+grado+"&deg; Grado</a></div>");
		if (componente == undefined){
			//menu dock		
			$("#nav").append("<div class='Actsig'> > </div>\
							 <div class='act'><a href='"+prefix+"areas.html?grado="+grado+"&area="+area+"' class='current'>"+area+"</a></div>");
			//Menu Circular
			switch(area){
				case "Lenguaje":
					color="#ffcecf";
					gr = 'images/GRLen.png';
					i = 'images/InundLen.png';
				break;
				case "Sociales":
					color="#dfd8e9";
					gr = 'images/GRCS.png';
					i = 'images/InundCS.png';
				break;
				case "Ciencias":
					color="#d0fcbd";
					gr = 'images/GRMat.png';
					i = 'images/InundMat.png';
				break;
				case "Deportes":
					color="#b4ebff";
					gr = 'images/GRDep.png';
					i = 'images/InundDep.png';
				break;
				
			}
			$("body").css("background-color",color);
			$("#myRoundabout").append("<li><a href='componente.html?grado="+grado+"&area="+area+"&componente=GR'><img src='"+gr+"' alt=''></a></li>\
								      <li><a href='componente.html?grado="+grado+"&area="+area+"&componente=I'><img src='"+i+"' alt=''></a></li>");
		$("#areaslinks").append("<a href='componente.html?grado="+grado+"&area="+area+"&componente=GR'>Gesti&oacute;n de Riesgo</a>\
								&nbsp;-&nbsp;<a href='componente.html?grado="+grado+"&area="+area+"&componente=I'>Inundaciones</a><br>\
								<br><br><a href='componente.html?grado="+grado+">Atr&aacute;s</a>\
								<br><br><a href='creditos.html'>Conoce a Tatu H&uacute;</a>");
			
		}
		else if (contenido == undefined){
		$('<li class="foo3"><a class="dockItem" href="areas.html?grado='+grado+'&area='+area+'"><img src="images/componente.png" alt="Componentes '+area+'" title="Componentes" /></a></li>').insertAfter(".foo2")
			if (componente == "GR" || componente == "GR#")
				comp = "Gesti&oacute;n de Riesgos";
			if (componente == "I" || componente == "I#")
				comp = "Inundaciones";
			$("#nav").append("<div class='Actsig'> > </div>\
							 <div class='act'><a href='areas.html?grado="+grado+"&area="+area+"'>"+area+"</a></div>\
							 <div class='Actsig'> > </div>\
							 <div class='act'><a href='componente.html?grado="+grado+"&area="+area+"&componente="+componente+"' class='current'>"+comp+"</a></div>");
				$(document).ready(function(){
				$( "#fin" ).dialog({
				  height: 300,
				  width: 400,
				  modal: true,
				  autoOpen:true,
				  buttons: {
					"Cerrar": function() {
					  $( this ).dialog( "close" );
					}
				  }
				});
				});
		
		}
		

		
	}	
	
	//Listando menus para los contenidos
	if (contenido != undefined){
			
	}
	else{
		if ($('#myRoundabout').length){
			$('#myRoundabout').roundabout({
				autoplayDuration: 4000,
				autoplayPauseOnHover:true,
				btnNext:"#sig",
				btnPrev: "#ant"
			});
		}
	}
//Inicializacion menu dock
		$(function(){
			var jqDockOpts = {align: 'left', labels: 'tc', size:50};
			$('#jqDock').jqDock(jqDockOpts);
		});