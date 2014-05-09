var cant = 1;
function nombresSecc(elem){ //Verifica en la BD nombres de secciones que aun no se han usado
    id = $(elem).attr("id");
    id = id.split("_")[1];
    if ($(elem).val() !== "" && $("#idE_"+id).val() !== ""){
        $("#cargandoInfo").show();
      $.get("procesos/nombresSecciones_disp.php", { id_grad:$(elem).val(), id_ins:$("#idE_"+id).val()  })
                .done(function(data) {
            $("#cargandoInfo").hide();
                if (data !== "0"){
                    $("#nombreSecc_"+id).html("<select class=\"select\" name=\""+id+"[]\" id=\"idS_"+id+"\">"+data+"</select>");
                    $("#nombreSecc_"+id).removeClass("disabled");
                }
       });
   }
   else if($(elem).val() === "") $("#nombreSecc_"+id).html("<select class=\"select disabled\"></select>");
}

function agregarSeccion(){  //agregar campos para nuevas secciones dinamicamente
if (window.cant< 3){
  $("#maxSecc").html("");
  $("#maxSecc").hide();
    var id = parseInt($("#secciones li").last().attr("id")) + 1;
    $("#indices").val($("#indices").val() + id + ",");
    var Nelem = '<li id="'+id+'" class="lista">\n\
                Escuela<span class="obligatorio">*</span>: <select id="idE_'+id+'" class="select expandable-list" name="'+id+'[]" style="max-width:80px;" onChange="activarGrados(this)">'+window.escuelas+'</select> \n\
                  Grado<span class="obligatorio">*</span>: \n\
                <span id="nombreGrad_'+id+'"> <select class="select disabled"></select></span>\n\
                Nombre de la Secci&oacute;n<span class="obligatorio">*</span>: <span id="nombreSecc_'+id+'">\n\
                <select class="select disabled"></select></span>\n\
                <div id="erase" class="button-group absolute-right compact show-on-parent-hover">\n\
                <a onClick="eliminarSeccion(this)"class="button icon-trash with-tooltip confirm" title="Eliminar Secci&oacute;n" style="cursor:pointer;"></a>\n\
                </div></li>';
    $("#secciones").append(Nelem);
    
    window.cant++;
}
else{
  $("#maxSecc").html('<span class="block-arrow"><span></span></span>Cada docente puede tener hasta un m&aacute;ximo de 3 secciones');
  $("#maxSecc").fadeIn('slow');
}
}

function eliminarSeccion(elem){ //Elimina una seccion en el formulario dinamico
    $(elem).parent().parent("li").remove();
    $("#indices").val($("#indices").val().replace($(elem).parent().parent("li").attr("id")+",",""));
    window.cant--;
    $("#maxSecc").fadeOut();
}

function limpiarSecciones(){ //restablece el formulario dinamico de secciones
    window.cant = 1;
var content = '<h3 class="relative thin underline" style="text-align:left;">Secciones (M&aacute;ximo 3 secciones) \n\
        <span class="info-spot">\n\
            <span class="icon-info-round"></span>\n\
            <span class="info-bubble">\n\
                A continuaci&oacute;n puede agregar la o las secciones que manejar&aacute; el docente\n\
            </span></span>\n\
            <span class="button-group absolute-right">\n\
            <a title="Agregar seccion" id="add" onClick="javascript:agregarSeccion()" class="button icon-plus-round" style="cursor:pointer;">Agregar Secci&oacute;n</a>\n\
            </span></h3>\n\
            <p id="maxSecc" class="message red-gradient" style="display:none;"></p><input type="text" id="indices" name="indices" value="1," style="display:none;">\n\
        <ul class="list spaced" id="secciones" style="text-align:left; max-width:600px;">\n\
           <li id="1" class="lista">\n\
            Escuela<span class="obligatorio">*</span>: \n\
           <select class="select expandable-list" name="1[]" style="max-width:80px;" id="idE_1" onChange="activarGrados(this)">'+window.escuelas+'</select> \n\
            Grado<span class="obligatorio">*</span>: \n\
             <span id="nombreGrad_1"><select class="select disabled"></select></span>\n\
             Nombre de la Secci&oacute;n<span class="obligatorio">*</span>:\n\
             <span id="nombreSecc_1"><select class="select disabled"></select></span>\n\
             </li></ul>';
    $("#seccionesProf").html(content);
}

function activarGrados(elem){ //habilita el select de grados 
    id = $(elem).attr("id").split("_")[1];
    if ($(elem).val()!=="") $("#nombreGrad_"+id).html('<select class="select" name="'+id+'[]"  onChange="nombresSecc(this)" id="idG_'+id+'"><option></option>'+window.grados+'</select>');
    else{
         $("#nombreGrad_"+id).html('<select class="select disabled"></select>');
         $("#nombreSecc_"+id).html('<select class="select disabled"></select>');
    }
}

function seccionesEscuela(idEsc){
    $("#cargandoInfo").show();
$.get('procesos/secciones_escuela.php', { colegio: idEsc}).done(function(data) {
    $("#cargandoInfo").hide();
  if (data !== '0') $('#lista_grados').html(data);
});
}

$(document).ready(function() {
$("#fnac_id").mask("99/99/9999");
$("#cedula_id").mask("9999999?9");
$("#tlf_id").mask("9999-9999999");

$("#formulario").validate({ //reglas de validacion del formulario - jquery validate
rules:{
        nombre: { required:true,nombre_apellido: true},
        apellido: { required:true,nombre_apellido: true},
        cedula: {required:true,cedula: true},
        fecha_nacimiento:{required:true,fecha:true},
        telefono:{telefono:true},
        correo:{email:true},
        usuario:{usuario: true, required:true}
},
messages:{
        nombre: {
                required: "Debe ingresar un nombre",
                nombre_apellido: "Nombre incorrecto"
        },
        apellido: {
                required: "Debe ingresar un apellido",
                nombre_apellido: "Apellido incorrecto"
        },
        cedula: {
                required: "Debe ingresar la c&eacute;dula",
                cedula: "C&eacute;dula incorrecta"
        },
        fecha_nacimiento:{
                fecha: "Fecha Incorrecta",
                required: "Debe ingresar la fecha de nacimiento"
        },
        telefono:{
                telefono: "N&uacute;mero de Tel&eacute;fono incorrecto"
        },
        correo:{email: "Correo electr&oacute;nico incorrecto"},
        usuario:{
                required: "Debe ingresar un nombre de usuario",
                usuario: "Nombre de usuario incorrecto. Debe tener s&oacute;lo n&uacute;meros y letras, no contener espacios y tener de 8 a 15 caracteres"
        }
},
errorPlacement: 
        function(error, element) {
                error.appendTo("#error-" + element.attr("name"));
        },
submitHandler: function(){
var error = false;
var inc = false;
var Nsecc=1;
if ($("#tipo_id").val() === ""){//Validaciones adicionales que no hace jquery validate
    $("#error-tipo").html("Seleccione el tipo de usuario");
    $("#error-tipo").show();
    $(window).scrollTop($('#error-tipo').position().top);
    error = true;
}
else{
    $("#error-tipo").html("");
    $("#error-tipo").hide();
    if ($("#tipo_id").val() === "ADMINISTRADOR DE ESCUELA" || //validacion de escuela
        $("#tipo_id").val() === "ESTUDIANTE"){
        if($("#escuelaE").val() === ""){
            $("#error-escuela").html("Seleccione la escuela a la que pertenece el usuario");
            $("#error-escuela").show();
            $(window).scrollTop($('#error-escuela').position().top);
            error=true;
        }
        else{
            $("#error-escuela").hide();
            $("#maxSecc").hide();
        }
    }
    else if($("#tipo_id").val() === "PROFESOR"){
    $("ul#secciones li").each(function(){ //Datos completos
        if ($(this).find("span select:eq(0)").val() === "" || $(this).find("span select:eq(1)").val() === "" || $(this).find("span select:eq(2)").val() === "" ||
            $(this).find("span select:eq(0)").val() === null || $(this).find("span select:eq(1)").val() === null || $(this).find("span select:eq(2)").val() === null){
            if ($(this).find(".errorSecc").length === 0) {
               $(this).append("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
            }
            $("#maxSecc").html("<span class=\"block-arrow\"><span></span></span>Seleccione el grado y el nombre para la secci&oacute;n");
            $("#maxSecc").fadeIn('slow');
            inc = true;
            error=true;
        }
        else{ //que los nombres de las secciones de una misma escuela y grado no sean iguales
            $(".errorSecc",this).remove(); 
            var auxE=$(this).find("span select:eq(0)").val(),auxG=$(this).find("span select:eq(1)").val(),auxS=$(this).find("span select:eq(2)").val();
            var idS = $(this).attr("id");
            $(".lista").each(function(){
               if ($(this).attr("id") !== idS){
                  if ($(this).find("span select:eq(0)").val() === auxE && 
                        $(this).find("span select:eq(1)").val() === auxG &&
                        $(this).find("span select:eq(2)").val() === auxS){
                            error=true;
                            $("#maxSecc").html("<span class=\"block-arrow\"><span></span></span>Los grados de una misma escuela no pueden tener el mismo nombre de secci&oacute;n");
                            $("#maxSecc").fadeIn('slow');
                            inc = true;
                            if ($(this).find(".errorSecc").length === 0) 
                                $(this).append("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
                            if ($("#"+idS).find(".errorSecc").length === 0) 
                                $("#"+idS).append("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
                    }
               }
            });
        }
        Nsecc++;
     });
     if (!inc){
            $("#maxSecc").html("");
            $("#maxSecc").fadeOut('slow');
            $(".errorSecc").remove();
     }
    }
    if(!error){
        $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando Usuario, por favor espere...</h4>' });
         $.ajax({
            type: "POST",
            url: "post/nuevoUsuario.php",
            data: $("form").serialize(),
            success: function(data){
                $.unblockUI();
                if(data.indexOf("<img src=\"../plantilla/img/standard/error.png\" alt=\"Error\">") !== -1){
                $.modal({
                    content: data,
                    title: "",
                    width: 500,
                    scrolling: false,
                    actions: {
                            "Cerrar" : {color: "red",click: function(win) { win.closeModal();}}
                    },
                    buttons: {
                            "Cerrar": {
                                    classes:	"huge blue-gradient glossy",
                                    click:	function(win) { win.closeModal(); }
                            }
                    },
                    buttonsLowPadding: true
                });
              }
              else{
                 $.modal({
                    content: data,
                    title: "",
                    width: 500,
                    scrolling: false,
                    actions: {
                            "Cerrar" : {color: "red",click: function(win) { win.closeModal(); location.reload(); }}
                    },
                    buttons: {
                            "Cerrar": {
                                    classes:	"huge blue-gradient glossy",
                                    click:		function(win) { win.closeModal(); location.reload();}
                            },
                            "Imprimir Informaci&oacute;n": {
                                    classes:	"huge blue-gradient glossy",
                                    click:    function(win){ 
                                        var ventimp = window.open(' ', 'popimpr'); 
                                        ventimp.document.write( data);
                                        ventimp.document.close(); 
                                        ventimp.print( ); 
                                        ventimp.close(); 
                                    }
                            }
                    },
                    buttonsLowPadding: true
                });
              }
            }
        });
    }
    return false;
}
}
});

$('#escuelaE').change(function(){ //Carga dinamica de secciones segun la escuela y de formulario de secciones si es profesor
var e = $(this).val();
$("#seccionesProf").hide();  
if (e !== ''){
    $("#error-escuela").hide();
    if ($("#tipo_id").val() === "PROFESOR"){limpiarSecciones(); $("#seccionesProf").show();}
    if($("#tipo_id").val() === "ESTUDIANTE") seccionesEscuela(e);
}
else{
     if ($("#tipo_id").val() === "PROFESOR"){$("#seccionesProf").hide();}
     if($("#tipo_id").val() === "ESTUDIANTE") { $("#lista_grados").html('<select name="grado" class="select" id="gradoE" disabled></select>'); }
}
});

$("#tipo_id").change(function() { //cambio dinamico del area Datos Educativos segun usuario
var val = $(this).val();
$("#error-escuela").hide();
if(val === ""){$("#datos-educativos").hide();}
else{
    $("#error-tipo").html("");
    $("#error-tipo").hide();
    if(val === "ESTUDIANTE") {    //Estudiante
        $("#datos-educativos").show();
        $("#escuela").show();
        $("#gradosE").show();
        $("#seccionesProf").hide();
        if ($("#escuelaE").val()!== "") seccionesEscuela($("#escuelaE").val());
    }
    else if (val === "PROFESOR") {   //Docente
      limpiarSecciones();
      $("#datos-educativos").show();
      $("#escuela").hide();
      $("#seccionesProf").show();
    }
    else if (val=== "ADMINISTRADOR DE ESCUELA") {  //Administrador de Escuela
      $("#datos-educativos").show();
      $("#escuela").show();
      $("#lista_grados").html('<select name="grado" class="select" id="gradoE" disabled></select>');
      $("#gradosE").hide();
      $("#seccionesProf").hide();
    }
    else if (val === "ADMINISTRADOR"){   //Administrador de Sistema
        $("#datos-educativos").hide();
    }
}
});

$('#nick').focusout(function(){   //Verifica que un nombre de usuario no este en la BD
reg = /^([a-z0-9]{8,15})$/i;
if($(this).val()!== "" && reg.test($(this).val())){
  $('#error-usuario div').html("");
  $('#error-usuario').html("<img src=\"../plantilla/img/standard/loaders/loading16.gif\" alt=\"cargando\"> Verificando disponibilidad, por favor espere.</div>");
  $.get('procesos/checkNick.php', { nick: $(this).val()}).done(function(data) {
        if (data === '0'){
          $('#error-usuario').html("<div style='color:red;'>Nombre de usuario no disponible</div>");
          $('#nick').val('');
        }
        else if (data === '1')
            $('#error-usuario').html("<div style='color:green;'>Nombre Disponible</div>");
        else
            $('#error-usuario').html("Error al enviar los datos, recargue la p&aacute;gina");
  });
}
});

$('#cedula_id').focusout(function(){ //Verifica que la cedula no exista en la BD
if($(this).val()!== ""){
    $('#error-cedula div').html("");
    var val = $(this).val().split("_").join("");
    if (val !== ""){
       $('#error-cedula').html("<img src=\"../plantilla/img/standard/loaders/loading16.gif\" alt=\"cargando\"> Verificando disponibilidad, por favor espere.</div>");
       $.get('procesos/checkCI.php', { cedula: val}).done(function(data) {
            if (data === '0'){
              $('#error-cedula').html("<div style='color:red;'>La c&eacute;dula ya est&aacute; registrada en el sistema</div>");
              $('#cedula_id').val('');
            }
            else if (data === '1')
            $('#error-cedula').html("<div style='color:green;'>C&eacute;dula disponible</div>");
            else
            $('#error-cedula').html("Error al enviar los datos, recargue la p&aacute;gina");
        });
     }
}
});
});