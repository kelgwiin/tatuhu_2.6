//Nombres-Acentos y Ñ
$.validator.addMethod("nombre_apellido", function(value, element) { 
        var reg = /^([a-z áéíóúñ]{2,60})$/i;
                return reg.test(value);
});
//cedula
$.validator.addMethod("cedula", function(value, element) {
                var val = value.split("_").join("");
                    var reg = /^([0-9]{7,8})$/i;
                        return reg.test(val);
});
//telefonos	
$.validator.addMethod("telefono", function(value, element) { 
         var val = value.split("_").join("").split("-").join("");
        var reg = /^((([0-9]{1})*[- .(]*([0-9]{3})[- .)]*[0-9]{3}[- .]*[0-9]{4})+)*$/;
        return reg.test(val);
});

$.validator.addMethod("usuario", function(value, element) { 
        var reg = /^([a-z0-9]{8,15})$/i;
        return reg.test(value);
});

//fechas
$.validator.addMethod("fecha", function(value, element) { 
        var currVal = value;
        var ano = (new Date).getFullYear();
        if(currVal == "") return false;
        var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; 
        var dtArray = currVal.match(rxDatePattern); // is format OK?
        if (dtArray == null) return false;
        dtDay = dtArray[1];
        dtMonth= dtArray[3];
        dtYear = dtArray[5];
    if(dtYear > ano) return false;
    if (dtMonth < 1 || dtMonth > 12) return false;
        else if (dtDay < 1 || dtDay> 31) return false;
        else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) return false;
        else if (dtMonth == 2){
                var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
                if (dtDay> 29 || (dtDay ==29 && !isleap)) return false;
        }
        return true;
});
	