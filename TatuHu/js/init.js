$(document).ready(function() {
/* Inicializaciones */
// Galeria de Imagenes
$('#myRoundabout').roundabout({
	/*shape: 'figure8',*/
	minOpacity: 1,
	autoplay:true,
	autoplayDuration: 4000,
	autoplayPauseOnHover:true,
	maxOpacity: 1
});
		
//Pestania de creditos
$("#pestania").click(function(){
	if ($("#contacto").css("width")=="40px")
		$("#contacto").animate({width: "400"},1500);				
	else
		$("#contacto").animate({width:"40"},1500);	
});

//Login
        $( "#loginCuadro" ).dialog({
			height: 450,
			width: 530,
            modal: true,
            autoOpen:false,
		    resizable:false
	});
$("#login").click(function(e){
	e.preventDefault();
	//reset del formulario de login
	$(".espacio").show();
	$("#user").val("");
	$("#password").val("");
	$("p.message").html("");
	$("p.message").hide();
	$("ul.inputs").css("margin-top","50px");
	$("li.usuario").css("border","");
	$("li.contra").css("border","");
	$("#loginCuadro").dialog("open");
});
});
