$(document).ready(function() {
/* Inicializaciones */
// Galeria de Imagenes
$('#myRoundabout').roundabout({
	shape: 'figure8',
	minOpacity: 1,
	autoplay:true,
	autoplayDuration: 4000,
	autoplayPauseOnHover:true
});

//Menu
/*var marginO = 0;
function makeTall(){
	marginO = $(this).css("margin-top");
	var marginN = parseInt(marginO) + 3;
	$(this).animate({"margin-top":marginN},100);
}
function makeShort(){ $(this).animate({"margin-top": parseInt(marginO)},100);}
$("#headerNormal nav ul li").hoverIntent(makeTall, makeShort);*/
		
//Pestania de creditos
$("#pestania").click(function(){
	if ($("#contacto").css("width")=="40px")
		$("#contacto").animate({width: "400"},1500);				
	else
		$("#contacto").animate({width:"40"},1500);	
});

//Login
        $( "#loginCuadro" ).dialog({
		height: 365,
                width: 500,
                modal: true,
                autoOpen:false,
		resizable:false
	});
$("#login").click(function(e){
	e.preventDefault();
	$("#loginCuadro").dialog("open");
		     	
});
});
