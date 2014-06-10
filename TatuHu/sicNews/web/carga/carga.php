<?php  			
    require_once('../../src/usuario/validarSesion.php');
    bloqueo_url();
?>
<style>
.ui-tooltip
{
    font-size:10pt;
    font-family:Calibri;
}
</style>
<script type="text/javascript">
    var $j = jQuery.noConflict();
    var numDocs;
    $j("[name='help']").tooltip();
    $j(document).ready(function() {    
        
        var param = [{ name : 'paramId', value : 1}];

        $j.ajax({
            type: 'POST',
            url:'../src/facade/parametroFacade.php?modo=1',
            async: false,
            dataType: "json",				   
            success: function(data){
                numDocs = data.num_documentos;
           }
        });

       $j.ajax({
            type: 'POST',
            url:'../src/facade/parametroFacade.php?modo=3',
            async: false,
            dataType: "json",				   
            success: function(data){
               if(data == 0){
                    $j('#noticiaNueva').text(data);
                    $j('#pluralSingular').text("NOTICIAS");
                    $j('#MasMenos').text("NUEVAS");
                }
                else{
                    if(data > 0){
                        if(data == 1){ 
                            $j('#noticiaNueva').text(data);
                            $j('#pluralSingular').text("NOTICIA");
                            $j('#MasMenos').text("NUEVAS");
                        }
                        else{
                            $j('#noticiaNueva').text(data);
                            $j('#pluralSingular').text("NOTICIAS");
                            $j('#MasMenos').text("NUEVAS");
                        }
                    }
                    else{
                        if((data*(-1)) == 1){                        
                            $j('#noticiaNueva').text(data*(-1));
                            $j('#pluralSingular').text("NOTICIA");
                            $j('#MasMenos').text("MENOS");
                        }
                        else{
                            $j('#noticiaNueva').text(data*(-1));
                            $j('#pluralSingular').text("NOTICIAS");
                            $j('#MasMenos').text("MENOS");
                        }
                    }

                }


           }

        });

        $j('#file_upload').uploadify({
            'uploader'  : './js/uploadify-v2.1.4/uploadify.swf',
            'script'    : '../src/carga/carga_archivo.php',
            'cancelImg' : './js/uploadify-v2.1.4/cancel.png',
            'folder'    : "./files",
            'buttonText'  : 'Buscar Archivos',
            'auto'      : false,
            'multi'     : true,
            'checkScript' : './js/uploadify-v2.1.4/check.php',
            'expressInstall' : './js/uploadify-v2.1.4/expressInstall.swf'
        });
        
        //$j(function () {
            //$j('.checkall').click(function () {
                //$j(this).find(':checkbox').attr('checked', this.checked);
            //});
        //});

    });
    function guardarPags(){
        
        //var total = $j("input:checked").length;
        var total   = document.getElementById("formulario").checkbox;
        var vect    = new Array();
        var fchPub  = new Array();
        var titulo  = new Array();
        var k = 0;
        //alert(total.length);
        for(i=0;i<total.length;i++){
            id = '#id'+i;
            //alert('\''+id+'\'');
           //alert($j(id).is(':checked'));
           //alert(total[i].checked);
            if($j(id).is(':checked')){
                //alert($j(id).val());                
                var linea = $j(id).val().split("<>");
                vect[k]   = linea[0];
                fchPub[k] = linea[1];
                titulo[k] = linea[2]+"##";
                k = k + 1;
            }
        }
        if(k>0){
            var param = [{name : 'vectNotc', value : vect},
                         {name : 'fechPub', value : fchPub},
                         {name : 'titulos', value : titulo}
                        ];

            $j.ajax({
                type: 'POST',
                url:'../src/facade/noticiaFacade.php?modo=6',
                data: param,
                async: true,
                dataType: "text",				   
                success: function(data){
                    mensaje('#dialog-exito');
               }

            });
        }
        else{
            $j("#mensj-alert").html("Debe seleccionar al menos una noticia");
            mensaje('#dialog-alerta');
        }
    
    }
    function verRss(){
    
        var param = "";
        $j.ajax({
            type: 'POST',
            url:'../src/facade/rssFacade.php?modo=2',
            data: param,
            async: true,
            dataType: "text",				   
            success: function(data){

                if(data != -1){
                    var param = "";
                    $j.ajax({
                        type: 'POST',
                        url:'../src/facade/rssFacade.php?modo=1',
                        data: param,
                        async: true,
                        dataType: "text",				   
                        success: function(data){

                            if(data != -1){
                                $j("#contenidoRss").html(data); 
                                $j("#dialog-verRss").dialog({
                                    modal: true,
                                    width: 'auto', 
                                    height: 600,
                                    resizable: false, 
                                    draggable: false,
                                    autoOpen: false, 
                                    buttons:{				
                                            'Aceptar': function(){
                                                $j(this).dialog('close')
                                                guardarPags();
                                            },
                                            Salir: function() {
                                                    $j(this).dialog('close');
                                            }
                                    }
                                });
                                $j("#dialog-verRss").dialog('open');
                            }
                            else{
                                mensaje('#dialog-error'); 
                            }
                       }

                    });
                }
                else{
                    $j("#mensj-alert").html("Debe insertar en la base de datos un enlace Rss");
                    mensaje('#dialog-alerta');
                }
           }

        });
        
    }
    
    function agregar(){
        
        $j("#dialog-agregar-rss").dialog({
            modal: true,
            width: 400, 
            height: 'auto',
            resizable: false, 
            draggable: false,
            autoOpen: false, 
            buttons:{	
                    'Aceptar': function(){
    
                        /*$j("#login").validate({
                                    rules: {
                                    nick_usu: {
                                            required: true,
                                            url: true
                                    }
                            },

                            messages: {
                                    urlRss: {
                                            required: "   Campo obligatorio",
                                            url: "   Ingrese una direccion valida"
                                    }		
                            },
                            submitHandler: function(form) {*/
                                
                                if($j('#urlRss').val() != ""){

                                    var direc = $j('#urlRss').val();                            
                                    var param = [{name : 'url', value : direc}];

                                    $j.ajax({
                                        type: 'POST',
                                        url:'../src/facade/rssFacade.php?modo=3',
                                        data: param,
                                        async: true,
                                        dataType: "text",				   
                                        success: function(data){
                                            if(data == 1){
                                                $j('#urlRss').val("")
                                                mensaje('#dialog-exito');                                        
                                            }
                                            else{
                                                if(data == -1){
                                                    $j("#mensj-alert").html("La direccion agregada ya existe, intente con otra");
                                                    mensaje('#dialog-alerta');
                                                }
                                                else{
                                                 $j('#urlRss').val("")
                                                    mensaje('#dialog-error');                                           
                                                }
                                            }
                                       }

                                    });

                                    $j(this).dialog('close');
                                }
                                else{
                                    $j("#error").hide("slow");
                                    $j("#error").html("Debe introducir un URL");
                                    $j("#error").show("slow");
                                }

                            /*}
                        });*/

                    },
                    Salir: function() {
                            $j(this).dialog('close');
                    }
            }
        });
        $j("#dialog-agregar-rss").dialog('open');

    }
    function demoRss(){
        $j('#demos').cycle({ 
            fx:      'scrollLeft', 
            next:   '#demos', 
            timeout:  0, 
            easing:  'easeInOutBack' 
        });
        $j("#dialog-demoRss").dialog({
            modal: true,
            width: 700, 
            height: 'auto',
            resizable: false, 
            draggable: false,
            autoOpen: false, 
            buttons:{	
                    Salir: function() {
                            $j(this).dialog('close');
                    }
            }
        });
        $j("#dialog-demoRss").dialog('open');
    }
    function eliminarRss(){
    
        var param = "";
        $j.ajax({
            type: 'POST',
            url:'../src/facade/rssFacade.php?modo=4',
            data: param,
            async: false,
            dataType: "text",				   
            success: function(data){                

                if(data != -1){                    
                    
                    $j("#listRss").html(data);

                    $j("#dialog-eliminar-rss").dialog({
                        modal: true,
                        width: 'auto', 
                        height: 300,
                        resizable: false, 
                        draggable: false,
                        autoOpen: false, 
                        buttons:{	
                                'Aceptar': function(){
                                    
                                    $j("#mensj-alert").html("¿Esta seguro que desea continuar?, esta acci&oacute;n no se puede revertir");
                                            
                                    $j("#dialog-alerta").dialog({
                                            modal: true,
                                            width: 500, 
                                            height: 'auto',
                                            resizable: false, 
                                            draggable: false,
                                            autoOpen: false, 
                                            buttons:{				
                                                    'Aceptar': function(){
                                                        $j(this).dialog('close');
                                                        $j("#dialog-eliminar-rss").dialog('close');
                                                        eliminarRssAux();  
                                                    },
                                                    'Cancelar': function(){
                                                        $j(this).dialog('close');
                                                    }
                                            }
                                    });
                                    
                                    $j("#dialog-alerta").dialog('open');
                                },
                                Salir: function() {
                                        $j(this).dialog('close');
                                }
                        }
                    });
                    $j("#dialog-eliminar-rss").dialog('open');

        
                }
                else{
                    $j("#mensj-alert").html("No hay enlaces que eliminar en la base de datos");
                    mensaje('#dialog-alerta');
                }
           }

        });
        
    }
    
    function eliminarRssAux(){

        var total   = document.getElementById("formElimRss").checkbox;
        var vect    = new Array();
        var k = 0;
        for(i=0;i<total.length;i++){
            id = '#id'+i;
            if($j(id).is(':checked')){
                vect[k]   = $j(id).val();
                k = k + 1;
            }
        }
        
        if(k>0){
            
            var param = [{name : 'vectRss', value : vect}];
            
            $j.ajax({
                type: 'POST',
                url:'../src/facade/rssFacade.php?modo=5',
                data: param,
                async: false,
                dataType: "text",
                success: function(data){
                    if(data == 1){
                        mensaje('#dialog-exito');
                    }              
                    else{
                        mensaje('#dialog-error');
                    }
                }
            });
        }
    
    }
    
    function eliminarDoc(){
    
        var param = "";

        $j.ajax({
            type: 'POST',
            url:'../src/facade/noticiaFacade.php?modo=7',
            data: param,
            async: false,
            dataType: "text",				   
            success: function(data){

                if(data != -1){
                    
                    $j("#ListaDocs").html(data); 
                    $j("#dialog-eliminar-doc").dialog({
                        modal: true,
                        width: 650, 
                        height: 550,
                        resizable: false, 
                        draggable: false,
                        autoOpen: false, 
                        buttons:{				
                                'Aceptar': function(){
                                    
                                    $j("#mensj-alert").html("¿Esta seguro que desea continuar?, esta acci&oacute;n no se puede revertir");
                                            
                                    $j("#dialog-alerta").dialog({
                                            modal: true,
                                            width: 500, 
                                            height: 'auto',
                                            resizable: false, 
                                            draggable: false,
                                            autoOpen: false, 
                                            buttons:{				
                                                    'Aceptar': function(){
                                                        $j(this).dialog('close');
                                                        $j("#dialog-eliminar-doc").dialog('close');
                                    
                                                        var total   = document.getElementById("formElimDocs").checkbox;
                                                        var vect    = new Array();
                                                        var k = 0;
                                                        //alert($j('#id'+0).val());
                                                        for(i=0;i<total.length;i++){
                                                            id = '#id'+i;
                                                            if($j(id).is(':checked')){            
                                                                vect[k]   = $j(id).val();
                                                                k = k + 1;
                                                            }
                                                        }
                                                        if(k>0){

                                                            var param = [{name : 'vectNotc', value : vect}];

                                                            $j.ajax({
                                                                type: 'POST',
                                                                url:'../src/facade/noticiaFacade.php?modo=8',
                                                                data: param,
                                                                async: false,
                                                                dataType: "text",				   
                                                                success: function(data){                                                                    
                                                                    if(data == 1){
                                                                        mensaje('#dialog-exito');
                                                                    }
                                                                    else{
                                                                        mensaje('#dialog-error')
                                                                    }                                                                    
                                                               }

                                                            });
                                                        }
                                                        else{
                                                            $j("#mensj-alert").html("Debe seleccionar al menos una noticia");
                                                            mensaje('#dialog-alerta');
                                                        }
                                                    },
                                                    'Cancelar': function(){
                                                        $j(this).dialog('close');
                                                    }
                                            }
                                    });
                                    
                                    $j("#dialog-alerta").dialog('open');
                                        
                                },
                                Salir: function() {
                                        $j(this).dialog('close');
                                }
                        }
                    });
                    $j("#dialog-eliminar-doc").dialog('open');
                }
                else{
                    $j("#mensj-alert").html("No hay Documentos para Eliminar");
                    mensaje('#dialog-alerta');
                }
                
            }
       });
    }
    function borrarTodos(){
        var vect = new Array();
        for(i=1;i<=numDocs;i++){
            vect[i] = i;
        }

        var param = [{name : 'vectNotc', value : vect}];

        $j.ajax({
            type: 'POST',
            url:'../src/facade/noticiaFacade.php?modo=8',
            data: param,
            async: false,
            dataType: "text",				   
            success: function(data){                                                                    
                if(data == 1){
                    $j("#dialog-eliminar-doc").dialog('close');
                    mensaje('#dialog-exito');
                }
                else{
                    $j("#dialog-eliminar-doc").dialog('close');
                    mensaje('#dialog-error')
                }                                                                    
           }

        });
    }
    function mensaje(etiqueta){
        $j(etiqueta).dialog({
                modal: true,
                width: 450, 
                height: 'auto',
                resizable: false, 
                draggable: false,
                autoOpen: false, 
                buttons:{				
                        'Aceptar': function(){
                            $j(this).dialog('close');
                            //window.parent.location = "";
                        }
                }
        });
        $j(etiqueta).dialog('open');
    }

    function verCorreo(){
        
        $j("#dialog-correo").dialog({
            modal: true,
            width: 700, 
            height: 600,
            resizable: false, 
            draggable: false,
            autoOpen: false, 
            buttons:{				
                    'Aceptar': function(){
                        $j(this).dialog('close')
                    },
                    Salir: function() {
                            $j(this).dialog('close');
                    }
            }
        });
        $j("#dialog-correo").dialog('open');
    
    }
    
function jqCheckAll( id, name, flag )
{
    if (flag == 0)
    {
        $j("form#" + id + " INPUT[@name=" + name + "][type='checkbox']").attr('checked', false);
    }
    else
    {
        $j("form#" + id + " INPUT[@name=" + name + "][type='checkbox']").attr('checked', true);
    }
    /*
     *        if (flag == 0)
        {
            $("#formulario").attr('checked', false);
        }
        else
        {
            $("#formulario").attr('checked', true);
        }*/
}
    
</script>
<h1><span class="titulosGrandes">Gestion de Archivos y Rss</span></h1>
<br></br>
<br></br>
<table width="100%" align="center" >
    <tr>
        <td width="50%">
            <table align="left" CELLPADDING="5" CELLSPACING="5">
                <tr>
                    <td align="left">
                        <h1><span class="titulosGrandes">Manejo de Rss &nbsp;</span><img name="help" onclick="demoRss()" title="Haga click para ver demostracion del RSS" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/></h1>
                    </td>
                </tr>
                <tr>
                    <td>            
                        <div><span>Si desea buscar noticias para descargar, haga click en ver Rss</span></div>
                        <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="verRss()" class="art-button">Ver Rss</a></span> <br /></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td colspan="2">
                                    <div><span>Para Agregar o Eliminar enlaces Rss, haga click en el boton correspondiente</span></div>    
                                </td>
                            </tr>
                            <tr>
                                <td width="34%">
                                    <div><p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="agregar()" class="art-button">Agregar enlace</a></span> <br /></p></div>
                                </td>
                                <td width="66%" align="left">
                                    <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="eliminarRss()" class="art-button">Eliminar enlace</a></span> <br /></p>                     
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <h1><span class="titulosGrandes">Documentos en Base de Datos</span></h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div><span>Para eliminar noticias de la Base de Datos, haga click en Eliminar</span></div>
                        <div><p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="eliminarDoc()" class="art-button">Eliminar</a></span> <br /></p></div>
                    </td>
                </tr>
            </table>
        </td> 
        <td width="50%">
            <table align="left">
                <tr>
                    <td>
                        <table align="center" >
                            <tr>
                                <td colspan="2">
                                    <h1><span class="titulosGrandes">Buscar Archivos para subir</span></h1>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="busqueda">
                                        <input id="file_upload" name="file_upload" type="file" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <div align="right">
                                       <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a href="javascript:$j('#file_upload').uploadifyUpload();" class="art-button">Subir Archivos</a></span> <br /></p>
                                    </div> 
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>   
    </tr>
</table>

<div id="dialog-demoRss"  style="display:none" title="Demostracion">
    <table align="center" width ="100%">
        <tr>
            <td align="center">
                <h1><span class="titulosGrandesRojo">Click en la imagen para  ver siguiente</span>
            </td>
        </tr>
        <tr>
            <td align="center">                
                <div style="cursor:pointer" id="demos">
                    <img src="./css/imagenes/paso0.jpg" width="400" height="400">
                    <img src="./css/imagenes/paso1.jpg" width="400" height="400">
                    <img src="./css/imagenes/paso2.jpg" width="400" height="400">
                    <img src="./css/imagenes/paso3.jpg" width="400" height="400">
                </div>
            </td>
        </tr>
    </table>
</div> 

<div id="dialog-verRss" style="display:none" title="Noticias Actuales">
    <table align="center" width ="100%">
        <tr>
            <td>                
                <form id="formulario">
                    <h1><div class="titulosGrandes">Seleccione una noticia para guardar</div></h1></br>
                    <div><a href="javascript:jqCheckAll('formulario', 'checkbox', 1);" class="art-button">Seleccionar todas </a>/<a href="javascript:jqCheckAll('formulario', 'checkbox', 0);" class="art-button">Deseleccionar todas</a></div>
                    <!--<input type="button" name="ca_v2_on" value="Click Aqui" onclick="jqCheckAll('formulario', 'checkbox', 1);"/>-->
                    <div id="contenidoRss" style="width:auto; height:500px;"></div>
                </form>
            </td>
        </tr>
    </table>
</div> 

<div id="dialog-agregar-rss" style="display:none" title="Agregar fuente Rss">
    </br>
    <table align="center" width ="100%">
        <tr>
            <td width ="50%" align="left" class="alertas" >
                <div><span class="cajaTexto">Introduzca el URL del Rss que desea agregar:</span></div>
                </br>
                <div><input size="50" maxlength="90" type="text" id="urlRss" name="urlRss" value=""></input></div>
                <div class="alertas" id="error"></div>
            </td>
        </tr>
    </table>
</div> 

<div id="dialog-eliminar-rss" style="display:none" title="Eliminar Rss">
    </br>
    <table align="center">
        <tr>
            <td>
                <div>Seleccione las fuentes RSS que desea eliminar</div>
                <form id="formElimRss">
                    <div id="listRss" style="padding:10px 10px;"></div>
                </form>
            </td>
        </tr>
    </table>
</div> 

<div id="dialog-eliminar-doc" style="display:none" title="Eliminar Documentos">
    </br>
    <table align="center" width ="100%">
        <tr>
            <td>
                <form id="formElimDocs">
                    <span class="titulosGrandes">Eliminar todos </span><a href="javascript:borrarTodos();" style="text-decoration:none; color: black;">(aqui)</a>
                    <div id="ListaDocs" style="padding:10px 10px;"></div>
                </form>
            </td>
        </tr>
    </table>
</div> 

<div id="dialog-exito" style="display:none" title="Exito">
    <table align="center">
        <tr>
            <td><img src="./css/imagenes/check.png" width="40px" height="40px"/></td>
            <td class="cajaTexto">
                <p>Operacion Realizada con Exito</p>
            </td>
        </tr>
    </table>
</div> 

<div id="dialog-error" style="display:none" title="Error...">
    <table align="center">
        <tr>
            <td><img src="./css/imagenes/dialog-error.png" width="40px" height="40px"/></td>
            <td class="cajaTexto">
                <p>Ocurrio un error inseperado, por favor intente nuevamente.</p>
            </td>
        </tr>
    </table>
</div> 

<div id="dialog-alerta" style="display:none" title="Atenci&oacute;n">
    <table align="center">
        <tr>
            <td><img src="./css/imagenes/alert-warning.png" width="40px" height="40px"/></td>
            <td class="cajaTexto">
                <!--<p>¿Esta seguro que desea continuar?, esta acci&oacute;n no se puede revertir.</p>-->
                <div id="mensj-alert"></div>
            </td>
        </tr>
    </table>
</div> 

