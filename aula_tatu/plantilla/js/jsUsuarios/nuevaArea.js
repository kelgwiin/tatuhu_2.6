$("#formulario").validate({ //reglas de validacion del formulario - jquery validate
rules:{
        nombre_area: { required:true},
        descripcion: { required:true},
        imagen_area: {required: true, extension:"png"}
},
messages:{
        nombre_area: {required: "Debe ingresar un nombre para el &aacute;rea" },
        descripcion: {required: "Debe ingresar una descripci&oacute;n para el &aacute;rea"},
        imagen_area: { required: "Seleccione una imagen para identificar el &aacute;rea", extension:"El tipo de archivo debe ser PNG"}
},
errorPlacement: 
        function(error, element) {error.appendTo("#error-" + element.attr("name"));},
submitHandler: function(){
if ($("#grado").val() === ""){
    $("#error_grado").html("Seleccione el grado del &aacute;rea");
}
else{
  $("#error_grado").html("");
  var archivos = document.getElementById("imagen");//Damos el valor del input tipo file
  var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
  //El objeto FormData nos permite crear un formulario pasandole clave/valor para poder enviarlo, este tipo de objeto ya tiene la propiedad multipart/form-data para poder subir archivos
  var data = new FormData();
  data.append('imagen_area',archivo[0]);
  data.append('nombre_area',$("#nombre_area").val());
  data.append('descripcion',$("#descripcion").val());
  data.append('grado',$("#grado").val());
  $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando &Aacute;rea, por favor espere...</h4>' });
$.ajax({
type: "POST",
url: "post/nuevaArea.php",
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