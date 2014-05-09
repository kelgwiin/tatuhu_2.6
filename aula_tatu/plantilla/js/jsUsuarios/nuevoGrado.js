$.validator.addMethod("grado", function(value, element) { 
        return parseInt(value)>=1 && parseInt(value)<=11;
});

function openModal(mensaje){

}

function nombreGrado(grado){
    var nombre = "";
    switch(parseInt(grado)){
        case 1: nombre = "1mer Grado"; break;
        case 2: nombre = "2do Grado"; break;
        case 3: nombre = "3er Grado"; break;
        case 4: nombre = "4to Grado"; break;
        case 5: nombre = "5to Grado"; break;
        case 6: nombre = "6to Grado"; break;
        case 7: nombre = "1mer A&ntilde;o"; break;
        case 8: nombre = "2do A&ntilde;o"; break;
        case 9: nombre = "3er A&ntilde;o"; break;
        case 10: nombre = "4to A&ntilde;o"; break;
        case 11: nombre = "5to A&ntilde;o"; break;
        default: nombre = "No existe o incorrecto";
    }
    $("#nombreGrado").html(nombre);
}

$(document).ready(function() {
$("#down").addClass("disabled");
$("#formulario").validate({ //reglas de validacion del formulario - jquery validate
rules:{
        grado: { required:true,grado: true}
},
messages:{
        grado: {
                required: "Debe ingresar un grado",
                grado: "El valor debe estar entre 1 (1mer grado) y 11 (5to a&ntilde;o)"
        }
},
errorPlacement: 
        function(error, element) {
                error.appendTo("#error-" + element.attr("name"));
        },
submitHandler: function(){
    $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando Grado, por favor espere...</h4>' });
     $.ajax({
       type: "POST",
       url: "post/nuevoGrado.php",
       data: $("form").serialize(),
       success: function(data){
           $.unblockUI();
          $.modal.alert(
            data,
            {buttons: {
                    'Cerrar':{classes :'blue-gradient glossy big full-width', click:function(modal) { modal.closeModal(); window.location.reload();  }}}
            ,width:300,resizable:false});
       }
    });
}
});
$("#up").click(function(){
    if (!$(this).hasClass("disabled")){
        var val = parseInt($("#grado").val()) +1;
        $("#down").removeClass("disabled");
        if (val>= 11){
           $("#up").addClass("disabled");
           val = 11;
        }
        $("#grado").val(val);
        nombreGrado($("#grado").val());
    }
});
$("#down").click(function(){
    if (!$(this).hasClass("disabled")){
        var val = parseInt($("#grado").val()) - 1;
        $("#up").removeClass("disabled");
        if (val <= 1){
           $("#down").addClass("disabled");
           val = 1;
        }
        $("#grado").val(val); 
        nombreGrado($("#grado").val());
    }
});
$("#grado").change(function(){
    if (parseInt($(this).val())>11) $(this).val("11");
    else if (parseInt($(this).val())<1) $(this).val("1");
    nombreGrado($("#grado").val());
});
});