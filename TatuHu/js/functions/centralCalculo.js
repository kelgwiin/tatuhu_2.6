$(document).ready(function() {
$('#calculoV').stepy({
 backLabel:      'Atras',
 block:          true,
 errorImage:     true,
 nextLabel:      'Siguiente',
 titleClick:     true,
 validate:       true
});

$("#calculoV").validate({
  messages: {
   A1: "Campo obligatorio",
   A2: "Campo obligatorio",
   A3: "Campo obligatorio",
   A4: "Campo obligatorio",
   A5: "Campo obligatorio",
   A6: "Campo obligatorio",
   B1: "Campo obligatorio",
   B2: "Campo obligatorio",
   B3: "Campo obligatorio",
   B4: "Campo obligatorio",
   C1: "Campo obligatorio",
   C2: "Campo obligatorio",
   C3: "Campo obligatorio",
   C4: "Campo obligatorio",
   D1: "Campo obligatorio",
   D2: "Campo obligatorio",
   D3: "Campo obligatorio",
   D4: "Campo obligatorio",
   D5: "Campo obligatorio",
   D6: "Campo obligatorio"          
}
});
$("#send").click(function(e){
 e.preventDefault();
   e.stopPropagation();
            if ($("#calculoV").valid()) {
                var v = a = b = c = d = 0;
		//Acondicionamiento no estructural -- A
		v = v + ($("input[name='A1']:checked").val() * 3);
		v = v + ($("input[name='A2']:checked").val() * 4);
                v = v + ($("input[name='A3']:checked").val() * 6);
                v = v + ($("input[name='A4']:checked").val() * 3);
                v = v + ($("input[name='A5']:checked").val() * 2);
                v = v + ($("input[name='A6']:checked").val() * 2);
		a = v;
		
		//Información y divulgación  -- B
		v = v + ($("input[name='B1']:checked").val() * 6);
		v = v + ($("input[name='B2']:checked").val() * 3);
		v = v + ($("input[name='B3']:checked").val() * 4);
		v = v + ($("input[name='B4']:checked").val() * 7);
		b = v - a;
		
		//Organización               --C
                v = v + ($("input[name='C1']:checked").val() * 6);
                v = v + ($("input[name='C2']:checked").val() * 5);
                v = v + ($("input[name='C3']:checked").val() * 3);
                v = v + ($("input[name='C4']:checked").val() * 6);
		c = v - (b + a);
		
		//Planificación              ---D
		v = v + ($("input[name='D1']:checked").val()  * 6);
		v = v + ($("input[name='D2']:checked").val()  * 2);
		v = v + ($("input[name='D3']:checked").val()  * 2);
		v = v + ($("input[name='D4']:checked").val()  * 2);
		v = v + ($("input[name='D5']:checked").val()  * 3);
		v = v + ($("input[name='D6']:checked").val()  * 5);
		d = v - (c + b + a);
		
		//Agregando la respuesta al dialogo
		if (v == 80)
		    nivel = "<span class='muybajo'>muy bajo</span>";
		else if (v>=45 && v<80)
		    nivel = "<span class='bajo'>baja</span>";
		else if (v>=28 && v<45)
		    nivel = "<span class='moderado'>moderada</span>";
		else if (v>=24 && v<28)
		    nivel = "<span class='alto'>alta</span>";
	        else if (v<24)
	            nivel = "<span class='muyalto'>muy alta</span>";
                $(".dialogo").html("");
		$(".dialogo").html("<div id='resultados'><strong>Resultados:</strong><br><br> \
				   <div id='tabla'> <table>" +
		            "<thead><tr><th>Categorias</th><th>Puntaje</th></tr></thead>\
			    <tfoot><tr><td style='text-align:left'>Total</td><td>"+ v+"</td></tr></tfoot><tbody>" +
			    "<tr><td><strong>Acondicionamiento no estructural</strong></td><td>"+a+"</td></tr>"+
			    "<tr class='alt'><td><strong>Informaci&oacute;n y divulgaci&oacute;n</strong> </td><td>"+b+"</td></tr>"+
			    "<tr><td><strong>Organizaci&oacute;n</strong> </td><td>"+c+"</td></tr>"+
			    "<tr class='alt'><td><strong>Planificaci&oacute;n</strong> </td><td>"+d+"</td></tr></tbody>" +
			    
			    "</table></div>"+ "<br>Su nivel de vulnerabilidad es <strong>"+nivel+"</strong></div>");
		$("#contenedor").hide();
                $(".dialogo").show('slow');
                
	    }
        });
});