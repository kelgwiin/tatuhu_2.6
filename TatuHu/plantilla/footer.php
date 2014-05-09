<script type="text/javascript" src="js/roundabout.js"></script>
<script type="text/javascript" src="js/init.js"></script>
  <footer>
    <div class="container">
    	<div class="wrapper">
        <div class="fleft"><a href="http://validator.w3.org/check?uri=http%3A%2F%2Fhpserver-elearning.facyt.uc.edu.ve%2FTatuHu%2F" target="_blank" title="Validado por el W3C-HTML5"><img src="images/HTML5_Logo_32.png" alt="W3C HTML5"></a> &copy; Copyright - Tatu H&uacute;</div>
        <div class="fright"><img src="images/UC_icon.png" alt="UC"> <a href="http://www.uc.edu.ve/" target="_blank">Universidad de Carabobo</a>&nbsp;&nbsp;&nbsp;<img style="margin-top: 5px;" src="images/FACYT_icon.png" alt="FACYT"> <a href="http://www.facyt.uc.edu.ve/" target="_blank">FACYT</a></div>
      </div>
    </div>
  </footer>
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
				<button type="submit" class="">Entrar</button>				
		      </div>  
		  </form>
		</div>
	</div>
</div>

<script type="text/javascript" src="js/forms/jquery.validate.js"></script>
	<script>
	function login(){
		var form1 = $('#form');
		var vars = form1.serialize();
			 if ($('#user').val() != "" && $('#password').val() != ""){
			$(".message").hide();
			$(".message2").html("<img src='images/login/loading16.gif'> Verificando datos, por favor espere <span class='block-arrow bottom'><span></span></span>");
			$(".message2").show();
			   $.ajax({
			   type: "POST",
			   contentType:"application/x-www-form-urlencoded", 
			   url:"loginTatuHu/login.php",
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
	</script>
