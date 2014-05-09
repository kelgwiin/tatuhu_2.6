$("#cont").html('\
<div id="dialog1" class="dialog" title="Desastre Natural">\n\
<strong>Es la alta probabilidad de que un fen&oacute;meno natural se produzca ocasionando da&ntilde;os materiales y humanos </strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong><br>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="0">Emergencia</option>\n\
<option value="1">Amenaza</option>\n\
<option value="0">Terremoto</option>\n\
</select></div>\n\
\n\
<div id="dialog2" class="dialog" title="Desastre Natural">\n\
<strong>Est&aacute; relacionado directamente con el grado de exposici&oacute;n de las personas o sus recursos frente a las amenazas</strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong>\n\
<div class="error" style="display:none"></div><br>\n\
<select size="2" id= "tiposInun">\n\
<option value="1">Vulnerabilidad</option>\n\
<option value="0">Lluvias</option>\n\
<option value="0">Desastre natural</option>\n\
</select>\n\
</div>\n\
<div id="dialog3" class="dialog" title="Desastre Natural"><strong>\n\
&iquest;C&oacute;mo se llama lo que la brigada escolar hace en la escuela y comunidad para saber qu&eacute; hacer ante emergencias?</strong>\n\
<br><strong>Marca las opciones correctas :</strong>\n\
<br>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="0">Fiestas</option>\n\
<option value="0">Reuni&oacute;n</option>\n\
<option value="1">Mapa de riesgos y plan de evacuaci&oacute;n</option>\n\
</select></div>');

$("#demo").html('\
<div class="nodePrincipal" id ="node1" style="text-align:center">\n\
    La <strong>gesti&oacute;n de riesgos</strong> nos permite prevenir desastres y practicar el cuidado del ambiente.\
</div>\
<div class="node" id ="node3" style="display:none; ">\n\
<strong>Vulnerabilidad </strong>es la incapacidad de resistencia de las personas y comunidades cuando se presenta un fen&oacute;meno amenazante, o la incapacidad para reponerse despu&eacute;s de que ha ocurrido un desastre.\n\
</div>\n\
<div class="node" id ="node2" style="display:none; margin-left:300px;">\n\
Las <strong>amenazas</strong> son fen&oacute;menos o procesos naturales o causado por el ser humano que puede poner en peligro a un grupo de personas, sus cosas y su ambiente, cuando no son precavidos.\n\
</div>\n\
<div class="node" id ="node4" style="display:none; margin-left:550px;">\n\
El <strong>mapa de riesgos</strong> es un dibujo o maqueta que indica los elementos importantes de la comunidad y muestra zonas o elementos potencialmente peligrosos. Adem&aacute;s, el mapa indica en que medida podr&iacute;a verse afectados los elementos expuestos a estas amenazas.\n\
</div>');

$("body").append('  ')