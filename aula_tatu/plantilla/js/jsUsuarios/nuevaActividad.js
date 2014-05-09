var cant = 4;
var errorArch = false, error=false;
var antVal = "",antId;
 
//validaciones segun tipo de actividad
function validar_palabras(cadena){
    //las palabras van separadas por "," o "#" asi que estos caracteres no se permiten
    var reg = /^([a-z √°√©√≠√≥√∫√±]{2,60})$/i;
    return reg.test(cadena);
}


var normalize = (function() {
  var from = "√¿¡ƒ¬»…À ÃÕœŒ“”÷‘Ÿ⁄‹€„‡·‰‚ËÈÎÍÏÌÔÓÚÛˆÙ˘˙¸˚—Ò«Á",
      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};
 
  for(var i = 0, j = from.length; i < j; i++ )
      mapping[ from.charAt( i ) ] = to.charAt( i );
 
  return function( str ) {
      var ret = [];
      for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
      }
      return ret.join( '' );
  }
 
})();

$("#formulario").validate({ //reglas de validacion del formulario - jquery validate
rules:{
       nombre_actividad: { required:true},
       retroalimentacion: {required:true},
       img1: {required:true,  extension: "png|jpg"},
       img2: {required:true,  extension: "png|jpg"},
       img3: {required:true,  extension: "png|jpg"}
},
messages:{
        nombre_actividad: { required: "Debe ingresar un nombre para la actividad"  },
        retroalimentacion: { required: "Debe ingresar un mensaje de retroalimentaci&oacute;n" },
        img1: {required: "Seleccione el archivo PNG", extension:"El tipo del archivo debe ser PNG"},
        img2: {required: "Seleccione el archivo PNG", extension:"El tipo del archivo debe ser PNG"},
        img3: {required: "Seleccione el archivo PNG", extension:"El tipo del archivo debe ser PNG"}
},
errorPlacement: 
        function(error, element) {
                error.appendTo("#error-" + element.attr("name"));
        },
submitHandler: function(){
var error = false;
if ($("#area").val() === "" || $("#area").length === 0){
     error = true;
     $("#error-area").html("<span style='color:red'>Seleccione el &aacute;rea de aprendizaje del componente</span>");
}
if ($("#componente").val() === "" || $("#componente").length === 0){
     error = true;
     $("#error-componente").html("<span style='color:red'>Seleccione el componente</span>");
}
if ($("#contenido").val() === "" || $("#contenido").length === 0){
    error = true;
    $("#error-tema").html("<span style='color:red'>Seleccione el tema</span>");
}
if ($("#tipo").val() === ""){
    error = true;
    $("#error-tipo").html("<span style='color:red'>Seleccione el tipo del material</span>");
}
//validando segun el tipo de actividad
var tipo = $("#tipo").val().split("-")[1];

if (tipo === "sopaletras"){
    $("#lista li").each(function(){
        antId = $(this).attr("id");
        antVal = $(this).find("input").val();
        if ($(this).find("input").val() === "" || !validar_palabras($(this).find("input").val())){
            error = true;
            if ($(this).find(".errorSecc").length === 0) {
               $(this).append("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
            }
        }
        else{
            if ($(this).find(".errorSecc").length !== 0) {
               $(this).find(".errorSecc").remove();
            }
            
             $("#lista li").each(function(){
                idAct = $(this).attr("id");
                if (idAct !== antId){
                    if ($(this).find("input").val() === antVal){
                        if ($("#"+idAct).find(".errorSecc").length === 0) {
                            $("#"+idAct).find("input").after("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
                            $("#maxTerm1").html('<span class="block-arrow"><span></span></span>No se permiten palabras iguales en la sopa de letras');
                            $("#maxTerm1").fadeIn('slow');
                            $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>No se permiten palabras iguales en la sopa de letras');
                            $("#maxTerm2").fadeIn('slow');
                            errorArch = true; 
                        }
                    }
                }
            });
        }
    });
    if (error){
         $("#maxTerm1").html('<span class="block-arrow"><span></span></span>Compruebe los campos obligatorios. Verifique que no contengan # (numerales) &oacute; , (comas)');
        $("#maxTerm1").fadeIn('slow');
        $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>Compruebe los campos obligatorios. Verifique que no contengan # (numerales) &oacute; , (comas)');
        $("#maxTerm2").fadeIn('slow');
    }
}
else if (tipo === "crucigrama" || tipo === "pareodepalabras"){
    $("#lista li").each(function(){
        antId = $(this).attr("id");
        antVal = $(this).find("input").val();
        if ($(this).find("input").val() === "" || $(this).find("textarea").val() === "" 
                || !validar_palabras($(this).find("textarea").val())){
            error = true;
            if ($(this).find(".errorSecc").length === 0) {
               $(this).find("textarea").after("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
            }
        }
        else{
            if ($(this).find(".errorSecc").length !== 0) {
               $(this).find(".errorSecc").remove();
            }
            $("#lista li").each(function(){
                idAct = $(this).attr("id");
                if (idAct !== antId){
                    if ($(this).find("input").val() === antVal){
                        if ($("#"+idAct).find(".errorSecc").length === 0) {
                            $("#"+idAct).find("input").after("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
                            $("#maxTerm1").html('<span class="block-arrow"><span></span></span>No se permiten palabras iguales');
                            $("#maxTerm1").fadeIn('slow');
                            $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>No se permiten palabras iguales');
                            $("#maxTerm2").fadeIn('slow');
                            errorArch = true; 
                        }
                    }
                }
            });
        }
    });
    if (error){
         $("#maxTerm1").html('<span class="block-arrow"><span></span></span>Compruebe los campos obligatorios');
        $("#maxTerm1").fadeIn('slow');
        $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>Compruebe los campos obligatorios');
        $("#maxTerm2").fadeIn('slow');
    }
}
else if (tipo === "pareo"){
     $("#lista li").each(function(){
         antId = $(this).attr("id");
         antVal = $(this).find("input.file").val();
        if ($(this).find("textarea").val() === "" || !validar_palabras($(this).find("textarea").val()) ){
            error = true;
            $("#maxTerm1").html('<span class="block-arrow"><span></span></span>Debe completar los campos obligatorios');
            $("#maxTerm1").fadeIn('slow');
            if($(this).find(".errorSecc").length === 0) {
               $(this).find("textarea").after("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
            }
        }
        else{
            if ($(this).find(".errorSecc").length !== 0) {
               $(this).find(".errorSecc").remove();
            }
            $("#lista li").each(function(){
                idAct = $(this).attr("id");
                if (idAct !== antId){
                    if ($(this).find("input.file").val() === antVal){
                        if ($("#"+idAct).find(".errorSecc").length === 0) {
                            $("#"+idAct).find("textarea").after("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
                            $("#"+antId).find("textarea").after("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
                            $("#maxTerm1").html('<span class="block-arrow"><span></span></span>Compruebe que los archivos no sean iguales');
                            $("#maxTerm1").fadeIn('slow');
                            $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>Compruebe que los archivos no sean iguales');
                            $("#maxTerm2").fadeIn('slow');
                            errorArch = true; 
                        }
                    }
                }
            });
        }
    });
}
if(!error && !errorArch){
$("#error-area").html("");
$("#error-componente").html("");
$("#error-tema").html("");
$("#error-tipo").html("");
$(".errorSecc").remove(); 
$("#maxTerm1, #maxTerm2").fadeOut();

//Carga del form en una variable data para enviarlo al post
var tipo = $("#tipo").val().split("-")[1];
var data = new FormData();

if(tipo === "sopaletras"){
    i = 0;
    $("#lista li").each(function(){
            var palabra = normalize($(this).find("input[type='text']").val());
            data.append('palabra'+i,palabra);
            i++;
    });
}
else if(tipo === "crucigrama" || tipo === "pareodepalabras"){
     i = 0;
     $("#lista li").each(function(){
        data.append('palabra'+i,$(this).find("input[type='text']").val());
        data.append('definicion'+i,$(this).find("textarea").val());
        i++;
    });
}
else if(tipo === "pareo"){
    var archivos = document.querySelectorAll("input.archivo"); //obtenemos todos los archivos
    for (i = 0; i<archivos.length; i++){
            var archivo = archivos[i].files;
            data.append('img'+i,archivo[0]);
    }
    i = 0;
    $("#lista li").each(function(){
        data.append('pista'+i,$(this).find("textarea").val());
        i++;
    });
}
//almacenamos el resto de los datos
data.append('nombre',$("#nombre_actividad").val());
data.append('retroalimentacion',$("#retroalimentacion").val());
data.append('tipo',$("#tipo").val());
data.append('area',$("#area").val());
data.append('componente',$("#componente").val());
data.append('contenido',$("#contenido").val());
data.append('indices',$("#indices").val());

$.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Creando Actividad, por favor espere...</h4>' });
$.ajax({
type: "POST",
url: "post/nuevaActividad.php",
contentType:false, //Debe estar en false para que pase el objeto sin procesar
    data:data, //Le pasamos el objeto que creamos con los archivos
    processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
    cache:false,
            success: function(data){
                $.unblockUI();
                if(data.indexOf("<img src='../plantilla/img/standard/error.png'>") !== -1){
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
                            }
                    },
                    buttonsLowPadding: true
                });
              }
            }
});
}
}
});

function agregarTermino(){
    if (window.cant < 6){
        var id = parseInt($("#lista li").last().attr("id")) + 1;
        $("#indices").val($("#indices").val() + id + ",");       
    var Nelem = '<li id="'+id+'" class="lista">\n\
        <table style="max-width:500px"><tr>\n\
        <td>\n\
        Palabra<span class="obligatorio">*</span>:<br><input type="text" name="'+id+'[]" id="idP_'+id+'" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
        </td><td>\n\
         Pista<span class="obligatorio">*</span>:<br> \n\
         <textarea class="input" name="'+id+'[]" id="idS_'+id+'" rows="2" cols="45" maxlength="300"></textarea></td>\n\
         <td></tr></table>\n\
         <div id="erase" class="button-group absolute-right compact">\n\
            <a onClick="eliminarTermino(this)"class="button icon-trash with-tooltip confirm" title="Eliminar Palabra" style="cursor:pointer;"></a>\n\
            <a onClick="agregarTermino(this)"class="button icon-plus with-tooltip confirm" title="Agregar Palabra" style="cursor:pointer;"></a>\n\
         </div>\n\
         </li>';
        $("#lista").append(Nelem);
        window.cant++; 
    }
    else{
        $("#maxTerm1").html('<span class="block-arrow"><span></span></span>El crucigrama permite hasta un m&aacute;ximo de 6 palabras');
        $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>El crucigrama permite hasta un m&aacute;ximo de 6 palabras');
        $("#maxTerm1, #maxTerm2").fadeIn('slow');
      }
}

function eliminarTermino(elem){
    $(elem).parent().parent("li").remove();
    $("#indices").val($("#indices").val().replace($(elem).parent().parent("li").attr("id")+",",""));
    window.cant--;
    $("#maxTerm1, #maxTerm2").fadeOut();
}

function agregarPagina(){
        if (window.cant < 14){
        var id = parseInt($("#lista li").last().attr("id")) + 1;
        $("#indices").val($("#indices").val() + id + ",");       
        var Nelem = '<li id="'+id+'" class="lista"><span style="text-align:left; font-weight: bold; padding-right: 15px;">Palabra:</span><span class="obligatorio">*</span>\n\
                        <input type="text" name="1[]" id="idI_'+id+'" value="" class="input withClearFunctions" maxlength="20" >\n\
                                 <div id="erase" class="button-group absolute-right compact">\n\
                                    <a onClick="eliminarTermino(this)"class="button icon-trash with-tooltip confirm" title="Eliminar Palabra" style="cursor:pointer;"></a>\n\
                                    <a onClick="agregarPagina(this)"class="button icon-plus with-tooltip confirm" title="Agregar Palabra" style="cursor:pointer;"></a>\n\
                                 </div>\n\
                      </li>';
        $("#lista").append(Nelem);
        window.cant++; 
    }
    else{
        $("#maxTerm1").html('<span class="block-arrow"><span></span></span>La sopa de letras permite hasta un m&aacute;ximo de 15 palabras');
        $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>La sopa de letras permite hasta un m&aacute;ximo de 15 palabras');
        $("#maxTerm1, #maxTerm2").fadeIn('slow');
      }
}

function max_actividades(e){
    $("#error-tema").html("");
    var id = $(e).val();
    if (id !== ""){
        $("#error-componente").html("");
        $("#error-tema").html("")
        $("#cargandoInfo").show();
        $.get('procesos/actividad_cant.php', { id: id}).done(function(data) {
            $("#cargandoInfo").hide();
            if(data ==="1"){
                $('#contTem').html("<span style='color:red'><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> Este tema tiene 10 actividades (Se permiten un m&aacute;ximo de 10 actividades por tema)</span>")
            }
            else if(data !="-1"){
                $('#contTem').html("<span style='color:red'><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> Error al enviar los datos, recargue la p&aacute;gina e intente nuevamente</span>")
            }
        });
        
    }
}

function temas_componente(e){
    $("#error-tema").html("");
    var id = $(e).val();
    if (id !== ""){
        $("#error-componente").html("");
        $("#cargandoInfo").show();
        $.get('procesos/temas_componente.php', { id: id}).done(function(data) {
            $("#cargandoInfo").hide();
            if (data !== '0'){
                $('#contTem').html(data);
                $('#contenido').attr('onChange','max_actividades(this)');
            }
            else if(data !=="-1"){
                $('#contTem').html("<span style='color:red'><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> El componente seleccionado no tiene temas</span>")
            }
            else{
                $('#contTem').html("<span style='color:red'><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> Error al enviar los datos, recargue la p&aacute;gina e intente nuevamente</span>")
            }
        });
    }
    else{
          $('#contTem').html('<span id="contComp"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="tema" id="tema" style="width:150px;"></select></span>');
    }
}

$(document).ready(function(){
    $("#area").change(function(){
        $('#contTem').html('<span id="contComp"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="tema" id="tema" style="width:150px;"></select></span>');
        var id = $(this).val();
        if (id !== ""){
            $("#error-area").html("");
            $("#error-componente").html("");
            $("#cargandoInfo").show();
            $.get('procesos/componentes_area.php', { id: id}).done(function(data) {
                $("#cargandoInfo").hide();
                if (data !== '0'){
                    $('#contComp').html(data);
                    $("#componente").attr('onChange','temas_componente(this)');
                }
                else if(data !=="-1"){
                    $('#contComp').html("<span style='color:red'><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> El &aacute;rea seleccionada no tiene componentes</span>")
                }
                else{
                    $('#contComp').html("<span style='color:red'><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> Error al enviar los datos, recargue la p&aacute;gina e intente nuevamente</span>")
                }
            });
        }
        else{
              $('#contComp').html('<span id="contComp"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="componente" id="componente" style="width:150px;"></select></span>');
        }
    });
    $("#tipo").change(function(){        
        $("#error-tipo").html("");
       var tipo = $(this).val().split("-")[1];
       if (tipo !== ""){
           window.cant = 2;
    if (tipo === "sopaletras"){
         $("#materialTipo").html('<h3 class="relative thin underline" style="text-align:left;">Palabras de la Sopa (M&aacute;ximo 15) \n\
                    <span class="button-group absolute-right">\n\
                    <a title="Agregar palabra" id="add" onClick="javascript:agregarPagina()" class="button icon-plus-round" style="cursor:pointer;">Agregar Palabra</a></span></h3>\n\
                    <p id="maxTerm1" class="message red-gradient" style="display:none;"></p>\n\
                    <input type="text" id="indices" name="indices" value="1,2," style="display:none;">\n\
                    <ul class="list spaced" id="lista" style="text-align:left; max-width:600px;">\n\
                        <li id="1" class="lista">\n\<span style="text-align:left; font-weight: bold; padding-right: 15px;">Palabra:</span><span class="obligatorio">*</span>\n\
                         <input type="text" name="1[]" id="idI_1" value="" class="input withClearFunctions" maxlength="20">\n\
                         </li>\n\
                        <li id="2" class="lista">\n\<span style="text-align:left; font-weight: bold; padding-right: 15px;">Palabra:</span><span class="obligatorio">*</span>\n\
                         <input type="text" name="1[]" id="idI_2" value="" class="input withClearFunctions" maxlength="20">\n\
                         </li>\n\
                        <li id="3" class="lista">\n\<span style="text-align:left; font-weight: bold; padding-right: 15px;">Palabra:</span><span class="obligatorio">*</span>\n\
                         <input type="text" name="1[]" id="idI_3" value="" class="input withClearFunctions" maxlength="20">\n\
                         </li>\n\
                        <li id="4" class="lista">\n\<span style="text-align:left; font-weight: bold; padding-right: 15px;">Palabra:</span><span class="obligatorio">*</span>\n\
                         <input type="text" name="1[]" id="idI_4" value="" class="input withClearFunctions" maxlength="20">\n\
                         <div id="erase" class="button-group absolute-right compact">\n\
                            <a onClick="agregarPagina(this)"class="button icon-plus with-tooltip confirm" title="Agregar Palabra" style="cursor:pointer;"></a>\n\
                         </div>\n\
                         </li>\n\
                          </ul><p id="maxTerm2" class="message red-gradient" style="display:none;"></p>');
    }
    else if (tipo === "crucigrama"){
            $("#materialTipo").html('<h3 class="relative thin underline" style="text-align:left;">Palabras del Crucigrama (M&aacute;ximo 6) \n\
                    <span class="button-group absolute-right">\n\
                    <a title="Agregar palabra" id="add" onClick="javascript:agregarTermino()" class="button icon-plus-round" style="cursor:pointer;">Agregar Palabra</a></span></h3>\n\
                    <p id="maxTerm1" class="message red-gradient" style="display:none;"></p>\n\
                    <input type="text" id="indices" name="indices" value="1,2," style="display:none;">\n\
                    \n\
                    <ul class="list spaced" id="lista" style="text-align:left; max-width:600px;">\n\
                     <!-- termino 1 -->\n\
                        <li id="1" class="lista">\n\
                        <table  style="max-width:500px"><tr>\n\
                        <td>\n\
                        Palabra<span class="obligatorio">*</span>:<br>\n\
                        <input type="text" name="1[]" id="idP_1" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
                            \n\
                        </td><td>\n\
                         Pista<span class="obligatorio">*</span>:<br> \n\
                         <textarea class="input" name="1[]" id="idS_1" rows="2" cols="45" maxlength="300"></textarea></td>\n\
                         <td></tr></table>\n\
                         </li>\n\
                     <!-- termino 2 -->\n\
                        <li id="2" class="lista">\n\
                        <table style="max-width:500px"><tr>\n\
                        <td>\n\
                        Palabra<span class="obligatorio">*</span>:<br><input type="text" name="2[]" id="idP_1" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
                        </td><td>\n\
                         Pista<span class="obligatorio">*</span>:<br> \n\
                         <textarea class="input" name="2[]" id="idS_2" rows="2" cols="45" maxlength="300"></textarea></td>\n\
                         <td></tr></table>\n\
                         <div id="erase" class="button-group absolute-right compact">\n\
                            <a onClick="agregarTermino(this)"class="button icon-plus with-tooltip confirm" title="Agregar T&eacute;rmino" style="cursor:pointer;"></a>\n\
                         </div>\n\
                         </li>\n\
                          </ul><p id="maxTerm2" class="message red-gradient" style="display:none;"></p>');
    }
    else if (tipo === "pareo"){
            $("#materialTipo").html('<h3 class="relative thin underline" style="text-align:left;">Descripciones e Im&aacute;genes del Pareo </h3>\n\
                    <img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Las imagenes deben ser del tipo PNG y no pesar mas de 100KB. Las dimensiones debe ser desde 50X50 hasta 130X200 px \n\
                    <p id="maxTerm1" class="message red-gradient" style="display:none;"></p>\n\
                    <input type="text" id="indices" name="indices" value="1,2,3," style="display:none;">\n\
                    \n\
                    <ul class="list spaced" id="lista" style="text-align:left; max-width:600px;">\n\
                     <!-- termino 1 -->\n\
                        <li id="1" class="lista">\n\<h5 style="text-align:left;"><h5>Pareja 1:</h5><br>\n\
                        <table  style="max-width:500px"><tr>\n\
                        <td>\n\
                         Pista<span class="obligatorio">*</span>:<br> \n\
                         <textarea class="input" name="pista1" id="idS_1" rows="2" cols="45" maxlength="300"></textarea></td>\n\
                         <td></tr></table>\n\
                        <div style="margin:0 auto; text-align:center;"> Imagen<span class="obligatorio">*</span>:<br>\n\
                         <input type="file" name="img1" id="idI_1" value="" class="archivo file withClearFunctions"></div>\n\
                          <br><div id="error-img1" class="msjError"></div><br>\n\
                         </li>\n\
                     <!-- termino 2 -->\n\
                        <li id="2" class="lista">\n\<h5 style="text-align:left;"><h5>Pareja 2:</h5><br>\n\
                        <table  style="max-width:500px"><tr>\n\
                        <td>\n\
                         Pista<span class="obligatorio">*</span>:<br> \n\
                         <textarea class="input" name="pista2" id="idS_2" rows="2" cols="45" maxlength="300"></textarea></td>\n\
                         <td></tr></table>\n\
                        <div style="margin:0 auto; text-align:center;"> Imagen<span class="obligatorio">*</span>:<br>\n\
                         <input type="file" name="img2" id="idI_2" value="" class="archivo file withClearFunctions"></div>\n\
                         <br><div id="error-img2" class="msjError"></div><br>\n\
                         </li>\n\
                      <!-- termino 3 -->\n\
                        <li id="3" class="lista">\n\<h5 style="text-align:left;"><h5>Pareja 3:</h5><br>\n\
                        <table  style="max-width:500px"><tr>\n\
                        <td>\n\
                         Pista<span class="obligatorio">*</span>:<br> \n\
                         <textarea class="input" name="pista3" id="idS_3" rows="2" cols="45" maxlength="300"></textarea></td>\n\
                         <td></tr></table>\n\
                        <div style="margin:0 auto; text-align:center;"> Imagen<span class="obligatorio">*</span>:<br>\n\
                         <input type="file" name="img3" id="idI_3" value="" class="archivo file withClearFunctions"></div>\n\
                         <br><div id="error-img3" class="msjError"></div><br>\n\
                         </li></ul>\n\
                            <p id="maxTerm2" class="message red-gradient" style="display:none;"></p>');
    }
    else if (tipo === "pareodepalabras"){
            $("#materialTipo").html('<h3 class="relative thin underline" style="text-align:left;">Palabras y Pistas del Pareo</h3> \n\
            <input type="text" id="indices" name="indices" value="1,2,3," style="display:none;">\n\
            <p id="maxTerm1" class="message red-gradient" style="display:none;"></p>\n\
            <ul class="list spaced" id="lista" style="text-align:left; max-width:600px;">\n\
            <!-- termino 1 -->\n\
            <li id="1" class="lista">\n\
            <table  style="max-width:500px"><tr>\n\
            <td>\n\
            Palabra<span class="obligatorio">*</span>:<br>\n\
            <input type="text" name="1[]" id="idP_1" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
                \n\
            </td><td>\n\
             Pista<span class="obligatorio">*</span>:<br> \n\
             <textarea class="input" name="1[]" id="idS_1" rows="2" cols="45" maxlength="300"></textarea></td>\n\
             <td></tr></table>\n\
             </li>\n\
            <!-- termino 2 -->\n\
            <li id="2" class="lista">\n\
            <table style="max-width:500px"><tr>\n\
            <td>\n\
            Palabra<span class="obligatorio">*</span>:<br><input type="text" name="2[]" id="idP_1" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
            </td><td>\n\
             Pista<span class="obligatorio">*</span>:<br> \n\
             <textarea class="input" name="2[]" id="idS_2" rows="2" cols="45" maxlength="300"></textarea></td>\n\
             <td></tr></table>\n\
             </li>\n\
             <!-- termino 2 -->\n\
            <li id="2" class="lista">\n\
            <table style="max-width:500px"><tr>\n\
            <td>\n\
            Palabra<span class="obligatorio">*</span>:<br><input type="text" name="2[]" id="idP_1" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
            </td><td>\n\
             Pista<span class="obligatorio">*</span>:<br> \n\
             <textarea class="input" name="2[]" id="idS_2" rows="2" cols="45" maxlength="300"></textarea></td>\n\
             <td></tr></table>\n\
             </li>\n\
              </ul><p id="maxTerm2" class="message red-gradient" style="display:none;"></p>');
    }
       }
       else{
           $("#materialTipo").html('<div id="tip"><img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Seleccione primero el tipo de Actividad</div>');
       }
    });
});