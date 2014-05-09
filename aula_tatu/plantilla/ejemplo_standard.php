<?php
require 'plantilla/plantilla.php';

p_contenido('centro','
            <hgroup class="thin">
                <a href="componentes.php?tipo=sociedad"><img src="contenido/sociedad.png" id="sociedad_img_id" style="position: absolute; left: 16.6667px; top: 139px;"></a>
                <div align="right">
                    <a href="componentes.php?tipo=lenguaje"><img src="contenido/lenguaje.png" id="lenguaje_img_id" style="position: absolute; left: 749.667px; top: 142px;"></a>
                </div>
            </hgroup>
            <div align="center">
                <img src="contenido/areas_aprendizaje.png" id="areas_img_id" style="position: absolute; left: 246px; top: 200.333px;">
            </div>
                <a href="componentes.php?tipo=matematica"><img src="contenido/matematica.png" id="matematica_img_id" style="position: absolute; left: -13.6667px; top: 491px;"></a>
            <div align="right">
                <a href="componentes.php?tipo=historia"><img src="contenido/historia.png" id="historia_img_id" style="position: absolute; left: 705.333px; top: 486px;"></a>
            </div>
');

p_con_shortcuts(true);
p_con_menu(true);

p_contenido('titulo_1','titulo_1');
p_contenido('titulo_grande_1','titulo_grande_1');
p_contenido('titulo_grande_2','titulo_grande_2');
p_contenido('titulo_pequeno','titulo_pequeno');
p_contenido('tipo_usuario','tipo_usuario');
p_contenido('msg_nombre_usuario','msg_nombre_usuario');
p_contenido('nombre_usuario','nombre_usuario');
 /*
 //<?php echo $meses[(date('m')+0)]; ?> <strong><?php echo date('d');?></strong>*/

p_shortcuts_agregar('Sociedad','sociedad');
p_shortcuts_agregar('Lenguaje','lenguaje');
p_shortcuts_agregar('Matematicas','matematicas');
p_shortcuts_agregar('Historia','historia');
p_shortcuts_agregar('Fer','historia');
p_shortcuts_agregar('Fer2','historia');

p_shortcuts_set_activo('Fer');

p_set_menu_archivo('menu_tatu.php');

p_bacceso_agregar_icono(1,'Configurar','icon-gear','about:config','5');
p_bacceso_agregar_icono(2,'Salir','<img src="../images/salir.png" width="25" style="position: relative; top: 5px;"/>','http://www..google.co.ve',5);
p_dibujar('standard2');