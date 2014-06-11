<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<head>
  <?php include_once("plantilla/scripts.php"); ?>
</head>
<body>
<?php include_once("plantilla/bienvenidaIE.php"); ?>
  <!-- header -->
  <header id="headerNormal">
    <?php include_once("plantilla/menu.php"); ?>
  </header>
<div id="main">
  <?php include_once("plantilla/contacto.php"); ?>
  <!-- #gallery -->
  <?php include_once("plantilla/gallery.php"); ?>
  <!-- /#gallery -->
  <div class="main-box">
    <div class="contenido">
      <div class="inside">
        <div class="wrapper">
	  <!-- aside -->
          <aside class="inicio">
            <h2>Instituciones Participantes</h2>
            <!-- .news -->
            <ul class="news">
            	<li>
		  <figure><a href="http://www.uc.edu.ve/" title="Logo de la Universidad de Carabobo" target="_blank"><img src="images/UC.png" class="loguito" alt="UC"></a></figure>
                <h3><a href="http://www.uc.edu.ve/" target="_blank">Universidad de Carabobo</a></h3>
                Ubicada en el Estado Carabobo, Venezuela
              </li>
              <li>
              	<figure><a href="http://www.facyt.uc.edu.ve/" title="Logo de FACYT" target="_blank"><img src="images/FACYT.png" class="loguito" alt="FACYT"></a></figure>
                <h3><a href="http://www.facyt.uc.edu.ve/" target="_blank">FACYT</a></h3>
                Facultad Experimental de Ciencias y Tecnolog&iacute;a de la Universidad de Carabobo
              </li>
			     <li>
              	<figure><a href="http://www.dta.uc.edu.ve/" title="Logo DTA" target="_blank"><img src="images/logoDTA.png" class="loguito" alt="DTA"></a></figure>
                <h3><a href="http://www.dta.uc.edu.ve/" target="_blank">DTA</a></h3>
                Direcci&oacute;n de Tecnolog&iacute;a Avanzada de la Universidad de Carabobo
              </li>
              <li>
              	<figure><a href="http://conciencia.mcti.gob.ve/" title="Logo de FONACIT" target="_blank"><img src="images/FONACIT.png" alt="FONACIT" class="loguito"></a></figure>
                <h3><a href="http://conciencia.mcti.gob.ve/" target="_blank">FONACIT</a></h3>
                 Fondo Nacional para la Ciencia y Tecnolog&iacute;a
              </li>
	    <li>
              	<figure><a href="http://www.pc-adcarabobo.gob.ve/" title="Logo de PC" target="_blank"><img src="images/PC.png" alt="PC" class="loguito"></a></figure>
                <h3><a href="http://www.pc-adcarabobo.gob.ve/" target="_blank">Protecci&oacute;n Civil Carabobo</a></h3>
                 Instituto Aut&oacute;nomo de Protecci&oacute;n Civil y Administraci&oacute;n de Desastres del Estado Carabobo
              </li>
            </ul>
            <!-- /.news -->
          </aside>
	  <section id="content">
            <article>
            	<h2>Bienvenido al <span style="font-weight: bold;">Proyecto Tatu H&uacute;</span></h2>
              <p>El proyecto <strong>"Educaci&oacute;n y concienciaci&oacute;n de la comunidad Vivienda Rural de B&aacute;rbula en la prevenci&oacute;n y manejo de riesgos ante desastres naturales, desde un entorno de aprendizaje mediado por las tecnolog&iacute;as&quot;,</strong>
              tiene como objetivo principal la creaci&oacute;n de condiciones para generar una cultura de prevenci&oacute;n, autoprotecci&oacute;n y manejo de desastres naturales, en las comunidades.</p>
              <p>Para lograr este objetivo partimos de la informaci&oacute;n suministrada por instituciones
	      como <a href="http://www.pc-adcarabobo.gob.ve/" title="Protecci&oacute;n Civil estado Carabobo" target="_blank">Protecci&oacute;n Civil del estado Carabobo</a>, <a href="http://www.udefa.edu.ve/" title="Universidad de Falc&oacute;n" target="_blank">Universidad de Falc&oacute;n</a>, <a href="http://www.funvisis.gob.ve" title="Fundaci&oacute;n Venezolana de Investigaciones Sismol&oacute;gicas" target="_blank">Fundaci&oacute;n Venezolana de Investigaciones Sismol&oacute;gicas</a>, entre otras. Asimismo nos integramos con el 
		  Sistema Educativo Bolivariano de Venezuela para crear una serie de recursos de aprendizaje mediados por la
	      <strong>tecnolog&iacute;a</strong>, para brindar a ni&ntilde;os, familias, maestros y comunidad en general; acceso a informaci&oacute;n interactiva en materia de <a href="riesgosNaturales.php">Gesti&oacute;n de Riesgos</a>.</p>
            </article> 

            <!-- Video Promocional -->
            <h2><span style="font-weight: bold;">Video promocional</span></h2>
              <object type="application/x-shockwave-flash" data="http://player.longtailvideo.com/player.swf" width="550" height="350">
                <param name="movie" value="http://player.longtailvideo.com/player.swf" />
                <param name="allowFullScreen" value="true" />
                <param name="wmode" value="transparent" />
                <param name="flashVars" value="autostart=true&amp;controlbar=over&amp;file=http%3A%2F%2F190.170.86.92%2Ftatuhu_2.6%2FTatuHu%2Fvideos%2Fpromocional.flv">
                <span title="No video playback capabilities, please download the video below"></span>
              </object>

          </section>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- footer -->
  <?php include_once("plantilla/footer.php"); ?>
</body>
</html>
