$.fx.speeds._default = 1000;	
var cantPreg = 0;
function rep(){
        audios = document.getElementById('clic');
        audios.play();
}
function comprobar(e){
    var error1=false, error2=false,error3=false;
    var validos=0,invalidos=0;
    if (e.html().indexOf("select") > -1){
        var select = e.find("select option:selected").val();
        if (select == null){
            error1=true;
        }
        else{
            if (select == 1){
                    return false;
            }
            else{
                   error2=true;
            }
      }
    }
    else if (e.html().indexOf("checkbox") > -1){
        var cant = e.find("input[value='1']").length;
        if (e.find("input[type='checkbox']:checked").length == 0){
            error1= true;
        }
        else{
            e.find("input[type='checkbox']:checked").each(function(){
                     if ($(this).val() == "0")
                             invalidos++;
                     else
                             validos++;
             });
             if (validos === cant && invalidos === 0){
                     return false;
             }
             else if (invalidos > 0 ){
                    error2 = true;
             }
             else if (validos < cant){
                    error3 = true;
             }
        }
    }
    if(error1){
        e.find(".error").text("Debes responder a la pregunta para completar el mapa mental");
        e.find(".error").show();
        return true;
    }
    else if (error2){
        e.find(".error").text("La respuesta es incorrecta");
        e.find(".error").show();
        return true;
    }
    else if (error3){
        e.find(".error").text("Faltan respuestas por marcar");
        e.find(".error").show();
        return true;
    }
}

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
        connectorOverlays:[[ "Label", { label:"foo", id:"label" } ]]
    }).setLabel(label);
}

$(document).ready(function () {
cantPreg = $('body').find(".dialog").length;

    $( "#fin" ).dialog({
  height: 250,
  width: 400,
 /* modal: true,*/
  autoOpen:false,
  open: function(){rep();},
  buttons: {
    "Cerrar": function() {
      
	  $( this ).dialog( "close" );
	  
    },
    "Repetir": function(){ 
    $( this ).dialog( "close" );
    location.reload();
    }
  }
});

$( ".dialog" ).dialog({
autoOpen: false,			
modal: true,
resizable:false,
show: "blind",
width: 500,
position: top,
buttons: {
"Agregar mi nube": function() {
    var vacio = true;
    var conexion = "";
    vacio = comprobar($(this));
    //dibujado de la nube
    if ( !vacio){
        Nnodo++;
        var act = $("#node"+Nnodo);
        $("#demo").append(act);
        $("#node"+Nnodo).show();
        connect_nodes("node1", "node"+Nnodo, "");
        $( this ).dialog( "close" );
    }
    if(Nnodo-1 === cantPreg){
        $("#create_node").hide();
         $( "#fin" ).dialog( "open" );
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
