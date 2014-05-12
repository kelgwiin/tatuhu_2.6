<!DOCTYPE html>
<html lang="es">
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
  <div style="height:450px; padding:200px;">
	<h2>Recuperaci&oacute;n de <span>Contrase&ntilde;a</span></h2>
		<span style="margin-left:25px;"><strong>Introduzca la direcci&oacute;n que us&oacute; para el registro en el sistema Tatu H&uacute;:</strong></span><br><br>
		<div class="message2"></div>
		<div id="formrecuperar" style="margin: 0 auto; width:650px; text-align:center;">
		<form id="recuperarpass" >
			<span style="padding-top:5px;">Direcci&oacute;n de correo electr&oacute;nico:</span>
			 <input id="cemail" type="email" name="email" required/>
			<br><br>
			<button type="button" value="Aceptar" style="width:100px; height:30px;">Aceptar</button>
		</form>
		</div>
  </div>
  <div class="main-box">
    <div class="contenido">
      <div class="inside">
        <div class="wrapper">
			
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- footer -->
  <?php include_once("plantilla/footer.php"); ?>
    	<script>
	function recuperarContrasenia(){
		var form1 = $('#formrecuperar');
		var vars = form1.serialize();
	 }
	 $(document).ready(function(){
	 jQuery("form#formrecuperar").validate({
		invalidHandler: function(e, validator) {
		        var errors = validator.numberOfInvalids();
			if (errors) {
				var message = 'Introduce tu usuario y contrase&ntilde;a para acceder al sistema<span class="block-arrow bottom"><span></span></span>';
				$(".message").html(message);
				$(".espacio").hide();
				$(".message").show();
				$("ul.inputs").css("margin-top","0px");
				if (/^\s+$/.test($("#user").val()) || $("#user").val().length == 0) {
				  $("li.usuario").css("border","2px solid red");
				}
				else{
				  $("li.usuario").css("border","none");
				}
				if (/^\s+$/.test($("#password").val()) || $("#password").val().length == 0) {
				  $("li.contra").css("border","2px solid red");
				}
				else{
				  $("li.contra").css("border","none");
				}
			} else {
				$(".message").hide(); 
				$(".espacio").show();
			}
		},
		submitHandler: function(){
			login();
		}
		});
	 })

	</script>

</body>
</html>
