function verActividad(idE,tab){
idE = idE.split("-");
    $.blockUI({ message: '<div style="margin:10px;"><div style="float:left">\n\
                            <img src="../plantilla/img/Cachicamo2.png">\n\
                           </div><h4 class="thin" style="padding:20px;">\n\
                            <img src="../plantilla/img/standard/loaders/loading16.gif" /> \n\
                            Tatu H&uacute; est&aacute; cargando la diversi&oacute;n</h4></div>' });
    $.get( 'procesos/actividad.php', {id:idE[0],area:idE[1],componente:idE[2],contenido:idE[3],ult:idE[4],pos:idE[5]})
    .done(function(data) {
        $.unblockUI();
        $("#tab-"+tab).find(".act").html(data);
    });
}

$(document).ready(function(){
var id = $(".active").attr("id");  
verActividad(id,$("li.active").find("a").attr("href").split("-")[1]);
    $(".tabs li.enabled").click(function(){
        idA = $(this).attr("id");
        if (idA !== id){
             var tab = $(this).find("a").attr("href").split("-")[1];
             verActividad(idA,tab);
             id=idA;
        }
    });
    
});