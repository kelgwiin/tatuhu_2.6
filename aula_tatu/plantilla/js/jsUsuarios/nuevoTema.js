$("#formulario").validate({ //reglas de validacion del formulario - jquery validate
rules:{
        nombre_tema: { required:true}
},
messages:{
        nombre_tema: {
                required: "Debe ingresar un nombre para el tema"
        }
},
errorPlacement: 
        function(error, element) {
                error.appendTo("#error-" + element.attr("name"));
        },
submitHandler: function(){
var error0= false , error1 = false;
if ($("#area").val() === ""){
     error0 = true;
     $("#error-area").html("<span style='color:red'>Seleccione el &aacute;rea de aprendizaje del componente</span>");
}else{
     error0 = false;
     $("#error-area").html("");
}
 if ($("#componente").val() === ""){
     error1 = true;
     $("#error-componente").html("<span style='color:red'>Seleccione el componente</span>");
 }
 else{
     error1 = false;
     $("#error-componente").html("");
 }
if(!error0 && !error1){
$.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando Tema, por favor espere...</h4>' });
$.ajax({
type: "POST",
url: "post/nuevoTema.php",
data: $("form").serialize(),
success: function(data){
    $.unblockUI();
    $.modal.alert(
    data,
    {buttons: {
            'Cerrar':{classes :'blue-gradient glossy big full-width', click:function(modal) { 
                    modal.closeModal(); 
                    if (data.indexOf("<img src='../plantilla/img/standard/error.png'>") === -1)
                        window.location.reload(); 
                }}}
    ,width:300,resizable:false});
  }
});
}
}
});

$(document).ready(function(){
    $("#area").change(function(){
        var id = $(this).val();
        if (id !== ""){
            $("#cargandoInfo").show();
            $("#error-area").html("");
            $("#error-componente").html("");
            $.get('procesos/componentes_area.php', { id: id}).done(function(data) {
                $("#cargandoInfo").hide();
                if (data !== '0'){
                    $('#contComp').html(data);
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
});