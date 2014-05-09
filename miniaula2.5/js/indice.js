$("#indice").html(enlaces);

var rutaAbsoluta = self.location.href;        // http://asdas.asd/uno/dos/index.html 
var posicionUltimaBarra = rutaAbsoluta.lastIndexOf("/"); 
var rutaRelativa = rutaAbsoluta.substring( posicionUltimaBarra + "/".length , rutaAbsoluta.length );       // index.html 

$("#indice a").each(function(){
	if ($(this).attr("href") === rutaRelativa)
		$(this).attr("class", "current");
});