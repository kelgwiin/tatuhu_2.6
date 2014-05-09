function des_activar(id,name,mode){//Cuadros de dialogo y funcionamiento para activar/desactivar institutos
$.modal.confirm('&iquest;Deseas '+mode+' el instituto <strong>'+name+'</strong>?', function(){
    $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Por favor espere...</h4>' });
    $.get('procesos/des_activarInstituto.php', {id:id, mode:((mode === "activar")?"ACTIVO":"INACTIVO")})
    .done(function(data) {
     $.unblockUI();
    if (data !== "0" || data !== "-1")
        mensaje = '<img src="../plantilla/img/standard/correcto.png"> Se ha '+((mode === "activar")?"activado":"desactivado")+' correctamente el instituto "'+name+'"';
    else
       mensaje = '<img src="../plantilla/img/standard/error.png"> Error al intentar '+((mode === "activar")?"activar":"desactivar")+' el instituto "'+name+'"';
    $.modal.alert(
            mensaje,
            {buttons: {
                    'Cerrar':{classes :'blue-gradient glossy big full-width', click:function(modal) { modal.closeModal(); window.location.reload();  }}}
            ,width:300,resizable:false});
    });
},function(){
    window.location.reload(); 
},{width:300,resizable:false});
}

$(document).ready(function() {    
    $('input:checkbox').change(function(){
        var id = $(this).attr("id").split('/')[0];
        var nombre = $(this).attr("id").split('/')[1];
        if (id!== "" && nombre !== ""){
            if ($(this).is(':checked'))
                des_activar(id,nombre,'activar')
            else
                des_activar(id,nombre,'desactivar')
        }
    });
    $('.instituto, .institutoN').click(function(){
            var cod = $(this).attr('id');
            if(cod !== ''){
                $.blockUI({ message: '<h4 class="thin" style="padding:20px;"><img src="../plantilla/img/standard/loaders/loading16.gif" /> Recuperando la informaci&oacute;n del Instituto, por favor espere...</h4>' });
                    $.get('procesos/instituto_info.php', { instituto: cod})
                    .done(function(data) {
                      $.unblockUI();
                      if (data !== '0'){
                         $.modal({
                            content: data,
                            title: '',
                            width: 500,
                            scrolling: false,
                            actions: {
                                    'Cerrar' : {
                                            color: 'red',
                                            click: function(win) { win.closeModal(); }
                                    }
                            },
                            buttons: {
                                    'Cerrar': {
                                            classes:	'huge blue-gradient glossy',
                                            click:		function(win) { win.closeModal(); }
                                    },
                                    "Modificar Instituto": {
                                            classes:	"huge blue-gradient glossy",
                                            click:   function(win){ pagina = "instituto_modificar.php?id="+cod; location.href=pagina; }
                                    }
                            },
                            buttonsLowPadding: true
                        });
                      }
                      else{
                           $.modal.alert(
                                '<img src="../plantilla/img/standard/error.png"> Error al recuperar los datos del instituto con c&oacute;digo: '+cod +', recargue la p&aacute;gina e intente nuevamente',
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
                 'sEmptyTable':     'Ning�n dato disponible en esta tabla',
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