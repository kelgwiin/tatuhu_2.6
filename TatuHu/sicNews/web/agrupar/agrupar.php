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
    var numDocs, nGrup, nivelBorr, critA, paramParada;
    
    $j(document).ready(function(){
        
         $j("[name='help']").tooltip();
            
        var param = [{ name : 'paramId', value : 1}];

        $j.ajax({
            type: 'POST',
            url:'../src/facade/parametroFacade.php?modo=1',
            async: false,
            dataType: "json",				   
            success: function(data){
                nGrup       = data.num_grupos;
                nivelBorr   = data.nivel_borrosidad;	
                critA       = data.crit_agrupamiento;
                paramParada = data.parametroParada;
                numDocs     = data.num_documentos;
           }
        });
           
    });
    
    $j('#demos').cycle({ 
        fx:      'scrollLeft', 
        next:   '#demos', 
        timeout:  0, 
        easing:  'easeInOutBack' 
    });
    function fcm(){
    
        var param = "";        
        
        $j.ajax({
            type: 'POST',
            url: '../src/facade/fcmFacade.php?modo=1',
            data: param,
            async: true,
            dataType: "text",	
            success: function(data){
         
                matrizU(); 
            }
        }); 
    }
    function vectCarac(){
    
        var param = "";        
        var d = new Date();
        var tiempo = d.getHours()+":"+d.getMinutes()+": "+d.getSeconds()+"\n";
        
        $j.ajax({
            type: 'POST',
            url: '../src/facade/fcmFacade.php?modo=1',
            data: param,
            async: true,
            dataType: "text",	
            success: function(data){

                var d2 = new Date();
                tiempo += d2.getHours()+":"+d2.getMinutes()+": "+d2.getSeconds();   
                mensaje('#dialog-exito');
            }
        }); 
    }
    
    function matrizU(){
    
        var param = [{ name : 'cantDocs', value : numDocs}];

        $j.ajax({
            type: 'POST',
            url: '../src/facade/fcmFacade.php?modo=6',
            data: param,
            async: false,
            dataType: "text",	
            success: function(data){

                $j("#tituloCentros").html("Seleccione "+nGrup+" documentos");
                $j("#centros").html(data);                        

                $j("#dialog-centros").dialog({
                    modal: true,
                    width: 700, 
                    height: 600,
                    resizable: false, 
                    draggable: false,
                    autoOpen: false, 
                    buttons:{				
                            'Aceptar': function(){
                                $j(this).dialog('close');

                                var total   = document.getElementById("formCentr").checkbox;
                                var vect    = new Array();
                                var k = 0;
                                for(i=0;i<total.length;i++){
                                    id = '#id'+i;
                                    if($j(id).is(':checked')){        ;
                                        vect[k]   = $j(id).val();
                                        k = k + 1;
                                    }
                                }
                                if(k == nGrup){
                                    var param = [{ name : 'vectIds', value : vect},
                                                 { name : 'numGr', value : nGrup}
                                                ];
                                    $j.ajax({
                                        type: 'POST',
                                        url: '../src/facade/fcmFacade.php?modo=8',
                                        data: param,
                                        async: true,
                                        dataType: "text",	
                                        success: function(data){
                                            var param = [{ name : 'numGrup', value : nGrup},
                                                         { name : 'NvlBorr', value : nivelBorr},
                                                         { name : 'crtiterio', value : critA},
                                                         { name : 'paramP', value : paramParada},
                                                         { name : 'nDocs', value : numDocs},
                                                        ];

                                            var d = new Date();
                                            var tiempo = d.getHours()+":"+d.getMinutes()+": "+d.getSeconds()+"\n";

                                            $j.ajax({
                                                type: 'POST',
                                                url: '../src/facade/fcmFacade.php?modo=5',
                                                data: param,
                                                async: true,
                                                dataType: "text",	
                                                success: function(data){
                                                    var d2 = new Date();
                                                    tiempo += d2.getHours()+":"+d2.getMinutes()+": "+d2.getSeconds();             
                                                    mensaje('#dialog-exito');
                                                }
                                            });
                                        }
                                    }); 
                                }
                                else{
                                    $j("#mensj-alert").html("Debe elegir "+nGrup+" documentos");
                                    mensaje('#dialog-alerta');
                                }

                            },
                            Salir: function() {
                                    $j(this).dialog('close');
                            }
                    }
                });
                $j("#dialog-centros").dialog('open');
            }            
        });  
    
    }
    //Colocar fechas a noticias
    function etiquetas(){
    
        var param = [{ name : 'cantDocs', value : numDocs}];
        $j.ajax({
            type: 'POST',
            url: '../src/facade/noticiaFacade.php?modo=3',
            data: param,
            async: true,
            dataType: "text",	
            success: function(data){
                mensaje('#dialog-exito');
            }
        });
    
    }
    //Ver grupos en pantalla
    function verGrup(){
        var param = [{ name : 'cantDocs', value : numDocs},
                     { name : 'cantGrup', value : nGrup},
                    ];

        $j.ajax({
            type: 'POST',
            url: '../src/facade/fcmFacade.php?modo=3',
            data: param,
            async: false,
            dataType: "text",	
            success: function(data){
                $j("#gruposNoticias").html(data);
                $j("#dialog-verDoc").toggle("showOrHide");
            }            
        });

    }
    //Calcular similitud promedio
    function similitud(){
    
        var param2 = [{name : 'numGrups', value : nGrup}];
        var temasGrupo = "";
        //Buscar palabras relevantes por grupos
        $j.ajax({
            type: 'POST',
            url: '../src/facade/fcmFacade.php?modo=9',
            data: param2,
            async: true,
            dataType: "json",	
            success: function(data){
                temasGrupo = data;
            }
        });
    
        var param = [{ name : 'cantDocs', value : numDocs},
                     { name : 'cantGrup', value : nGrup},
                    ];
                    
        //Calcular la similitud promedio
        $j.ajax({
            type: 'POST',
            url: '../src/facade/fcmFacade.php?modo=4',
            data: param,
            async: true,
            dataType: "text",	
            success: function(data){
                
                var sp = data.split("\n");
                var linea = "";
                $j("#verSimilitud").html(function(){                                    
                    linea += "<table align=\"center\">";
                    for(i=0;i<nGrup;i++){   
                        linea += "<tr>";    
                        linea += "<td align=\"left\"><div>Grupo "+temasGrupo[i+1]+":</div></td>";
                        linea += "<td align=\"left\"><div>"+sp[i]+"</div></td>";
                        linea += "</tr>";
                    } 
                    linea += "</table>";
                    return linea;                                
                });

                $j("#similitudPromedio").dialog({
                    modal: true,
                    width: 500, 
                    height: 250,
                    resizable: false, 
                    draggable: false,
                    autoOpen: false, 
                    buttons:{				
                            'Aceptar': function(){
                                $j(this).dialog('close');
                            },
                            Salir: function() {
                                $j(this).dialog('close');
                            }
                    }
                });
                $j("#similitudPromedio").dialog('open');
            }            
        });
    }
    
    function elegirCentros(){
                      
        var param = [{ name : 'cantDocs', value : numDocs}];

        $j.ajax({
            type: 'POST',
            url: '../src/facade/fcmFacade.php?modo=6',
            data: param,
            async: false,
            dataType: "text",	
            success: function(data){

                $j("#tituloCentros").html("Seleccione "+nGrup+" documentos");
                $j("#centros").html(data);                        

                $j("#dialog-centros").dialog({
                    modal: true,
                    width: 700, 
                    height: 600,
                    resizable: false, 
                    draggable: false,
                    autoOpen: false, 
                    buttons:{				
                            'Aceptar': function(){
                                $j(this).dialog('close');

                                var total   = document.getElementById("formCentr").checkbox;
                                var vect    = new Array();
                                var k = 0;
                                for(i=0;i<total.length;i++){
                                    id = '#id'+i;
                                    if($j(id).is(':checked')){                ;
                                        vect[k]   = $j(id).val();
                                        k = k + 1;
                                    }
                                }
                                if(k == nGrup){
                                    var param = [{ name : 'vectIds', value : vect},
                                                 { name : 'numGr', value : nGrup}
                                                ];
                                    $j.ajax({
                                        type: 'POST',
                                        url: '../src/facade/fcmFacade.php?modo=8',
                                        data: param,
                                        async: false,
                                        dataType: "text",	
                                        success: function(data){
                                            alert(data);
                                        }
                                    }); 
                                }
                                else{
                                    alert("Debe elegir "+nGrup+" documentos");
                                }

                            },
                            Salir: function() {
                                    $j(this).dialog('close');
                            }
                    }
                });
                $j("#dialog-centros").dialog('open');
            }            
        });   
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
                width: 350, 
                height: 'auto',
                resizable: false, 
                draggable: false,
                autoOpen: false, 
                buttons:{				
                        'Aceptar': function(){
                            $j(this).dialog('close');
                        }
                }
        });
        $j(etiqueta).dialog('open');
    }
</script>

<form id = "valida_form" name="form" action="" method="post" enctype="application/x-www-form-urlencoded">
    <table align="left" width ="100%">
        <tr>
            <td align="left" width ="50%">                    
                <div><span>Para crear un cluster haga click en agrupar.</span></div>
                <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="fcm()" class="art-button">Agrupar</a></span>
                    <img name="help" title="Agrupar documentos: deberá seleccionar la cantidad de documentos que se indique como los mas representativos por grupo" src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/> <br /></p>
            </td>
            <td rowspan="7"  width ="50%">
                <img src="./css/imagenes/agrupa1.jpg" width="400" height="400">
            </td>
        </tr>
        <tr>            
            <td align="left">                    
                <div><span>Calcular solo Vector Caracteristico</span></div>
                <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="vectCarac()" class="art-button">Calcular Vect. Caracteristico</a></span>
                <img name="help" title="Vector Caracteristico: calcular solo el peso de las palabras por documento " src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/><br /></p>
            </td>
        </tr>
        <tr>
            <td align="left">                    
                <div><span>Calcular matriz de pertinencias</span></div>
                <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="matrizU()" class="art-button">Calcular Matriz de Pertinencia</a></span>
                <img name="help" title="Matriz de pertinencia: calcular grupos, seleccionar documentos mas representativos por grupo" src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/><br /></p>
            </td>
        </tr>
        <tr>
            <td align="left">                    
                <div><span>Fechar documentos</span></div>
                <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="etiquetas()" class="art-button">Rango de Fecha</a></span> 
                <img name="help" title="Calcular rango de fechas al que pertenecen los documentos" src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/><br /></p>
                
            </td>
        </tr>
        <tr>
            <td align="left">              
                <div><span>Ver los grupos</span></div>
                <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="verGrup()" class="art-button">Ver Grupos</a></span>
                <img name="help" title="Vista general a los grupos formados" src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/><br /></p>
            </td>
        </tr>
        <!--<tr>
            <td align="left">  
                <div><span>Calcular similitud promedio</span></div>
                <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="similitud()" class="art-button">Similitud Promedio</a></span>
                    <img name="help" title="Determina que tan homogeneo son los grupos. Mientras el valor sea mas cercano a 1 mas homogeneo es" src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/> <br /></p>
            </td>
        </tr>-->
        <tr>
            <td align="left">  
                <div><span>Limpiar Sistema</span></div>
                <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="eliminarDoc()" class="art-button">Limpiar Sistema</a></span>
                    <img name="help" title="Eliminar de la Base de Datos las noticias guardadas. La opcion 'eliminar todas' inicializa totalmente el sistema, es decir queda vacío. NOTA: Debe realizar el proceso de agrupamiento nuevamente y de ser necesario, subir documentos nuevos al sistema" src="./css/imagenes/help-icon.png" align="middle" width="17px" height="17px"/> <br /></p>
            </td>
        </tr>
    </table>
</form>

<div id="dialog-verDoc" style="display:none" title="Vista de Grupos">
    <table align="center" width="100%">
        <tr>
            <td>
                <div id="gruposNoticias" style="padding:10px 10px; width:auto; height:500px; overflow-y: auto;"></div>
            </td>
        </tr>
    </table>
</div>

<div id="dialog-centros" style="display:none" title="Eleccion de Centros">
    <table align="center" width="100%">
        <tr>
            <td>
                <div id="tituloCentros" align="center"></div>
                <form id="formCentr">
                    <div id="centros" style="padding:10px 10px;"></div>
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

<div id="similitudPromedio" style="display:none" title="Similitud Promedio">
    <table width="100%" CELLSPACING="7" align="center">
        <tr>
            <td align="center">
                <h1><div class="titulosGrandes">La similitud promedio es evaluada en el rango [0,1]</div></h1></br>
                <div id="verSimilitud" title=""></div>       
            </td>
        </tr>
    </table>
</div>
<!--<img id="load" src="./css/imagenes/cargando1.gif" style="display:none; top:50%;left:50%;z-index:1;"  width="40px" height="40px">-->