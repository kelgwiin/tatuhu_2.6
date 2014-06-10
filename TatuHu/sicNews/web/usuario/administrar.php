<?php  			
    require_once('../../src/usuario/validarSesion.php');
    bloqueo_url();
    session_start();
?>
<style>
.ui-tooltip
{
    font-size:10pt;
    font-family:Calibri;
}
</style>
<script type="text/javascript">
$j(document).ready(function(){ 
    $j("[name='help']").tooltip();
    //CONSULTAR USUARIOS
    $j.ajax({
        type: 'POST',
        url:'../src/facade/usuarioFacade.php?modo=3',
        async: false,
        dataType: "json",				   
        success: function(data){
            var html = '', usuario = '';
            if(data.length > 1){
                var titulo = '';
                $j.each(data, function(key,val){
                    if("<?php echo $_SESSION['idUsu']; ?>" != val.id){
                        if(val.activo == 1)
                            titulo = "inactivar";
                        else
                            titulo = "activar"
                        
                        if(val.tipo_usu == 1)
                            usuario = "Usuario";
                        else
                            usuario = "Administrador";
                        
                        html += '<tr>';
                        html += '<td align="center">'+usuario+'</td>\n';  
                        html += '<td align="center"><a href="#" name="nombre_usu" data-pk="'+val.id+'">'+val.nombre+'</a></td>\n';  
                        html += '<td align="center"><a href="#" name="user" data-pk="'+val.id+'">'+val.user+'</a></td>\n'; 
                        html += '<td align="center"><a href="#" name="pass_usu" data-pk="'+val.id+'"></a></td>\n'; 
                        html += '<td align="center"><input type="hidden" name="estatus_usr'+val.id+'" value="'+val.activo+'"><img id="change-'+val.id+'" title="Click aqui para '+titulo+'" name="change" src="./css/imagenes/'+val.activo+'.jpg" width="17px" height="17px" /></td>\n'; 
                        html += '<td align="center"><img id="delete-'+val.id+'" title="Click para eliminar" name="delete" src="./css/imagenes/delete3.png" width="17px" height="17px" /></td>\n'; 
                        html += '</tr>';
                    } 
                });                
            }
            else{
                html += '<tr><td align="center" colspan="6"><b>No hay usuarios para mostrar</b></td></tr>';
            }
            
            $j('#tableUser tr:last').after(html);
        }
    });
    //CAMBIAR ESTATUS USUARIO (ACTIVO/INACTIVO)
    $j("[name='change']").click(function() {    

        var name = "estatus_usr"+this.id.split("-")[1];
        var status = ($j("[name="+name+"]").val() == '1' ? '0' : '1');
        var param = [{ name : 'idUser', value : this.id.split("-")[1]},
                     { name : 'status', value : status}
                    ];
        $j.ajax({
            type: 'POST',
            url:'../src/facade/usuarioFacade.php?modo=4',
            data: param,
            async: false,
            dataType: "text",				   
            success: function(data){
                if(data == '1'){
                    $j("#contenido").load("<?php echo $_SERVER['PHP_SELF'];?>");
                }
                return true;
           }
        });
    });
    //ELIMINAR USUARIO
    $j("[name='delete']").click(function() {
        $j("#mensj-alert").html("¿Esta seguro de querer eliminar el usuaio?");
        mensaje_delete('#dialog-alerta',this.id.split("-")[1]);
    });
    
    function mensaje_delete(etiqueta,idUs){
        $j(etiqueta).dialog({
                modal: true,
                width: 400, 
                height: 'auto',
                resizable: false, 
                draggable: false,
                autoOpen: false, 
                buttons:{				
                        Aceptar: function(){
                            var param = [{ name : 'idUser', value : idUs}];
                            $j.ajax({
                                type: 'POST',
                                url:'../src/facade/usuarioFacade.php?modo=5',
                                data: param,
                                async: false,
                                dataType: "text",				   
                                success: function(data){
                                    location.reload();
                               }
                            });
                            $j(this).dialog('close');
                        },
                        Cancelar: function() {
                            $j(this).dialog('close');
                        }
                }
        });
        $j(etiqueta).dialog('open');
    }

    //EDICION IN-LINE
    $j("[name='nombre_usu']").editable({
        type: 'text',
        url:'../src/facade/usuarioFacade.php?modo=6',
        name: "nombre_usu",
        title: 'Escriba Nombre',
        ajaxOptions: {
            dataType: 'text'
        },
        success: function(response, newValue) {
            if(response == "-1")
                return "El nombre de usuario ya existe";
            else if(!response)
                return "No se pudo actualizar";
            if(response.success === false) {
                console.log(response.msg);
                 return response.msg;
            }
        }        
    });
    $j("[name='user']").editable({
        type: 'text',
        url:'../src/facade/usuarioFacade.php?modo=6',
        name: "user",
        title: 'Escriba Usuario nuevo',
        validate: function(value) {
            if($j.trim(value) == '') {
                return 'Debe llenear el campo';
            }
        },
        ajaxOptions: {
            dataType: 'text'
        },
        success: function(response, newValue) {
            if(response == "-1")
                return "El nombre de usuario ya existe";
            else if(!response)
                return "No se pudo actualizar";

            if(response.success === false) {
                console.log(response.msg);
                 return response.msg;
            }
        }        
    });
    $j("[name='pass_usu']").editable({
        type: 'text',
        url:'../src/facade/usuarioFacade.php?modo=6',
        name: "pass_usu",
        title: 'Escriba Contraseña nueva',
        defaultValue: '',
        emptytext: 'editar',
        validate: function(value) {
            if($j.trim(value) == '') {
                return 'Debe llenear el campo';
            }
        },
        ajaxOptions: {
            dataType: 'text'
        },
        success: function(response, newValue) {
            if(response == "-1")
                return "Ingrese minimo 8 caracteres";
            else if(!response)
                return "No se pudo actualizar";
            $j("#contenido").load("<?php echo $_SERVER['PHP_SELF'];?>");
        }        
    });
});
</script>
<h1><span class="titulosGrandes">Administrar usuarios</span></h1>
<br></br>
<div  id="enlaces" class="cuadroUser">
<form id="admin" name="admin" action="" method="post" enctype="application/x-www-form-urlencoded">
    <table id="tableUser" width="100%" align="center" valign="top" cellpadding="10" >
        <tr>
            <td align="center" width="15%"><div><b>Tipo&nbsp;</b><img name="help" title="Indica si la cuenta es Administrador o Usuario" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/></div></td>
            <td align="center" width="25%"><div><b>Nombre&nbsp;</b><img name="help" title="Nombre de los usuarios. Haz click en el nombre para editar" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/></div></td>
            <td align="center" width="15%"><div><b>Usuario&nbsp;</b><img name="help" title="Cuenta de usuario (login). Haz click en el nombre para editar" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/></div></td>
            <td align="center" width="15%"><div><b>Contraseña&nbsp;</b><img name="help" title="Haz click en 'editar' para cambiar la contraseña" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/></div></td>
            <td align="center" width="15%"><div><b>Estatus&nbsp;</b><img name="help" title="Haga click en el icono para Activar/Inactivar. Verde indica usuario activo. Rojo indica inactivo" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/></div></td>
            <td align="center" width="15%"><div><b>Eliminar&nbsp;</b><img name="help" title="Click en la equis para eliminar cuenta de usuario" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/></div></td>
        </tr>
    </table>
</form>    
</div>
<br><br>
<div id="dialog-alerta" style="display:none" title="Atenci&oacute;n">
    <table align="center">
        <tr>
            <td><img src="./css/imagenes/alert-warning.png" width="40px" height="40px"/></td>
            <td class="cajaTexto">
                <div id="mensj-alert"></div>
            </td>
        </tr>
    </table>
</div> 
