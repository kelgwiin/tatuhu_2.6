			tinyMCE.init({
				mode : "textareas",
				language : "es",
				theme : "advanced",
				skin : "o2k7",
				theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "bullist,numlist,forecolor",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "center",
				theme_advanced_statusbar_location : false,
				theme_advanced_resizing : false
			});

		function imprimir(title) {
		$(".error").hide();
			if($("#tituloCuento").val() != undefined && $("#tituloCuento").val() != "" && tinyMCE.get("elm1").getContent() != ""){
				var contenido = tinyMCE.get("elm1").getContent();
				var ventimp = window.open(' ', 'popimpr'); 
				var add="";
				ventimp.document.write( "<br><br><div style='text-align:center; color:#06313e; font-size:20px;'>"+ document.getElementById(title).value +"</div></div><br><div style='float:left; width:450px;'>" + contenido + "</div>" +add);
				ventimp.document.close(); 
				ventimp.print( ); 
				ventimp.close(); 
				
			}
			else{
				$(".error").show();
			}
		} 
		