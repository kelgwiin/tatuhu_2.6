$("#cont").html('\
<div id="dialog1" class="dialog" title="Desastre Natural">\n\
<strong>&iquest;Cu&aacute;l es la actitud correcta ante una situaci&oacute;n de emergencia en tu escuela o comunidad?</strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong><br>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="0">Gritar</option>\n\
<option value="0">Salir corriendo</option>\n\
<option value="1">Mantener la calma y actuar con cuidado</option>\n\
</select></div>\n\
\n\
<div id="dialog2" class="dialog" title="Desastre Natural">\n\
<strong>&iquest;Qu&eacute; deber&iacute;as hacer en el caso de que mam&aacute; o pap&aacute; se queden paralizados del miedo?</strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong>\n\
<div class="error" style="display:none"></div><br>\n\
<select size="2" id= "tiposInun">\n\
<option value="1">Llamar a emergencias y pedir ayuda</option>\n\
<option value="0">Ponerme triste</option>\n\
<option value="0">Salir Corriendo</option>\n\
</select>\n\
</div>\n\
<div id="dialog3" class="dialog" title="Desastre Natural"><strong>\n\
Si est&aacute; dentro de tus posibilidades tener insumos de primeros auxilios y comida, &iquest;Qu&eacute; har&iacute;as?</strong>\n\
<br><strong>Marca las opciones correctas :</strong>\n\
<br>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="0">Ser ego&iacute;sta y esconderlos</option>\n\
<option value="0">No decirle a nadie</option>\n\
<option value="1">Compartir y ayudar a otros</option>\n\
</select></div>');

$("#demo").html('\
<div class="nodePrincipal" id ="node1" style="text-align:center">\n\
    C&oacute;mo debemos actuar ante la ocurrencia de un desastre\
</div>\
<div class="node" id ="node2" style="display:none; ">\n\
Durante la ocurrencia de una emergencia lo mejor es <strong>estar calmados</strong> para minimizar los accidentes\n\
</div>\n\
<div class="node" id ="node3" style="display:none; margin-left:300px;">\n\
Si nuestros padres no pueden ayudarnos, debemos tratar de llamar a los n&uacute;meros de emergencias y pedir ayuda.\n\
</div>\n\
<div class="node" id ="node4" style="display:none; margin-left:550px;">\n\
Lo correcto es compartir nuestros suministros con las personas que lo necesiten\n\
</div>');