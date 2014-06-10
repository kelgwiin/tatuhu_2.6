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
    var nGrup, nivelBorr, critA, paramParada;
    $j(document).ready(function(){	
        
        $j("[name='help']").tooltip();
        var param = [{ name : 'paramId', value : 1}];

        $j.ajax({
            type: 'POST',
            url:'../src/facade/parametroFacade.php?modo=1',
            async: false,
            dataType: "json",				   
            success: function(data){
                /*$j('#cantGrup2').text(data.num_grupos);
                $j('#nvlBorr2').text(data.nivel_borrosidad);	
                $j('#critAgrup2').text(data.crit_agrupamiento);			
                $j('#paraParad2').text(data.parametroParada);
                $j('#cantTerm2').text(data.num_terminos);*/
                
                
                $j('#cantGrup').val(data.num_grupos);
                $j('#nvlBorr').val(data.nivel_borrosidad);	
                //$j('#critAgrup').val(data.crit_agrupamiento);			
                $j('#paraParad').val(data.parametroParada);
                $j('#cantTerm').val(data.num_terminos);
                $j('#proxy').val(data.proxy);
           }

        });

    });
    
    function enviar(){

        nGrup = $j('#cantGrup').val();
        nivelBorr = $j('#nvlBorr').val();
        //critA = $j('#critAgrup').val();
        paramParada = $j('#paraParad').val();
        proxy = $j('#proxy').val();
        param = [
            { name : 'numGrup', value: nGrup},
            { name : 'nivelB', value: nivelBorr},
            //{ name : 'critAgp', value:critA},					 
            { name : 'paramP', value: paramParada},
            { name : 'proxy', value: proxy}	
        ];

        $j.ajax({
            type: 'POST',
            url:'../src/facade/parametroFacade.php?modo=2',
            data: param,
            async: false,
            success: function(data){
                if(data == 1){
                    //$j(this).dialog('close');
                    mensaje('#dialog-exito');
                }
                else{
                    mensaje('#dialog-error');
                }
            }
        });
        
    }
    
    function mensaje(etiqueta){
        $j(etiqueta).dialog({
                modal: true,
                width: 400, 
                height: 'auto',
                resizable: false, 
                draggable: false,
                autoOpen: false, 
                buttons:{				
                        'Aceptar': function(){
                            $j(this).dialog('close');
                            window.parent.location = "";
                        }
                }
        });
        $j(etiqueta).dialog('open');
    }

</script>

<h1><span class="titulosGrandes">Edición de Parametros</span></h1>
<br></br>
<form id="login" name="parametro" action="" method="post" enctype="application/x-www-form-urlencoded">
    <table width="100%" align="left" >
        <tbody>
            <tr>
                <td align="center" colspan="2">
                    <br></br>
                    <h1><span class="cajaTexto">Editar valores actuales</span></h1>
                    <br>
                </td>
            </tr>
            <tr>
                <td width="45%" class="cajaTexto">Cantidad de Grupos: </td>
                <td width="55%" class="alertas" >
                    <input maxlength="50" type="text" id="cantGrup" name="cantGrup" value=""/>
                    <img name="help" title="La cantidad de grupos a formar esta relacionada a la cantidad de eventos a analizar. Si tu repositorio trata n eventos, entonces rezlair n grupos" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/>
                </td>
            </tr>
            <tr>
                <td width="45%" class="cajaTexto">Nivel de Borrosidad: </td>
                <td width="55%" class="alertas" >
                    <input maxlength="64" type="text" id="nvlBorr" name="nvlBorr" value="" onpaste="return false"/>
                    <img name="help" title="Indica que tan homogeneos seran los grupos entre si. El nivel de borrosidad ideal para 3 grupos es: 1.22631" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/>
                </td>
            </tr>
            <tr>
                <td width="45%" class="cajaTexto">Parametro de Parada: </td>
                <td width="55%" class="alertas" ><input disabled maxlength="50" type="text" id="paraParad" name="paraParad" value=""/>
                <img name="help" title="Indica cuando detener el agrupamiento. Mientras mas cercano a 0 mas exacto puede ser. Se recomienda no manipular este valor" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/>
                </td>
            </tr>
            <tr>
                <td width="45%" class="cajaTexto">Tamaño Vect. Caracter&iacute;stico: </td>
                <td width="55%" class="alertas" ><input maxlength="50" type="text" id="cantTerm" name="cantTerm" value=""/>
                <img name="help" title="Este valor indica la cantidad de palabras a analizar por documento. Para computadores con memoria RAM de 2 GB y doble nucleo se recomienda un vector de tamaño maximo 6457" src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/>
                </td>
            </tr>
            <tr>
                <td width="45%" class="cajaTexto">Proxy: </td>
                <td width="55%" class="alertas" ><input maxlength="50" type="text" id="proxy" name="proxy" value=""/>
                <img name="help" title="Para sistemas bajo proxy, ingrese en este campo el mismo. Ejemplo: 192.100.10.100:2343. NOTA:Si no hay proxy dejar en blanco " src="./css/imagenes/help-icon.png" align="top" width="17px" height="17px"/>
                </td>
            </tr>
            <tr><td class="alertas" align="center" colspan=2 height="20px" id="error"></td></tr>
            <tr>
                <td colspan=2 align="center" >
                    <p><span class="art-button-wrapper"><span class="art-button-l"> </span><span class="art-button-r"> </span><a onclick="enviar()" class="art-button">Guardar Cambios</a></span> <br /></p>
                </td>
            </tr>
        </tbody>
    </table>
</form>
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
                <div id="mensj-alert"></div>
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
