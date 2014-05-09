var cant = 2;

//Algunas reglas de validacion
$.validator.addMethod("youtube", function(value, element) { 
        var url = value.split('watch?v=');
        if (url[1] !== undefined){
            var id = url[1].split('&')[0];
            if (id.length !== 11)
                return false;
        }
        else{
            return false;
        }
        return true;//reg.test(value);
});

function validar_nombre_archivo(nombre) { 
       var reg = /^([^a-zA-Z0-9-.#])/;
       return reg.test(nombre);
}

//Validacion del Formulario
$("#formulario").validate({
rules:{
        pdf: {required:true,  extension: "pdf"},
        nombre_material: { required:true},
        retroalimentacion: {required:true},
        
        video: {required:true, extension: "ogv|mp4|avi"},
        videoY: {required:true,youtube: true, url:true},
        flash: {required:true, extension: "swf"}
},
messages:{
       nombre_material: { required: "Debe ingresar un nombre para el material"  },
       retroalimentacion: { required: "Debe ingresar un mensaje de retroalimentaci&oacute;n" },
       pdf: {required: "Seleccione el archivo PDF", extension:"El tipo del archivo debe ser PDF"},
       video: {required: "Seleccione el archivo de video", extension:"El tipo del archivo debe ser ogv, mp4 o avi"},
       videoY: {required: "Ingrese la direcci&oacute;n del video de Youtube", youtube: "El enlace del video es incorrecto", url: "Ingrese un enlace v&aacute;lido (con el prefijo http://)"},
       flash: {required: "Seleccione el archivo SWF", extension:"El tipo del archivo debe ser swf"},
},
errorPlacement: 
    function(error, element) {
            error.appendTo("#error-" + element.attr("name"));
    },
submitHandler: function(){
//Validaciones que no hace Jquery Validate
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
var cant = 0;
var errorArch = false;
var antVal = "",antId;

var tipo = $("#tipo option:selected").val().split("-")[1];;
tipo = tipo.toUpperCase(tipo);
//1.- Libro Interactivo y Diccionario
if ( tipo ===  "librointeractivo" || tipo ===  "diccionariointeractivo"){
$("#lista li").each(function(){
    antVal = $(this).find("input.file").val();
    antId = $(this).attr("id");
    if($(this).find("input.file").val() === ""){
        errorArch = true;
        $("#maxTerm1").html('<span class="block-arrow"><span></span></span>Compruebe que haya adjuntado todos los archivos');
        $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>Compruebe que haya adjuntado todos los archivos');
        $("#maxTerm1, #maxTerm2").fadeIn('slow');
        if ($(this).find(".errorSecc").length === 0) {
           $(this).append("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
        }
    }
    else{
        if($(this).find("input.file").val().match(new RegExp(".(png)$", "i")) === null){
           errorArch = true; 
           $("#maxTerm1").html('<span class="block-arrow"><span></span></span>Compruebe que los archivos sean del tipo PNG');
            $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>Compruebe que los archivos sean del tipo PNG');
            $("#maxTerm1, #maxTerm2").fadeIn('slow');
            if ($(this).find(".errorSecc").length === 0) 
                $(this).append("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
        }
        else{            
            if ($(this).find(".errorSecc").length !== 0)
                $(this).find(".errorSecc").remove();
        //verificando que los archivos no sean iguales
            $("#lista li").each(function(){
                idAct = $(this).attr("id");
                if (idAct !== antId){
                    if ($(this).find("input.file").val() === antVal){
                        if ($("#"+idAct).find(".errorSecc").length === 0) {
                            $("#"+idAct).append("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
                            $("#"+antId).append("<label style=\"color:red\" class=\"errorSecc\"><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"></span>");
                            $("#maxTerm1").html('<span class="block-arrow"><span></span></span>Compruebe que los archivos no sean iguales');
                            $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>Compruebe que los archivos no sean iguales');
                            $("#maxTerm1, #maxTerm2").fadeIn('slow');
                            errorArch = true; 
                        }
                    }
                }
            });
        }
    }
    cant++;
    if(tipo ===  "diccionariointeractivo"){
        if ($(this).find("input.input").val() === ""  || $(this).find("textarea").val() === ""){
            error = true;
            $("#maxTerm1").html('<span class="block-arrow"><span></span></span>Compruebe que todos los t&eacute;rminos est&eacute;n llenos correctamente');
            $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>Compruebe que todos los t&eacute;rminos est&eacute;n llenos correctamente');
            $("#maxTerm1, #maxTerm2").fadeIn('slow');
        }
    }
});
//cantidad de archivos
if (tipo === "librointeractivo" && cant > 6)
    errorArch = true;
else if (tipo === "diccionariointeractivo" && cant > 6)
    errorArch = true;
}

if (!errorArch){
    $(".errorSecc").remove(); 
    $("#maxTerm1, #maxTerm2").fadeOut();
}

if(!error && !errorArch){
$("#error-area").html("");
$("#error-componente").html("");
$("#error-tema").html("");
$("#error-tipo").html("");

//Carga del form en una variable data para enviarlo al post
var tipo = $("#tipo").val();
tipo = tipo.split("-")[1];
var data = new FormData();

if(tipo === "videoyoutube"){
    data.append('enlace',$("#videoY").val());
}

else{ 
    var archivos = document.querySelectorAll("input.archivo"); //obtenemos todos los archivos
    for (i = 0; i<archivos.length; i++){
            var archivo = archivos[i].files;
            data.append('archivo'+i,archivo[0]);
    }
    if (tipo === "diccionariointeractivo"){
        i = 0;
         $("#lista li").each(function(){
            data.append('palabra'+i,$(this).find("input[type='text']").val());
            data.append('definicion'+i,$(this).find("textarea").val());
            i++;
        });
    }
}

//almacenamos el resto de los datos
data.append('nombre',$("#nombre_material").val());
data.append('retroalimentacion',$("#retroalimentacion").val());
data.append('usuario',$("#usuario").val());
data.append('tipo',$("#tipo").val());
data.append('area',$("#area").val());
data.append('componente',$("#componente").val());
data.append('contenido',$("#contenido").val());

$.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando Material, por favor espere...</h4>' });
$.ajax({
type: "POST",
url: "post/nuevoMaterial.php",
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
        var Nelem = '<li id="'+id+'" class="lista">\n\<h5 style="text-align:left;">T&eacute;rmino:</h5><br>\n\
                    <table style="max-width:500px"><tr>\n\
                    <td>\n\
                    Palabra<span class="obligatorio">*</span>:<br><input type="text" name="'+id+'[]" id="idP_'+id+'" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
                    </td><td>\n\
                     Significado<span class="obligatorio">*</span>:<br> \n\
                     <textarea class="input" id="idS_'+id+'" name="'+id+'[]" rows="2" cols="45" maxlength="300"></textarea></td>\n\
                     <td></tr></table>\n\
                    <div style="margin:0 auto; text-align:center;"> Imagen<span class="obligatorio">*</span>:<br>\n\
                     <input type="file" name="'+id+'[]" id="idI_'+id+'" value="" class="archivo file withClearFunctions">\n\
                        </div>\n\
                       <div id="erase" class="button-group absolute-right compact">\n\
                        <a onClick="eliminarTermino(this)"class="button icon-trash with-tooltip confirm" title="Eliminar T&eacute;rmino" style="cursor:pointer;"></a>\n\
                        <a onClick="agregarTermino(this)"class="button icon-plus with-tooltip confirm" title="Agregar T&eacute;rmino" style="cursor:pointer;"></a>\n\
                        </div></li>';
        $("#lista").append(Nelem);
        window.cant++; 
    }
    else{
        $("#maxTerm1").html('<span class="block-arrow"><span></span></span>El diccionario interactivo permite hasta un m&aacute;ximo de 6 t&eacute;minos');
        $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>El diccionario interactivo permite hasta un m&aacute;ximo de 6 t&eacute;minos');
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
        if (window.cant < 15){
        var id = parseInt($("#lista li").last().attr("id")) + 1;
        $("#indices").val($("#indices").val() + id + ",");       
        var Nelem = '<li id="'+id+'" class="lista"><span style="text-align:left; font-weight: bold; padding-right: 15px;">P&aacute;gina:</span>\n\
                        <input type="file" name="'+id+'[]" id="idI_'+id+'" value="" class="archivo file withClearFunctions">\n\
                                 <div id="erase" class="button-group absolute-right compact">\n\
                                    <a onClick="eliminarTermino(this)"class="button icon-trash with-tooltip confirm" title="Eliminar P&aacute;gina" style="cursor:pointer;"></a>\n\
                                    <a onClick="agregarPagina(this)"class="button icon-plus with-tooltip confirm" title="Agregar P&aacute;gina" style="cursor:pointer;"></a>\n\
                                 </div>\n\
                      </li>';
        $("#lista").append(Nelem);
        window.cant++; 
    }
    else{
        $("#maxTerm1").html('<span class="block-arrow"><span></span></span>El libro interactivo permite hasta un m&aacute;ximo de 15 p&aacute;ginas');
        $("#maxTerm2").html('<span class="block-arrow top"><span></span></span>El libro interactivo permite hasta un m&aacute;ximo de 15 p&aacute;ginas');
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
            $('#contTem').html('<span id="contComp"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="tema" id="tema" style="width:150px;"></select></span>');
            $('#contComp').html('<span id="contComp"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="componente" id="componente" style="width:150px;"></select></span>');
        }
    });
$("#tipo").change(function(){        
$("#error-tipo").html("");
var id = $(this).val();
if (id !== ""){
window.cant = 2;
//Formulario dinamico segun el tipo de actividad
var tipo = $(this).find("option[value='"+id+"']").val().split("-")[1];
if (tipo === "librointeractivo"){
    $("#materialTipo").html('<h3 class="relative thin underline" style="text-align:left;">P&aacute;ginas del Libro (M&aacute;ximo 15) \n\
        <span class="button-group absolute-right">\n\
        <a title="Agregar p&aacute;gina" id="add" onClick="javascript:agregarPagina()" class="button icon-plus-round" style="cursor:pointer;">Agregar P&aacute;gina</a></span></h3>\n\
        <img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Las p&aacute;ginas deben ser agregadas en el orden en que aparecer&aacute;n en el libro<br>\n\
        <img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Las imagenes deben ser del tipo <strong>PNG</strong> y no pesar mas de 50KB. Las dimensiones debe ser desde 300X500 hasta 370X520 px \n\
        <p id="maxTerm1" class="message red-gradient" style="display:none;"></p>\n\
        <input type="text" id="indices" name="indices" value="1,2," style="display:none;">\n\
        <ul class="list spaced" id="lista" style="text-align:left; max-width:600px;">\n\
         <!-- pagina 1 -->\n\
            <li id="1" class="lista">\n\<span style="text-align:left; font-weight: bold; padding-right: 15px;">P&aacute;gina:</span>\n\
             <input type="file" name="1[]" id="idI_1" value="" class="archivo file withClearFunctions" >\n\
             </li>\n\
         <!-- pagina 2 -->\n\
            <li id="2" class="lista">\n\<span style="text-align:left; font-weight: bold; padding-right: 15px;">P&aacute;gina:</span>\n\
             <input type="file" name="2[]" id="idI_2" value="" class="archivo file withClearFunctions" >\n\
             <div id="erase" class="button-group absolute-right compact">\n\
                <a onClick="agregarPagina(this)"class="button icon-plus with-tooltip confirm" title="Agregar P&aacute;gina" style="cursor:pointer;"></a>\n\
             </div>\n\
             </li>\n\
              </ul><p id="maxTerm2" class="message red-gradient" style="display:none;"></p>');
    }
    else if (tipo === "materialpdf"){
    $("#materialTipo").html('Archivo PDF<span class="obligatorio">*</span><br>\n\
                    <input type="file" name="pdf" id="pdf" value="" class="archivo file withClearFunctions">\n\
                        <br><div id="error-pdf" class="msjError"></div><br>\n\
                    <div>El archivo debe ser del tipo PDF y no pesar m&aacute;s de 5MB</div>');
    }
    else if (tipo === "video"){
    $("#materialTipo").html('Archivo de Video<span class="obligatorio">*</span><br>\n\
                    <input type="file" name="video" id="video" value="" class="archivo file withClearFunctions" >\n\
                        <br><div id="error-video" class="msjError"></div><br>\n\
                    <div>El archivo debe ser del tipo: ogv o mp4, y no pesar m&aacute;s de 10MB</div>');
    }
    else if (tipo === "videoyoutube"){
    $("#materialTipo").html('Enlace del Video<span class="obligatorio">*</span><br>\n\
                    <input type="text" name="videoY" id="videoY" value="" class="input" style=" width:300px" >\n\
                        <br><div id="error-videoY" class="msjError"></div><br>\n\
                    <div>El enlace del video debe contenener el <strong>id</strong>, ejemplo:<br> http://www.youtube.com/watch?<span style="color:green; font-weight:bold;">v=YYYYYYYYYYY</span></div>');
    }
    else if (tipo === "diccionariointeractivo"){
    $("#materialTipo").html('<h3 class="relative thin underline" style="text-align:left;">T&eacute;rminos del Diccionario (M&aacute;ximo 6) \n\
        <span class="button-group absolute-right">\n\
        <a title="Agregar t&eacute;mino" id="add" onClick="javascript:agregarTermino()" class="button icon-plus-round" style="cursor:pointer;">Agregar T&eacute;mino</a></span></h3>\n\
        <img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Las imagenes deben ser del tipo PNG y no pesar mas de 50KB. Las dimensiones debe ser desde 120X100 hasta 140X200 px \n\
        <p id="maxTerm1" class="message red-gradient" style="display:none;"></p>\n\
        <input type="text" id="indices" name="indices" value="1,2," style="display:none;">\n\
        \n\
        <ul class="list spaced" id="lista" style="text-align:left; max-width:600px;">\n\
         <!-- termino 1 -->\n\
            <li id="1" class="lista">\n\<h5 style="text-align:left;"><h5>T&eacute;rmino:</h5><br>\n\
            <table  style="max-width:500px"><tr>\n\
            <td>\n\
            Palabra<span class="obligatorio">*</span>:<br>\n\
            <input type="text" name="1[]" id="idP_1" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
                \n\
            </td><td>\n\
             Significado<span class="obligatorio">*</span>:<br> \n\
             <textarea class="input" name="1[]" id="idS_1" rows="2" cols="45" maxlength="300"></textarea></td>\n\
             <td></tr></table>\n\
            <div style="margin:0 auto; text-align:center;"> Imagen<span class="obligatorio">*</span>:<br>\n\
             <input type="file" name="1[]" id="idI_1" value="" class="archivo file withClearFunctions"></div>\n\
             </li>\n\
         <!-- termino 2 -->\n\
            <li id="2" class="lista">\n\<h5 style="text-align:left;">T&eacute;rmino:</h5><br>\n\
            <table style="max-width:500px"><tr>\n\
            <td>\n\
            Palabra<span class="obligatorio">*</span>:<br><input type="text" name="2[]" id="idP_1" value="" class="input" style=" width:100px" maxlength="60"><br>\n\
            </td><td>\n\
             Significado<span class="obligatorio">*</span>:<br> \n\
             <textarea class="input" name="2[]" id="idS_2" rows="2" cols="45" maxlength="300"></textarea></td>\n\
             <td></tr></table>\n\
            <div style="margin:0 auto; text-align:center;"> Imagen<span class="obligatorio">*</span>:<br>\n\
             <input type="file" name="2[]" id="idI_2" value="" class="archivo file withClearFunctions">\n\
             </div>\n\
             <div id="erase" class="button-group absolute-right compact">\n\
                <a onClick="agregarTermino(this)"class="button icon-plus with-tooltip confirm" title="Agregar T&eacute;rmino" style="cursor:pointer;"></a>\n\
             </div>\n\
             </li>\n\
              </ul><p id="maxTerm2" class="message red-gradient" style="display:none;"></p>');
    }           
    else if (tipo==="animacionflash"){ //animacion flash
    $("#materialTipo").html('Archivo Flash<span class="obligatorio">*</span><br>\n\
                        <input type="file" name="flash" id="flash" value="" class="archivo file withClearFunctions" >\n\
                        <br><div id="error-flash" class="msjError"></div><br>\n\
                    <div>El archivo debe ser del tipo swf y no pesar m&aacute;s de 2MB</div>');
    }
}
else{
    $("#materialTipo").html('<div id="tip"><img src="../plantilla/img/icons_docente/tip.png" alt="Tip"> Seleccione primero el tipo de Material</div>');
}
});
});