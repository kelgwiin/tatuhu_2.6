<div data-theme="a" data-role="footer" id="footer">
	<div>
		<a href="http://www.uc.edu.ve/" alt="UC" title="Logo de la Universidad de Carabobo" target="_blank"><img src="images/UC.png"></a>
		<a  href="http://www.dta.uc.edu.ve/" alt="DTA" title="Logo de la DTA" target="_blank"><img src="images/logoDTA.png"></a> 
		<a  href="http://www.facyt.uc.edu.ve/" alt="FACYT" title="Logo de FACYT" target="_blank"><img src="images/FACYT.png"></a> 
		<a href="http://conciencia.mcti.gob.ve/" alt="FONACIT" title="Logo de FONACIT" target="_blank"><img src="images/FONACIT.png"></a>
		<a  href="http://www.pc-adcarabobo.gob.ve/" alt="PC" title="Logo de PC" target="_blank"><img src="images/PC.png"></a>
	</div>
</div>
<script type="text/javascript" src="../js/forms/jquery.validate.js"></script>
<script>
function login(){
		var form1 = $('#myform');
		var vars = form1.serialize();
		if ($('#user').val() != "" && $('#pass').val() != ""){
			$(".error").hide();
			$("#message").html("<img src='../images/login/loading16.gif'> Verificando, por favor espere...");
			   $.ajax({
			   type: "POST",
			   contentType:"application/x-www-form-urlencoded", 
			   url:"../loginTatuHu/login.php",
			   data:vars,
			   success:function(msg){
				 if (msg.indexOf("<script language='javascript'>") == -1){
					$("#message").html(msg); 
				 }
				 else{
					$("#redireccion").html(msg);
				 }
			   }})
			  }
	 }
$(document).on('pageinit', function(){
    $('#myform').validate({ // initialize the plugin
        rules: {
            login: {
                required: true
            },
            pass: {
                required: true
            }
        },
		invalidHandler: function(e, validator) {
		   var errors = validator.numberOfInvalids();
			if (errors) {
				$("#message").html("");
				if (/^\s+$/.test($("#user").val()) || $("#user").val().length == 0) {
				  $(".error.user").show();
				}
				else{
				  $(".error.user").hide();
				}
				if (/^\s+$/.test($("#pass").val()) || $("#pass").val().length == 0) {
				  $(".error.pass").show();
				}
				else{
				  $("li.pass").hide();
				}
			} else {
				$(".message").hide(); 
			}
		},
        submitHandler: function (form) { // for demo
            login();
            return false; // for demo
        }
    });

});
</script>