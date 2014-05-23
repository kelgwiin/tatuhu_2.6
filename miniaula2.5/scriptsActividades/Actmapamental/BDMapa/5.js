$("#cont").html('\
<div id="dialog1" class="dialog" title="Desastre Natural">\n\
<strong>&iquest;Qui&eacute;nes podr&iacute;an ayudarnos en caso de una inundaci&oacute;n en mi comunidad o escuela?</strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong><br>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="1">Los bomberos y Protecci&oacute;n Civil</option>\n\
<option value="0">Los vendedores</option>\n\
<option value="0">Un actor</option>\n\
</select></div>\n\
\n\
<div id="dialog2" class="dialog" title="Desastre Natural">\n\
<strong>&iquest;C&oacute;mo se llama el grupo de personas entrenadas para ayudar a la comunidad en caso de emergencia?</strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong>\n\
<div class="error" style="display:none"></div><br>\n\
<select size="2" id= "tiposInun">\n\
<option value="0">Chaleco salvavidas</option>\n\
<option value="0">Inundaci&oacute;n</option>\n\
<option value="1">Brigada</option>\n\
</select>\n\
</div>\n\
<div id="dialog3" class="dialog" title="Desastre Natural"><strong>\n\
<strong>&iquest;C&oacute;mo se denomina al profesional de la salud ayuda a las personas lesionadas?</strong>\n\
<br><strong>Marca las opciones correctas :</strong>\n\
<br>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="0">Actores</option>\n\
<option value="0">Docente</option>\n\
<option value="1">M&eacute;dicos</option>\n\
</select></div>');

$("#demo").html('\
<div class="nodePrincipal" id ="node1" style="text-align:center">\n\
    &iquest;Qui&eacute;nes pueden ayudarnos en caso de una emergencia?\
</div>\
<div class="node" id ="node2" style="display:none; ">\n\
Los <strong>Bomberos</strong> y <strong>Protecci&oacute;n Civil</strong>\n\
</div>\n\
<div class="node" id ="node3" style="display:none; margin-left:300px;">\n\
Las <strong>Brigadas</strong> de nuestra comunidad.\n\
</div>\n\
<div class="node" id ="node4" style="display:none; margin-left:550px;">\n\
Los <strong>M&eacute;dicos y enfermeros</strong>\n\
</div>');