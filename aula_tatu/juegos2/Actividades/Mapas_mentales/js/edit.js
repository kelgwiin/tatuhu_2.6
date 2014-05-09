function init_funciones_nodo(){
  $(".remove_node").bind('click', function () {
    var confirm_remove = confirm("¿Quieres borrar este nodo?");
    if ( confirm_remove === true ){ 
      $(this).parent().fadeOut(300, function() { $(this).remove() });
    }
  });

  $(".update_node").bind('click', function () {
    var node_name = prompt("¿Nombre del nodo?", "");
    if ( !(node_name === null)){ 
      $(this).parent().children('.node_name').replaceWith(node_name);
    }
  });
}

function jsplumb_edit_init() {

  jsPlumb.Defaults.MaxConnections = -1;

  jsPlumb.Defaults.ConnectionOverlays = [
    ["Arrow", { location: 1, id: "arrow", length: 14, foldback: 0.8 }],
    ["Label", { id: "label" }]
  ];

  jsPlumb.draggable($(".node"));
  jsPlumb.setDraggable("node1", false);

  $(".ep").each(function (i, e) {
    var p = $(e).parent();
    jsPlumb.makeSource($(e), {
      parent: p
    });
  });

  jsPlumb.makeTarget($(".node"), {
    dropOptions: { hoverClass: "dragHover" },
    endpoint: { anchor: "Continuous" }
  });
  init_funciones_nodo();
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

var endStyle = tipo_conexion === "Dot"?{ radius:30 }: { fwidth:30, height:30 }
Math.random();
jsPlumb.connect({
  	source:source,
  	target:target,
	paintStyle:{lineWidth:8,strokeStyle:array_colores[color]},
	connector: "StateMachine",
	endpoint:[ tipo_conexion, endStyle],
	endpointStyle:{ fillStyle: array_colores[color]},
	connectorOverlays:[ 
		[ "connectorOverlays", { width:10, length:30, location:1, id:"arrow" } ], 
		[ "Label", { label:"foo", id:"label" } ]
	],

  }).setLabel(label);

}

$(function () {

  jsplumb_edit_init();

  $("#create_node").click(function () {
    var node_name = prompt("¿Nombre del nodo?", "");
    if ( !(node_name === null)){ 
		Nnodo++;
      $("#demo").append('<div class="node" id="node'+ Nnodo +'"><span class="node_name">' + node_name + '</span><br /><i class="icon-pencil update_node"></i><i class="icon-remove remove_node"></i></div>');
	  jsPlumb.draggable($("#node"+Nnodo));
	  connect_nodes("node1", "node"+Nnodo, "prueba");
	    $("#node"+Nnodo+" .remove_node").bind('click', function () {
			var confirm_remove = confirm("¿Quieres borrar este nodo?");
			if ( confirm_remove === true ){ 
			  $(this).parent().fadeOut(300, function() { $(this).remove() });
			}
		  });

		   $("#node"+Nnodo+" .update_node").bind('click', function () {
			var node_name = prompt("¿Nombre del nodo?", "");
			if ( !(node_name === null)){ 
			  $(this).parent().children('.node_name').replaceWith(node_name);
			}
		  });
	  
	  
	 }
  });
  
});
