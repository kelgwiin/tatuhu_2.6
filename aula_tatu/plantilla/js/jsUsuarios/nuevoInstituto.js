function parroquias(){
    var edo = $("#municipio").val();
    if (edo !== ""){
             $("#cargandoInfo").show();
            $("#error-dir").html("");
            $("#error-dir").hide();
            $.get("procesos/parroquias_select.php", { municipio: edo})
            .done(function(data) {
            $("#cargandoInfo").hide();
            if (data !== "0"){
                    $("#sel2").html("<select class=\"select expandable-list replacement fixedWidth select-styled-list tracked\" id=\"parroquia\" name=\"parroquia\" style=\"width:150px;\"> " + data + "</select>");
            }
            });
    }
    else{
            $("#sel2").html("<select class=\"select\" disabled style=\"width:150px !important;\"></select>");
    }
}

$(document).ready(function() {
    $("#telefono").mask("9999-9999999");
    mayuscula("input#codigo_colegio");
    $("#formulario").validate({
        rules:{
                codigo_colegio: {minlength : 10, maxlength:10, sinacoe: true},
                estado:{required:true},
                telefono:{telefono:true},
                correo:{email:true},
                nombre_contacto:{nombre:true}
        },
        messages:{
                codigo_colegio: {
                        required: "Debe ingresar el c&oacute;digo SINACOE",
                        minlength: "El c&oacute;digo debe tener al menos 10 caracteres",
                        sinacoe: "El c&oacute;digo debe tener s&oacute;lo n&uacute;meros y letras"
                },
                nombre_colegio: {
                        required: "Debe ingresar el nombre del colegio"
                },
                nombre_contacto:{nombre:"El nombre solo debe contener letras "},
                telefono:{telefono:"N&uacute;mero telef&oacute;nico<br>incorrecto"},
                correo:{email:"Correo incorrecto. Ejemplo: alguien@correo.com"}
        },
        errorPlacement: 
                function(error, element) {
                        error.appendTo("#error-" + element.attr("name"));
                },
        submitHandler: function() {
            if($("#estado").val() === "" || $("#municipio").length == 0 ||
              ($("#municipio").length > 0  && $("#municipio").val() === "") || 
               ($("#parroquia").length > 0  && $("#parroquia").val() === "") ){
                 $("#error-dir").html("Seleccione el Estado, Municipio y Parroquia donde se encuentra ubicada la Instituci&oacute;n<br>");
                  $("#error-dir").show();
                    $(window).scrollTop($('#error-dir').position().top);
                  return false;
            }
            else{
                 $("#error-dir").html("");
                 $("#error-dir").hide();
                 $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando Instituto, por favor espere...</h4>' });
                 $.ajax({
                    type: "POST",
                    url: "post/nuevoInstituto.php",
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

        }    
 });
    
$("#codigo_colegio").focusout(function(){
    var reg = /^([a-z1-90]{10})$/i;
    $('#error-codigo_colegio div').html("");
    if($(this).val()!== "" && reg.test($(this).val())){
        $('#error-codigo_colegio').html("<img src=\"../plantilla/img/standard/loaders/loading16.gif\" alt=\"cargando\"> Verificando disponibilidad, por favor espere.</div>");
        $.get('procesos/checkSinacoe.php', { cod: $(this).val()}).done(function(data) {
            if (data === '0'){
            $('#error-codigo_colegio').html("<div style='color:red;'>C&oacute;digo SINACOE no disponible</div>");
            $('#codigo_colegio').val('');
        }else if (data === '1'){
            $('#error-codigo_colegio').html("<div style='color:green;'>C&oacute;digo Disponible</div>");
        }else{
            $('#error-codigo_colegio').html("Error al enviar los datos, recargue la p&aacute;gina");
       }
    });
    }
});
    
$("#estado").change(function() {
    var edo = $(this).val();
    if(edo != ""){
        $("#error-dir").html("");
        $("#error-dir").hide();
         $("#cargandoInfo").show();
        $.get("procesos/municipios_select.php", { estado: edo})
        .done(function(data) {
     $("#cargandoInfo").hide();
        if (data !== "0"){
          $("#sel1").html("<select id=\"municipio\" class=\"select expandable-list replacement fixedWidth select-styled-list tracked\" name=\"municipio\" onChange=\"parroquias()\" style=\"width:150px;\">" + data + "</select>");
          $("#sel2").html("<select class=\"select\" disabled style=\"width:150px;\"></select>");
        }
    });
 }
 else{
   $("#sel1").html("<select class=\"select\" disabled style=\"width:150px\"></select>");
   $("#sel2").html("<select class=\"select\" disabled style=\"width:150px\"></select>");
}
});
});