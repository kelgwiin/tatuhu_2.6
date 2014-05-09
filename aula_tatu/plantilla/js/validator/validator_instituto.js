//Codigo SINACOE
$.validator.addMethod("sinacoe", function(value, element) { 
        var reg = /^([a-z1-90]{10})$/i;
                return reg.test(value);
});
$.validator.addMethod("nombre", function(value, element) { 
    if (value==="") return true;
    else{
    var reg = /^([a-z áéíóúñ]{2,60})$/i;
    return reg.test(value);
    }
});
$.validator.addMethod("telefono", function(value, element) { 
        numero = value.split("_").join("");
        if (numero === "-") return true;
        else{
            var reg = /^((([0-9]{1})*[- .(]*([0-9]{3})[- .)]*[0-9]{3}[- .]*[0-9]{4})+)*$/;
            return reg.test(value);
        }
});