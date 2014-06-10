<script type="text/javascript">
var email, pass1, pass2, nick, id, pregS, respS, tipo_usu;

$j(document).ready(function(){
    
});

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

function validar(){    
    $j("#registro").validate({
            rules: {
                    nomb_usu: {
                            required: true,
                            digits: true
                    },
                    nick_usu: {
                            required: true,
                            digits: true
                    },			
                    pass_usu1: {
                            required: true,
                            minlength: 8
                    },
                    pass_usu2: {
                            required: true,				
                            equalTo: "#pass_usu1"
                    },
                    mail_usu: {
                            required: true,
                            email: true				
                    },
                    preg_usu: {
                            required: true							
                    },
                    resp_usu: {
                            required: true							
                    }
            },
            messages: {
                    nomb_usu: {
                            required: "   Campo obligatorio",
                            digits: "   Ingrese s&oacute;lo caracteres alfanum&eacute;ricos"
                    },
                    nick_usu: {
                            required: "   Campo obligatorio",
                            digits: "   Ingrese s&oacute;lo caracteres alfanum&eacute;ricos"
                    },
                    pass_usu1: {
                            required: "   Campo obligatorio",
                            minlength: jQuery.format("   Ingrese m&iacute;nimo 8 caracteres")
                    },
                    pass_usu2: {
                            required: "   Campo obligatorio",
                            equalTo: "   Contrase&ntilde;as no coinciden"			
                    },
                    mail_usu: {
                            required: "   Campo obligatorio",
                            email: "   Ingrese una direcci&oacute;n de correo v&aacute;lida"				
                    },
                    preg_usu: {
                            required: "   Campo obligatorio"							
                    },
                    resp_usu: {
                            required: "   Campo obligatorio"					
                    }		
            },
             submitHandler: function(form) {
                $j('#error').text('');
                $j('#error1').text('');			
                if($j('#tipo_usu').val() == -1){
                    $j('#error1').text(' Debe seleccionar un tipo de usuario.');
                }
                else{
                    nombre = $j('#nomb_usu').val();
                    email  = $j('#mail_usu').val();						
                    nick   = $j('#nick_usu').val();
                    pass1  = $j('#pass_usu1').val();
                    pass2  = $j('#pass_usu2').val();
                    pregS  = $j('#preg_usu').val();
                    respS  = $j('#resp_usu').val();	
                    tipo_usu = $j('#tipo_usu').val();

                    param = [							 
                         { name : 'nombreUsu', value : $j('#nomb_usu').val()},
                         { name : 'loginUsu', value : $j('#nick_usu').val()},
                         { name : 'passUsu', value : $j('#pass_usu1').val()},
                         { name : 'emailUsu', value : $j('#mail_usu').val()},
                         { name : 'preguntaUsu', value : $j('#preg_usu').val()},
                         { name : 'respuestaUsu', value : $j('#resp_usu').val()},
                         { name : 'tipoUsu', value : $j('#tipo_usu').val()}							 
                        ];

                    $j.ajax({						
                        type: 'POST',
                        url: '../src/facade/usuarioFacade.php?modo=1',
                        data: param,
                        async: false,
                        dataType: "text",				   
                        success: function(data){
                            if(data == 1){
                                $j('#error').text('');
                                $j('#error2').text('');
                                mensaje('#dialog-exito');
                            }
                            else if(data == -1){
                                $j('#error2').text('El usuario ya existe');
                            }						
                            else{
                                alert("USUARIO NO CREADO");
                            }
                        }
                     });                            	
                }
            }
    });
}

    </script>
<div class="art-postcontent">
    <form method="post" id="registro" name="registro" action=""><br />
        <h1><span class="titulosGrandes">Registro de Usuario</span></h1>
        <table cellspacing="5%" width="100%">
        <tbody>
            <tr>
                <td width="35%" class="cajaTexto"><span class="alertas" style="">* </span>Nombre y Apellido:</td>
                <td width="65%" class="alertas"><input maxlength="50" size="40" type="text" id="nomb_usu" name="nomb_usu" value=""></input></td>
            </tr>
            <tr>
                <td width="35%" class="cajaTexto"><span class="alertas" style="">* </span>Usuario:</td>
                <td width="65%" class="alertas"><input maxlength="50" size="40" type="text" id="nick_usu" name="nick_usu" value=""></input><span class="alertas" id="error2"></span></td>
            </tr>
            <tr>
                <td width="35%" class="cajaTexto"><span class="alertas" style="">* </span>Contraseña: </td>
                <td width="65%" class="alertas"><input maxlength="64" size="40" type="password" id="pass_usu1" name="pass_usu1" value=""></input></td>
            </tr>
            <tr>
                <td width="35%" class="cajaTexto"><span class="alertas" >* </span>Confirmar Contraseña: </td>
                <td width="65%" class="alertas"><input maxlength="64" size="40" type="password" id="pass_usu2" name="pass_usu2" value=""></input></td>
            </tr>
            <tr>
                <td width="35%" class="cajaTexto"><span class="alertas">* </span>Correo Electronico: </td>
                <td width="65%" class="alertas"><input maxlength="100" size="40" type="text" id="mail_usu" name="mail_usu" value=""></input></td>
            </tr>
            <tr>
                <td width="35%" class="cajaTexto"><span class="alertas">* </span>Pregunta Secreta: </td>
                <td width="65%" class="alertas"><input maxlength="250" size="40" type="text" id="preg_usu" name="preg_usu" value="" title="Campo obligatorio"></input></td>
            </tr>
            <tr>
                <td width="35%" class="cajaTexto"><span class="alertas">* </span>Respuesta Secreta: </td>
                <td width="65%" class="alertas"><input maxlength="250" size="40" type="text" id="resp_usu" name="resp_usu" value="" title="Campo obligatorio"></input></td>
            </tr>
            <tr>
                <td width="35%" class="cajaTexto"><span class="alertas">* </span>Tipo de Usuario: </td>
                <td width="65%" class="alertas">
                    <select class="seleccionar" name="tipo_usu" id="tipo_usu" style="width:100px;">
                        <option class="cajaTexto" value="-1">Seleccione: </option>
                        <option class="cajaTexto" value="1">Usuario </option>
                        <option class="cajaTexto" value="2">Administrador </option>
                    </select>
                    <span class="alertas" id="error1"> </span>
                </td>
            </tr>
        </tbody>
        </table>
        <br />
        <table align="center" style="margin-right: auto; margin-left: auto; ">
        <tbody>
            <tr>
                <td class="alertas" align="center" ><span >* Campos Obligatorios.</span></td>
            </tr>
            <tr>
                <td class="alertas" align="center" style="text-align: center; " ><span >* La contraseña debe estar entre 8 y 64 caracteres.</span></td>
            </tr>
            <tr>
                <td align="center" >
                    <input type="submit" onclick="validar();" value="Guardar Datos" align="middle"></input>
                    <input type="reset" value="Limpiar" name="rest"></input>
                    <input type="button" value="Atras" onclick="this.form.action = ''; this.form.submit();"></input>
                </td>
            </tr>
        </tbody>
        </table>
        <br />
    </form>
</div>
<div id="dialog-exito" style="display:none" title="Exito">
    <table align="center">
        <tr>
            <td><img src="./css/imagenes/check.png" width="40px" height="40px"/></td>
            <td class="cajaTexto">Operación Realizada con Éxito.<br> Espere que el administrador active su cuenta</td>
        </tr>
    </table>
</div> 