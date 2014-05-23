$("#cont").html('<div id="dialog1" class="dialog" title="Tipos de Inundaciones">\n\
<strong>&iquest;Cu&aacute;les son los tipos de inundaciones?</strong><br>\n\
<strong>Haz clic sobre una opci&oacute;n:</strong>\n\
<div class="error" style="display:none"></div>\n\
<select size="2" id= "tiposInun">\n\
<option value="0">Inundaciones grandes e Inundaciones peque&ntilde;as</option>\n\
<option value="1">Inundaciones s&uacute;bitas o repentinas e Inundaciones lentas o progresivas</option>\n\
</select></div>\n\
\n\
<div id="dialog2" class="dialog 3" title="Consecuencias de las Inundaciones">\n\
<strong>&iquest;Cu&aacute;les son las consecuencias de las inundaciones?</strong><br>\n\
<strong>Marca las opciones correctas :</strong>\n\
<br><div class="error" style="display:none"></div>\n\
<input type="checkbox" name="P2[]" value="1"> P&eacute;rdidas humanas y de recursos naturales.<br>\n\
<input type="checkbox" name="P2[]" value="0"> Crecen las plantas.<br>\n\
<input type="checkbox" name="P2[]" value="1">\n\
 Da&ntilde;os en las casas, edificios, calles, etc.<br>\n\
<input type="checkbox" name="P2[]" value="0"> Aparecen nuevas carreteras.<br>\n\
<input type="checkbox" name="P2[]" value="0"> Aparecen nuevas casas.<br>\n\
<input type="checkbox" name="P2[]" value="1"> Enfermedades.<br>Pista: Son tres (3) respuestas correctas</div>\n\
<div id="dialog3" class="dialog" title="Causas de las Inundaciones"><strong>\n\
&iquest;Cu&aacute;les son las causas de las inundaciones?</strong>\n\
<br><strong>Marca las opciones correctas:</strong>\n\
<br>\n\
<div class="error" style="display:none"></div>\n\
<input type="checkbox" name="P2[]" value="1"> Rotura de las presas de agua.<br>\n\
<input type="checkbox" name="P2[]" value="1"> Lluvias fuertes, maremotos, tsunamis<br>\n\
<input type="checkbox" name="P2[]" value="0"> Comer mucho.<br>\n\
<input type="checkbox" name="P2[]" value="1"> Asfaltar nuevas carreteras, lo que produce que no se absorba el agua de la lluvia.<br>\n\
<input type="checkbox" name="P2[]" value="0"> Las nubes.<br><input type="checkbox" name="P2[]" value="0"> La gripe.<br>Pista: Son tres (3) respuestas correctas\n\
</div>');

$("#demo").html('\
<div class="nodePrincipal" id ="node1">\n\
    <span class="node_name">Inundaci&oacute;n</span><br>Las inundaciones son causadas por roturas de las presas de agua, lluvias fuertes y por el asfalto de las calles que impide que el suelo absorba el agua \n\
<br />\n\
</div>\n\
<div class="node" id ="node2" style="display:none;">\n\
Las inundaciones pueden ser <strong>s&uacute;bitas o repentinas</strong> y <strong>lentas</strong><strong> o progresivas</strong>\n\
</div>\n\
<div class="node" id ="node3" style="display:none; margin-left:550px;">Las inundaciones producen p&eacute;rdidas humanas y de recursos naturales, da&ntilde;os en los edificios y enfermedades \n\
</div>\n\
<div class="node" id ="node4" style="display:none; margin-left:300px;">\n\
Las inundaciones son  causadas por roturas de las presas de agua, lluvias fuertes, y \n\
por el asfalto de las calles que impide que el suelo absorba el agua\n\
</div>');

$("body").append('  ')