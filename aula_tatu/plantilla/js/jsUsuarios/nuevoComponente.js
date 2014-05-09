$("#formulario").validate({ //reglas de validacion del formulario - jquery validate
rules:{
        nombre_componente: { required:true},
        descripcion: { required:true},
        imagen_componente: {required: true, extension:"png"}
},
messages:{
        nombre_componente: { required: "Debe ingresar un nombre para el componente"},
        descripcion: {required: "Debe ingresar una descripci&oacute;n para el componente" },
        imagen_componente: {required: "Seleccione una imagen para identificar el componente", extension:"El tipo de archivo debe ser PNG"}
},
errorPlacement: 
        function(error, element) {error.appendTo("#error-" + element.attr("name")); },
submitHandler: function(){
var error0 = error1 = false;
 if ($("#area").val() === "" || $("#area").val() === null){
     error0 = true;
     $("#error-area").html("<span style='color:red'>Seleccione el &aacute;rea de aprendizaje del componente</span>");
 }
 else{
     error0 = false;
     $("#error-area").html("");
 }
 if ($("#grado").val() === ""){
     error1 = true;
     $("#error-grado").html("<span style='color:red'>Seleccione el grado del componente</span>");
     
 }
 else{
     error1 = false;
     $("#error-grado").html("");
 }
 if(!error0 && !error1){
  var archivos = document.getElementById("imagen");//Damos el valor del input tipo file
  var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
  //El objeto FormData nos permite crear un formulario pasandole clave/valor para poder enviarlo, este tipo de objeto ya tiene la propiedad multipart/form-data para poder subir archivos
  var data = new FormData();
  data.append('imagen_componente',archivo[0]);
  data.append('nombre_componente',$("#nombre_componente").val());
  data.append('descripcion',$("#descripcion").val());
  data.append('area', $("#area").val());
  data.append('grado', $("#grado").val());
  $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando Componente, por favor espere...</h4>' });
$.ajax({
type: "POST",
url: "post/nuevoComponente.php",
data: data,
contentType:false,
processData:false,
cache:false,
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
$("#grado").change(function(){
   var id = $(this).val();
   if (id !== ""){
       $("#error-area").html("");
       $("#cargandoInfo").show();
       $.get('procesos/areas_grado.php', { id: id}).done(function(data) {
           $("#cargandoInfo").hide();
                if (data !== '0'){
                    $('#contComp').html(data);
                }
                else if(data !=="-1"){
                    $('#contComp').html("<span style='color:red'><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> El grado seleccionado no tiene &aacute;reas de aprendizaje</span>")
                }
                else{
                    $('#contComp').html("<span style='color:red'><img src=\"../plantilla/img/standard/error.png\" alt=\"Error\"> Error al enviar los datos, recargue la p&aacute;gina e intente nuevamente</span>")
                }
       });
   }
   else{
       $('#contComp').html('<span id="contComp"><select class="select expandable-list replacement fixedWidth select-styled-list tracked disabled" name="area" id="area" style="width:150px;"></select></span>');
   }
});
});