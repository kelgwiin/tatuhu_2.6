<script type="text/javascript">
var $j = jQuery.noConflict();
    //control de la funcionalidad recuperar contraseña
    $j(document).ready(function(){	

    });
    /*funcion de inicio de sesios que incluye validacion de campos, cuenta activa y autenticacion de usuarios.*/
    function inicio(){
        
        $j("#login").validate({
                rules: {
                nick_usu: {
                        required: true,
                        digits: true
                },			
                pass_usu: {
                        required: true,
                        minlength: 8
                }
        },

        messages: {
                nick_usu: {
                        required: "   Campo obligatorio",
                        digits: "   Ingrese sólo caracteres alfanuméricos"
                },
                pass_usu: {
                        required: "   Campo obligatorio",
                        minlength: jQuery.format("   Ingrese mínimo 8 caracteres")
                }		
        },
        submitHandler: function(form) {
                //$j('#error').text('');
                param = [							 
                     { name : 'loginUsu', value : $j('#nick_usu').val()},
                     { name : 'passUsu', value : $j('#pass_usu').val()}						 
                ];		
                $j.ajax({						
                   type: 'POST',
                   url: '../src/facade/usuarioFacade.php?modo=2',
                   data: param,
                   async: true,
                   dataType: "text",			   				  
                   success: function(data){	
                       //alert(data);
                        if(data == 1){
                            $j('#error').text('');	
                            window.parent.location = ""; //me voy pa el index									
                        }
                        else{
                            $j('#nick_usu').val('');
                            $j('#pass_usu').val('');	
                            $j("#error").hide("slow");
                            $j('#error').text('Usuario o contraseña inválida.');
                            $j("#error").show("slow");
                        }									   	
                   }
                 });
        }
        });
    }

</script>
<div class="art-postcontent">
    <form id="login" name="login" action="" method="post" enctype="application/x-www-form-urlencoded">
        <!--<h1 class="titulos" style="text-align: center; "><span style="color: rgb(50, 64, 73); font-size: 11px; font-weight: normal;"><span style="color: rgb(43, 92, 130); font-size: 18px; font-weight: bold;">Inicio de Sesión</span></span></h1>-->
        <h1><span class="titulosGrandes">Inicio de Sesión</span></h1>
        <table width="100%" align="center">
            <tbody>
                <tr>
                    <td width="45%" class="cajaTexto">Usuario: </td>
                    <td width="55%" class="alertas" ><input maxlength="50" type="text" id="nick_usu" name="nick_usu" value="" onblur="login.nick_usu.value=login.nick_usu.value.toLowerCase();"></input></td>
                </tr>
                <tr>
                    <td width="45%" class="cajaTexto">Contraseña: </td>
                    <td width="55%" class="alertas" ><input maxlength="64" type="password" id="pass_usu" name="pass_usu" value="" onpaste="return false"></input></td>
                </tr>
                <tr height="15px"><td class="alertas" align="center" colspan=2 id="error"></td></tr>
            </tbody>
        </table>
        <table align="center">
            <tbody>
                <tr>
                    <td align="center" >
                        <input type="submit" onclick="inicio()" value="Iniciar Sesi&oacute;n" align="middle"></input>
                    </td>
                </tr>
                <tr>
                    <td align="center" class="style68" style="font-size:11px;padding-top:20px;" ><a href="javascript:ir_pag('./registro/registro.php');"><strong><span>Registrarse</span></strong></a></td>
                </tr>
            </tbody>
        </table>
        <!--<p align="center" class="style68" style="font-size:11px;"><a href="javascript:ir_pag('./recuperar/recuperar.php');"><strong><span id="olvidarPass">Recuperar Contraseña</span></strong></a></p>-->
    </form>
</div>