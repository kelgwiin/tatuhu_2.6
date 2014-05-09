$("#cont").html('\
<div id="dialog1" class="dialog" title="Desastre Natural">\n\
<strong>&iquest;Qu&eacute; tipo de desastre natural involucra eventos hidrol&oacute;gicos?  </strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong><br>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="0">Terremotos</option>\n\
<option value="0">Erupcion Volc&aacute;nica</option>\n\
<option value="1">Inundaci&oacute;n</option>\n\
</select></div>\n\
\n\
<div id="dialog2" class="dialog" title="Desastre Natural">\n\
<strong>&iquest;Cu&aacute;l es el desastre natural que involucra que se despida del suelo un fuerte olor a azufre, gases t&oacute;xicos y lava ardiente? </strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong>\n\
<div class="error" style="display:none"></div><br>\n\
<select size="2" id= "tiposInun">\n\
<option value="1">Erupciones volc&aacute;nicas</option>\n\
<option value="0">Lluvias</option>\n\
<option value="0">Inundaci&oacute;n</option>\n\
</select>\n\
</div>\n\
<div id="dialog3" class="dialog" title="Desastre Natural"><strong>\n\
&iquest;C&oacute;mo se llama el evento natural en donde se presentan fuertes vientos con lluvia en ocasiones provocando inundaciones?</strong>\n\
<br><strong>Marca las opciones correctas:</strong>\n\
<br>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="1">Tornados</option>\n\
<option value="0">Terremotos</option>\n\
<option value="0">Huracanes</option>\n\
</select></div>');

$("#demo").html('\
<div class="nodePrincipal" id ="node1" style="text-align:center">\n\
    Los <strong>desatres naturales</strong> se refieren a las p&eacute;rdidas materiales y \n\
    vidas humanas, ocasionadas por eventos o fen&oacute;menos naturales como los terremotos, \n\
    inundaciones, Tsunamis, deslizamientos de tierra, deforestaci&oacute;n, contaminaci&oacute;n ambiental \n\
    y otros\
</div>\
<div class="node" id ="node2" style="display:none; ">\n\
<strong>Las inundaciones </strong>son la presencia de grandes cantidades de agua provocadas por fuertes lluvias y que el suelo no puede absorber\n\
</div>\n\
<div class="node" id ="node3" style="display:none; margin-left:550px;">\n\
Una <strong>erupci&oacute;n volc&aacute;nica </strong> es una emisi&oacute;n violenta en la superficie terrestre de materias procedentes del interior del volc&aacute;n\n\
</div>\n\
<div class="node" id ="node4" style="display:none; margin-left:300px;">\n\
Un <strong>tornado</strong> es una masa de aire con alta velocidad angular\n\
</div>');