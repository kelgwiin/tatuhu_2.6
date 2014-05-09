function nombreSecciones(elem){
var idG = $(elem).val();
var idE = $('#escuelaE').val();
if(idG !== "" && idE !=="" ){
    $("#cargandoInfo").show();
      $("#error-grado").hide();
      $.get("procesos/nombresSecciones_disp.php", { id_grad:idG, id_ins:idE  })
                .done(function(data) {
            $("#cargandoInfo").hide();
                if (data !== "0"){
                    $("#nombreSecc").html('<select class="select" id="seccionE" name="seccion">'+data+'</select>');
                }
       });
}
else{
     $("#nombreSecc").html('<select class="select" disabled></select>');
}
}

$(document).ready(function() {
$("#fnac_id").mask("99/99/9999");
$("#cedula_id").mask("9999999?9");
$("#tlf_id").mask("9999-9999999");

$("#formulario").validate({ //reglas de validacion del formulario - jquery validate
rules:{
        cedula: {required:true,cedula: true}
},
messages:{
        cedula: {
                required: "Debe ingresar la c&eacute;dula",
                cedula: "C&eacute;dula incorrecta"
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
if ($("#escuelaE").val() === ""){//Validaciones adicionales que no hace jquery validate
    $("#error-escuela").html("Debe indicar el Instituto");
    $("#error-escuela").show();
    error = true;
}
if ($("#gradoE").length === 0 || $("#gradoE").val() ===""){
    $("#error-grado").html("Debe indicar el Grado");
    $("#error-grado").show();
    error = true;
}
if ($("#seccionE").length === 0 || $("#seccionE").val() ===""){
    $("#error-seccion").html("Debe indicar la Seccion");
    $("#error-seccion").show();
    error = true;
}
if(!error){
    $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Registrando Secci&oacute;n, por favor espere...</h4>' });
     $.ajax({
        type: "POST",
        url: "post/nuevaSeccion.php",
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

$('#escuelaE').change(function(){
var e = $(this).val();
$("#seccionesProf").hide();  
if (e !== ''){
    $("#error-escuela").hide();
    $("#lista_grados").html('<select name="grado" class="select" id="gradoE" onChange="nombreSecciones(this)"><option></option>'+window.grados+'</select>');
    $("#nombreSecc").html('<select class="select" disabled></select>');
}
else{
    $("#lista_grados").html('<select name="grado" class="select" id="gradoE" disabled></select>');
    $("#nombreSecc").html('<select class="select" disabled></select>');
}
});

/*Verifica que la cedula EXISTA en la BD y que sea de un docente,
 * y que el docente tenga menos de 3 secciones
 */
$('#cedula_id').focusout(function(){ 
    if($(this).val()!== ""){
        $('#error-cedula div').html("");
        var val = $(this).val().split("_").join("");
        if (val !== ""){
            $("#cargandoInfo").show();
            $.get('procesos/checkDocente.php', { cedula: val}).done(function(data) {
                $("#cargandoInfo").hide();
                $('#error-cedula').html(data);
                if (data.indexOf("<div style='color:red;'>") !== -1)
                    $("#cedula_id").val("");
            });
         }
    }
});
});