<?php
error_reporting(~E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Aula Virtual Tatu H&uacute;</title
	<meta name="description" content="Aula virtual tatu hu">
	<meta name="author" content="Proyecto PEI - 2012000190">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/css/reset_59edcbff.css">
	<link rel="stylesheet" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/css/style_59edcbff.css">
	<link rel="stylesheet" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/css/colors_59edcbff.css">
	<link rel="stylesheet" media="only all and (min-width: 768px)" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/css/768_59edcbff.css">
	<link rel="shortcut icon" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/favicons/favicon.png">
	<link rel="shortcut icon" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/favicons/favicon.ico">

	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/favicons/apple-touch-icon-retina.png">

	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/favicons/apple-touch-icon-ipad.png">

	<link rel="apple-touch-icon-precomposed" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/favicons/apple-touch-icon.png">


	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="stylesheet" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/css/login.css">
	<link rel="apple-touch-startup-image" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
	<link rel="apple-touch-startup-image" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
	<link rel="apple-touch-startup-image" href="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

	<!-- Microsoft clear type rendering -->
	<meta http-equiv="cleartype" content="on">

	<!-- IE9 Pinned Sites: http://msdn.microsoft.com/en-us/library/gg131029.aspx -->
	<meta name="application-name" content="Developr Admin Skin">
	<meta name="msapplication-tooltip" content="Cross-platform admin template.">
	<meta name="msapplication-starturl" content="http://www.display-inline.fr/demo/developr">
	<!-- These custom tasks are examples, you need to edit them to show actual pages -->
	<meta name="msapplication-task" content="name=Agenda;action-uri=http://www.display-inline.fr/demo/developr/agenda.html;icon-uri=http://www.display-inline.fr/demo/developr/img/favicons/favicon.ico">
	<meta name="msapplication-task" content="name=My profile;action-uri=http://www.display-inline.fr/demo/developr/profile.html;icon-uri=http://www.display-inline.fr/demo/developr/img/favicons/favicon.ico">
	<meta charset="UTF-8">
	<script src="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/js/libs/modernizr.custom.js"></script>
</head>
<body>
    <div id="headerNormal">
	<h1><a href="../"><img alt="Logo" src="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/img/logo-encabezado.png"></a></h1>
	<h1 class="thin"><b>Aula Virtual Tatu H&uacute;</b></h1>
    </div>
    <div id="gallery"></div>
    

<div id="loginCuadro" title="Login">
  <div style="text-align: center;">Escribe tu nombre de usuario y tu contrase&ntilde;a para acceder al <strong>Aula Tatu H&uacute;</strong></div>
  	<br>
	<div id="redireccion"></div>
	<div id="container">
		<div id="containerForm">
		 <p class="message icon-speech red-gradient small-margin-bottom"></p>
		 <p class="message2 blue-gradient icon-speech small-margin-bottom" style="display: none;"></p>
		  <form id="form" title="Acceso a Sistema">
		      <ul class="campos">
			    <li class="usuario">
				<input type="text" name="login" id="user" value="" class="required" placeholder="Usuario" autocomplete="off"></li>
			    <li class="contra">
				<input type="password" name="pass" id="password" value="" class="required" placeholder="Contrase&ntilde;a" autocomplete="off"></li>
		      </ul>
			  <br>
		          <div class="boton" style="position:relative;">
				<button type="submit">Entrar</button>				
		          </div>  
		  </form>
		</div>
	</div>
</div>
		
	</div>

	<!-- Scripts -->
	<script src="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/js/libs/jquery-1.8.3.min.js"></script>
	<script src="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/js/jquery.validate.min.js"></script>
	<script src="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/js/developr.tooltip.js"></script>
	<script src="<?php if (isset($rel_path)) echo @$rel_path.'/'; ?>plantilla/js/developr.notify.js"></script>
	<script>
	    function login(){
		var form1 = $('#form');
		var vars = form1.serialize();
			 if ($('#user').val() != "" && $('#password').val() != ""){
			    $(".message").hide();
			   $(".message2").html("<img src='plantilla/img/standard/loaders/loading16.gif'> Verificando datos, por favor espere");
			   $(".message2").show();
			   $.ajax({
			   type: "POST",
			   contentType:"application/x-www-form-urlencoded", 
			   url:"login.php",
			   data:vars,
			   success:function(msg){
				 if (msg.indexOf("<script language='javascript'>") == -1){
					msg = msg + '<span class="block-arrow bottom"><span></span></span>';
					$(".message").html(msg); 
					$(".espacio").hide();
					$(".message2").hide();
					$(".message").show();
				 }
				 else{
					$("#redireccion").html(msg);
				 }
			   }})
			  }
	 }
	  var v = jQuery("#form").validate({
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
		
		notify('Proyecto Tatu H&uacute;','Conoce el proyecto Tatu H&uacute; accediendo a su sitio web: <a href="../">Tatu H&uacute;</a>', {
			autoClose: false,
			delay: 1000,
			icon: 'plantilla/img/Cachicamo1.png',
			closeButton: false,
			vPos: 'bottom'
		});   
	</script>
    </body>
</html>