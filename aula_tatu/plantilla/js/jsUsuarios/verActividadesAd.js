$(document).ready(function() {    
    $('.area').click(function(){
            var cod = $(this).attr('id');
            if(cod !== ''){
		idMat = cod.split("-");
                $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Recuperando la informaci&oacute;n del Material, por favor espere...</h4>' });
                    $.get('procesos/actividad_info.php', {actividad: idMat[0], tipo: idMat[1]})
                    .done(function(data) {
                      $.unblockUI();
                      if (data !== '0'){
                         $.modal({
                            content: data,
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
                                "Modificar Actividad": {
                                        classes:	"huge blue-gradient glossy",
                                        click:		function(win){ pagina = "actividad_modificar.php?idAct="+idMat[0]+"&tipoAct="+idMat[1]; location.href=pagina; }
                                }
                            },
                            buttonsLowPadding: true
                        });
                      }
                      else{
                           $.modal.alert(
                                '<img src="../plantilla/img/standard/error.png"> Error al recuperar los datos del Material, recargue la p&aacute;gina e intente nuevamente',
                                {buttons: {
                                        'Cerrar':{classes :'blue-gradient glossy big full-width', click:function(modal) { modal.closeModal();}}}
                                ,width:300,resizable:false});
                      }
                    });
              }
    }); 
    $('#tabla').dataTable({
            'oLanguage':{
                 'sProcessing':     'Procesando...',
                 'sLengthMenu':     'Mostrar _MENU_ registros',
                 'sZeroRecords':    'No se encontraron resultados',
                 'sEmptyTable':     'Ning&uacute;n dato disponible en esta tabla',
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