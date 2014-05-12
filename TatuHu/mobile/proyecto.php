<!DOCTYPE html>
<html>
<head>
		<?php include_once ("plantilla/header.php"); ?>
</head>
<body>
    <div data-role="page" id="page2">
		<?php include_once ("plantilla/banner2.php"); ?>
        <div data-role="content">
		    <h3>Proyecto Tatu H&uacute;</h3>
			<div data-role="collapsible-set" class="principal">
                <div data-role="collapsible" data-collapsed="true">
                        <h3>
                            &iquest;Qu&eacute; es Tatu H&uacute;?
                        </h3>
                       <div style="text-align: center;"><img src="images/cachicamo.png" alt="Tatu Hu"></div> El nombre <strong>Tatu H&uacute;</strong> proviene del idioma Guaran&iacute;, que traducido al espa&ntilde;ol es armadillo negro. Los armadillos se
						caracterizan por tener una coraza o armadura que le permite <strong>protegerse de los peligros</strong>. Por esta raz&oacute;n, la imagen o identidad de nuestro proyecto 
						es el armadillo Tatu H&uacute;, para reflejar que una cultura preventiva permite protegernos de los riesgos.<br><br>
                </div>
                 <div data-role="collapsible" data-collapsed="true">
                    <h3>&iquest;Qu&eacute; nos motiva?</h3>
					   <div style="text-align: center;"><img src="images/motivacion.png" alt="Tatu Hu" style="float:left; padding-right:10px;"></div> 
					   En general, las comunidades en el Estado Carabobo son vulnerables ante desastres naturales, por lo que es de vital importancia 
					   fomentar una <strong>cultura preventiva</strong>. 
						La <strong>formaci&oacute;n mediada por la tecnolog&iacute;a</strong> podr&aacute; contribuir a alcanzar esta meta.
                </div>		
			    <div data-role="collapsible" data-collapsed="true">
                    <h3>Nuestro principal objetivo</h3>
					<div style="text-align: center;"><img src="images/objetivo.png" alt="Tatu Hu" style="float:left; padding-right:10px;"></div>
					Formar, capacitar y fomentar la conciencia de las comunidades, en materia de gesti&oacute;n de riesgos ante desastres 
					naturales, a partir de planes y programas de formaci&oacute;n mediados por las Tecnolog&iacute;as de Informaci&oacute;n y 
					Comunicaci&oacute;n.
                 </div>
				<div data-role="collapsible" data-collapsed="true">
                    <h3>Beneficiados</h3>
					<div style="text-align: center;"><img src="images/beneficiados.png" alt="Tatu Hu" style="float:left; padding-right:10px;"></div>
						 El Proyecto Tatu H&uacute; est&aacute; dirigido a la comunidad <a href="#viviendaRural" data-rel="popup" data-transition="pop">Vivienda Rural de B&aacute;rbula del Estado Carabobo</a>, sin embargo otras comunidades a nivel nacional pueden tambi&eacute;n beneficiarse.<br>
                 </div>
           </div>
		   
		   <div data-role="popup" id="viviendaRural" data-overlay-theme="a" data-theme="a" data-corners="false" data-tolerance="15,15">
				<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
				<iframe src="viviendaRural.html" width="480" height="320" seamless></iframe>
	 
			</div>
		   
        </div>
		<?php include_once ("plantilla/footer.php"); ?>
    </div>
</body>
</html>