$(document).ready(function() {
 var ant = 0;
         
$('#tabla_visualizador_usuarios').dataTable({
'oLanguage':{
'sProcessing':     'Procesando...',
'sLengthMenu':     'Mostrar _MENU_ registros',
'sZeroRecords':    'No se encontraron resultados',
'sEmptyTable':     'Ningún dato disponible en esta tabla',
'sInfo':           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
'sInfoEmpty':      'Mostrando registros del 0 al 0 de un total de 0 registros',
'sInfoFiltered':   '(filtrado de un total de _MAX_ registros)',
'sInfoPostFix':    '',
'sSearch':         'Buscar:',
'sUrl':            '',
'sInfoThousands':  ',',
'sLoadingRecords': 'Cargando...', 
'oPaginate': {
'sFirst':    'Primero',
'sLast':     '&Uacute;ltimo',
'sNext':     'Siguiente',
'sPrevious': 'Anterior'
},
'oAria': {
   'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
    'sSortDescending': ': Activar para ordenar la columna de manera descendente'
}

},
"sPaginationType": "full_numbers",
"sDom": '<"top"lfp>rt<"bottom"p>'
});

$("#grado").change(function(){
   var id = $(this).val();
   if (id !== "" && id != ant){
       if($("#tabla_visualizador_usuarios tbody tr."+id).length>0){
           $("#error").hide();
           $("#contenido").show();
            $("."+id).removeClass("oculto");
            $("."+ant).addClass("oculto");
            ant = id;
       }
       else{
           $("."+id).addClass("oculto");
           ant = id;
           $("#contenido").hide();
           $("#error").show();
       }
   }
   else{
     
      if (ant != 0){
         $("."+ant).addClass("oculto");
      }
       $("#contenido").hide();
       $("#error").hide();
       ant = 0;
   }
});

});