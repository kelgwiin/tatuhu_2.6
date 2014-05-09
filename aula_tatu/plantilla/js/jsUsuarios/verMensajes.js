$(document).ready(function() { 
    $(".eliminar").click(function(){
        var cod = $(this).attr('id');
        $.modal.confirm('&iquest;Deseas eliminar el Mensaje?', function(){
            $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Por favor espere...</h4>' });
            $.get('procesos/eliminarMensaje.php', {id:cod})
            .done(function(data) {
             $.unblockUI();
            if (data !== "0" || data !== "-1")
                mensaje = '<img src="../plantilla/img/standard/correcto.png"> El mensaje se ha eliminado correctamente';
            else
               mensaje = '<img src="../plantilla/img/standard/error.png"> Error al intentar eliminar el mensaje';
            $.modal.alert(
                    mensaje,
                    {buttons: {
                            'Cerrar':{classes :'blue-gradient glossy big full-width', click:function(modal) { modal.closeModal(); window.location.reload();  }}}
                    ,width:300,resizable:false});
            });
        },function(){
           // $(this).closeModal(); 
        },{width:300,resizable:false});
    });
    $('.area').click(function(){
        var cod = $(this).attr('id');
        id = cod.split("-")[0];
        msj = cod.split("-")[1];
        var cont = "<h3>Mensaje de Tatu H&uacute;:</h3><br>"+msj
        if(cod !== ''){
             $.modal({
                content: cont,
                title: '',
                width: 600,
                scrolling: false,
                actions: {
                        'Cerrar' : {
                                color: 'red',
                                click: function(win) { win.closeModal(); }
                        }
                },
                buttons: {
                    "Cerrar": {
                            classes:	"huge blue-gradient glossy",
                            click:		function(win) { win.closeModal(); }
                    },
                    "Modificar Mensaje": {
                            classes:	"huge blue-gradient glossy",
                            click:	function(win){ pagina = "mensaje_modificar.php?id="+id; location.href=pagina; }
                    }
                },
                buttonsLowPadding: true
            });
          }
}); 
    $('#tabla').dataTable({
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
            "sDom": '<"top"lfp>rt<"bottom"ip>'
    });
});