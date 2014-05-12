<!DOCTYPE html>
<html lang="es">
<head>
  <?php include_once("plantilla/scripts.php"); ?>

  <style>
    aside.inicio{
		float: right;
		margin-left: 0;
		margin-right: 52px;

	}
  </style>
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
           <aside class="proyecto">
            <h2>&iquest;<span>Qu&eacute; es Tatu H&uacute;</span>?</h2>
            <div class="img-box">
             El nombre <strong>Tatu H&uacute;</strong> proviene del idioma Guaran&iacute;, que traducido al espa&ntilde;ol es armadillo negro. Los armadillos se
	      caracterizan por tener una coraza o armadura que le permite <strong>protegerse de los peligros</strong>. Por esta raz&oacute;n, la imagen o identidad de nuestro proyecto 
		  es el armadillo Tatu H&uacute;, para reflejar que una cultura preventiva permite protegernos de los riesgos.<br><br>
		  <div style="text-align: center;"><img src="images/cachicamo.png" alt="Tatu Hu"></div>
            </div>
          </aside>
          <!-- content -->
          <section id="content">
            <article>
            	<h2>Conoce el <span>Proyecto Tatu H&uacute;</span></h2>
              <!-- .team-list -->
              <ul class="team-list">
              	<li>
                  <div class="icon" id="objetivo"><img src="images/motivacion.png" alt="Motivaci&oacute;n" style="padding:25px;"></div>
                  <h3><a href="#">&iquest;Qu&eacute; nos motiva?</a></h3>
                  En general, las comunidades en el Estado Carabobo son vulnerables ante desastres naturales, por lo que es de vital importancia fomentar una <strong>cultura preventiva</strong>. 
		        La <strong>formaci&oacute;n mediada por la tecnolog&iacute;a</strong> podr&aacute; contribuir a alcanzar esta meta.
                </li>
                <li>
                 <div class="icon" id="objetivo"><img src="images/objetivo.png" alt="Motivaci&oacute;n" style="padding:25px;"></div>
                  <h3><a href="#">Nuestro principal objetivo</a></h3>
                  Formar, capacitar y fomentar la conciencia de las comunidades, en materia de gesti&oacute;n de riesgos ante desastres naturales, a partir de planes y programas de formaci&oacute;n mediados por las Tecnolog&iacute;as de Informaci&oacute;n y Comunicaci&oacute;n.
                </li>
                <li>
                  <div class="icon" id="objetivo"><img src="images/beneficiados.png" alt="Motivaci&oacute;n" style="padding:25px; padding-bottom:170px;"></div>
                  <h3><a href="#">Beneficiados</a></h3>
                  El Proyecto Tatu H&uacute; est&aacute; dirigido a la comunidad <a id="viviendaRural" href="#">Vivienda Rural de B&aacute;rbula del Estado Carabobo</a>, sin embargo otras comunidades a nivel nacional pueden tambi&eacute;n beneficiarse.<br>
		   En las secciones <a href="utilidadesTatuHu.php">Utilidades</a> y <a href="descargasTatuHu.php">Descargas</a> encontrar&aacute;s recursos acerca de la <a href="riesgosNaturales.php">Gesti&oacute;n de Riesgos</a> 
		   que puedes compartir con tus amigos y familiares, para que fomentemos
		   la cultura de la prevenci&oacute;n. 
                </li>
		        <!--        <li>
                  <figure><img src="images/img1.jpg" alt=""></figure>
                  <h3><a href="#">Desarrollos</a></h3>
                   Las primeras fases del proyecto estuvieron centradas en la investigaci&oacute;n  
                </li>-->
              </ul>
              <!-- /.team-list -->
            </article> 
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="vivienda" title="Vivienda Rural de B&aacute;rbula"><div style="text-align:center;"><iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.ve/maps/ms?msa=0&amp;msid=203471250135694188150.0004dafb537bd4ad11afc&amp;hl=es&amp;ie=UTF8&amp;t=m&amp;ll=10.287854,-68.017817&amp;spn=0,0&amp;output=embed"></iframe><br /><small>Ver <a href="https://maps.google.co.ve/maps/ms?msa=0&amp;msid=203471250135694188150.0004dafb537bd4ad11afc&amp;hl=es&amp;ie=UTF8&amp;t=m&amp;ll=10.287854,-68.017817&amp;spn=0,0&amp;source=embed" style="color:#0000FF;text-align:left" target="_blank">Escuela Nacional Bárbula</a> en un mapa más grande</small></div></div>
<script>
  $( ".vivienda" ).dialog({
   width:600,
   heigth:500,			
   modal: true,
   resizable:false,
   autoOpen: false
});

$("#viviendaRural").click(function(event){
 event.preventDefault();
  $(".vivienda").dialog("open");
});
</script>
  <!-- footer -->
  <?php include_once("plantilla/footer.php"); ?>
</body>
</html>
