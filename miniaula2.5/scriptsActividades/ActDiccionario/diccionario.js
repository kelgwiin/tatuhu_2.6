	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 1000;	
	function rep(){
		audios = document.getElementById('clic');
		audios.play();
	}
	$(document).ready(function() {
		$( ".dialogo" ).dialog({
			width: 500,
			autoOpen: false,			
			modal: true,
			resizable:false,
			position:"top"
		});

		$( ".palabra" ).click(function(event) {
			 event.preventDefault();
			rep();
			var d = $(this).attr("title");
			$( "#"+d+"_dialog" ).dialog( "open" );
			return false;
		});
		var switchingOff = true;
		
        function makeTall(){$(this).animate({"margin-top": -15},200);}
        function makeShort(){$(this).animate({"margin-top": 0},200);}
		$(".palabras li").hoverIntent(makeTall, makeShort)
	});