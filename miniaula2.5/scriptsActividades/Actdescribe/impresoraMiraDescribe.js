	function imprimirMiraDescribe(){
		$(".error").hide();
	var correct = true;
	for (var i =1; i<=4; i++){
			if($("#"+i).val() == "")
				correct = false;
		}
	if(correct){
			var content = "<br><br><div style='text-align:center; font-weight:bold;'>Mira y Describe</div>";
			var i =0;
			$("#miraydescribe li").each(function(){
					content += "<div style='clear:both;'><div style='width:150px; height: 150px; float:left;'><img src='" + 
								$(this).find("img").attr("src") + "' style='width:auto; height:100px;'></div><div>"+ $(this).find("textarea").val() + "</div></div>";
			})
			//alert(content)
			var ventimp = window.open(' ', 'popimpr'); 
			ventimp.document.write( "<br><br>"+content);
			ventimp.document.close(); 
			ventimp.print( ); 
			ventimp.close(); 
		}
		else{
				$(".error").show();
			}
	}