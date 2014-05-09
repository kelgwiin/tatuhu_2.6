<?php
require 'plantilla/plantilla.php';

p_login_set_titulo('TATU HÚ');
p_login_set_msg_titulo('Importante');
p_login_set_msg_contenido('Coloca El usuario y contraseña que se le fue asignado para realizar las actividades, en caso de no contar con el acceso deseado comunicate con tu maestro o con el Administrador de Sistema <br> <div align="center"><b>¡Exitos!</div>');
p_login_set_msg_img('images/nina_peq.png');
p_dibujar('login');