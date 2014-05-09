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
           <aside>
            <h2 style="font-weight: bold">Conceptos Claves</h2>
            <!-- .news -->
            <ul class="news">
	                  	<li>
		  <figure><img src="images/riesgo.png" alt="Riesgo"></figure>
                <h3>Riesgo</h3>
                Es la probabilidad de que una amenaza se convierta en un desastre.
              </li>
	      <li>
		  <figure><img src="images/amenaza.png" alt="Amenaza"></figure>
                <h3>Amenaza</h3>
                Una amenaza es un fen&oacute;meno o proceso natural o causado por el ser humano, que puede poner en peligro a un grupo de personas, sus cosas y su ambiente, cuando no son precavidos.
              </li>
              <li>
              	<figure><img src="images/vulnerabilidad.png" alt="Vulnerabilidad"></figure>
                <h3>Vulnerabilidad</h3>
                Es la incapacidad de resistencia cuando se presenta un fen&oacute;meno amenazante, o la incapacidad para reponerse despu&eacute;s de que ha ocurrido un desastre.
              </li>
              <li>
              	<figure><img src="images/desastre.png" alt="Desastre"></figure>
                <h3>Desastre</h3>
               Se llama desastre a la situaci&oacute;n que deriva en
				p&eacute;rdidas humanas, materiales o ambientales,
					que no pueden ser afrontadas utilizando
				exclusivamente los recursos de la comunidad
				o de la sociedad afectada, y que por lo tanto
				requieren asistencia o apoyo externos.
              </li>
            </ul>
            <!-- /.news -->
          </aside>
	  <section id="content">
            <article>
            	<h2><span>Riesgos Naturales</span></h2>
              <p>No podemos evitar que ocurran los fen&oacute;menos naturales pero podemos hacerlos menos da&ntilde;inos si entendemos mejor por qu&eacute; suceden y qu&eacute; podemos hacer para prevenirlos o mitigarlos.
				Tomando en cuenta que la gente es, en parte, responsable por la ocurrencia de los desastres, <strong>tenemos que cambiar lo que estamos haciendo mal para poder evitar o disminuir el impacto de los fen&oacute;menos
                naturales</strong>.<br>
				Cada comunidad debe aprender a conocer las caracter&iacute;sticas de su entorno, el ambiente
				natural y el modificado por el ser humano. Solo as&iacute; podr&aacute; manejar las amenazas que la rodean y reducir
					su vulnerabilidad ante estas amenazas.</p>
             
            <h2><span>Gesti&oacute;n de Riesgos</span></h2>
			<p>La gesti&oacute;n de riesgos es un proceso social sistem&aacute;tico y permanente de an&aacute;lisis, toma de decisiones y aplicaci&oacute;n de pol&iacute;ticas y medidas administrativas, 
			econ&oacute;micas, sociales y ambientales. Asimismo, trabaja a partir de
				conocimientos organizacionales y operacionales destinados a implementar pol&iacute;ticas, estrategias, 
				programas y proyectos. <br> 
				Uno de los objetivos principales consiste en fortalecer las capacidades preventivas a fin de reducir los riesgos existentes y 
				prever la generaci&oacute;n de riesgos futuros ante el posible impacto de fen&oacute;menos 
				potencialmente destructivos, de origen <a href="#" id="natural">natural</a> o <a href="#" id="antropico">antr&oacute;pico</a>.</p>
			</article> 
          </section>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="concepto1" title="Riesgo de origen Natural">
Los riesgos naturales se pueden definir como la posibilidad de que un territorio y la sociedad que lo habita, puedan verse afectados por un <strong>fen&oacute;meno natural</strong>
de rango extraordinario que suponga un peligro causante de da&ntilde;os, enfermedades, p&eacute;rdidas econ&oacute;micas o da&ntilde;os ambientales.
</div>
<div class="concepto2" title="Riesgo de origen Antr&oacute;pico">
Los riesgos antr&oacute;picos se refieren a los fen&oacute;menos que tienen su origen en <strong>acciones humanas</strong>, es decir, son causados por el hombre.
Estos riesgos tienen un impacto menor que los naturales, pero pueden perdurar muchos a&ntilde;os y constituir una amenaza para la salud humana y para los 
ecosistemas por la presencia de sustancias t&oacute;xicas, sustancias inflamables o explosivas y sustancias cancer&iacute;genas.
</div>
  <!-- footer -->
  <?php include_once("plantilla/footer.php"); ?>
  
<script>
  $( ".concepto1, .concepto2" ).dialog({
   width:600,
   heigth:500,			
   modal: true,
   resizable:false,
   autoOpen: false,
});

$("#natural").click(function(event){
 event.preventDefault();
  $(".concepto1").dialog("open");
});

$("#antropico").click(function(event){
   event.preventDefault();
  $(".concepto2").dialog("open");
});

</script>
</body>
</html>
