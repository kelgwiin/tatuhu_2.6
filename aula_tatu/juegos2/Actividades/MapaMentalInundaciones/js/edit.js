function jsplumb_edit_init() {
  jsPlumb.Defaults.MaxConnections = -1;
  jsPlumb.Defaults.ConnectionOverlays = [
    ["Label", { id: "label" }]
  ];
  $(".ep").each(function (i, e) {
    var p = $(e).parent();
    jsPlumb.makeSource($(e), {
      parent: p
    });
  });
}

function connect_nodes(source, target, label){
var array_colores = ["rgb(17,81,243)",
					 "rgb(13,203,171)",
					 "rgb(245,49,144)",
					 "rgb(255,151,38)",
					 "rgb(0,255,226)",
					 "rgb(40,198,1)"]; //Array de colores para las conexiones

var color = Math.floor(Math.random() * 5);
var tipo_conexion = Nnodo % 2==0?"Dot":"Rectangle";

var endStyle = tipo_conexion === "Dot"?{ radius:20 }: { fwidth:25, height:25 }
Math.random();
jsPlumb.connect({
  	source:source,
  	target:target,
	paintStyle:{lineWidth:8,strokeStyle:array_colores[color]},
	connector: "StateMachine",
	endpoint:[ tipo_conexion, endStyle],
	endpointStyle:{ fillStyle: array_colores[color]},
	connectorOverlays:[ 
		[ "Label", { label:"foo", id:"label" } ]
	],

  }).setLabel(label);

}

$(function () {
		$( ".dialog" ).dialog({
			autoOpen: false,			
			modal: true,
			resizable:false,
			show: "blind",
			buttons: {
				"Agregar mi nube": function() {
				var vacio = true;
				var conexion = "";
					if (Nnodo == 1){ //respuestas del primer cuadro
						var select = $("#dialog1 select option:selected").val();
						if (select == null){
							$("#dialog1 .error").text("Amiguito intenta responder");
							$("#dialog1 .error").show();
						}
						else{
							if (select == 1){
								vacio = false;
								conexion = "Tipos";
							}
							else{
								$("#dialog1 .error").text("La respuesta es incorrecta");
								$("#dialog1 .error").show();
							}
						}
					}
					else if(Nnodo == 2){ //respuestas del segundo cuadro
						var check = $("#dialog2 input[type='checkbox']:checked").length;
						if (check <= 0){
							$("#dialog2 .error").text("Amiguito intenta responder");
							$("#dialog2 .error").show();
						}
						else{
							var invalidos = 0;
							var validos = 0;
							$("input[type='checkbox']:checked").each(function(){
								if ($(this).val() == "0"){
									invalidos++;
								}
								else{
									validos++;
								}
							});
							if (validos == 3 && invalidos == 0){
								vacio = false;
								conexion = "Consecuencias";
							}
							else if (invalidos > 0 ){
								$("#dialog2 .error").text("Hay respuestas que son incorrectas, verifica");
								$("#dialog2 .error").show();
							}
						}
					}
					else if(Nnodo == 3){ //respuestas del tercer cuadro
						var check = $("#dialog3 input[type='checkbox']:checked").length;
						if (check <= 0){
							$("#dialog3 .error").text("Amiguito intenta responder");
							$("#dialog3 .error").show();
						}
						else{
							var invalidos = 0;
							var validos = 0;
							$("#dialog3 input[type='checkbox']:checked").each(function(){
								if ($(this).val() == "0"){
									invalidos++;
								}
								else{
									validos++;
								}
							});
							console.log(validos)

							if (validos == 3 && invalidos == 0){
								vacio = false;
								conexion = "Producidas por";
								$("#create_node").hide();
								$("#save_node").show();
								
								
							}
							else if (invalidos > 0 ){
								$("#dialog3 .error").text("Hay respuestas que son incorrectas, verifica");
								$("#dialog3 .error").show();
							}
						}
					}
					//dibujado de la nube
					if ( !vacio){
					  Nnodo++;
					  console.log("aqui")
					  var act = $("#node"+Nnodo);
					  $("#demo").append(act);
					  $("#node"+Nnodo).show();
					  connect_nodes("node1", "node"+Nnodo, "");
					  $( this ).dialog( "close" );
					}
				},
				"Cancelar": function() {
					$( this ).dialog( "close" );
				}
			}
		});

		$( "#create_node" ).click(function(event) {
			event.preventDefault();
			$( "#dialog"+Nnodo ).dialog( "open" );
			return false;
		});
  jsplumb_edit_init();
});
