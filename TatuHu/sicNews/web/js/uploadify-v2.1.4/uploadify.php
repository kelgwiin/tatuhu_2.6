<?php
    require_once 'html2text.php';
    require '../../../src/conexion.php';
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
if (!empty($_FILES)) {
        //Carga de Archivos
        $tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
        
        $fileName= $_FILES['Filedata']['name'];

        $extension = end(explode('.',$fileName));
        $onlyName = substr($fileName,0,strlen($fileName)-(strlen($extension)+1));
        
        $targetFile =  str_replace('//','/',$targetPath) . $onlyName . ".txt";
		move_uploaded_file($tempFile,$targetFile);
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
        //Fin Carga
        
        //Eliminando Etiquetas HTML
        $html = file_get_contents($targetFile);
        $plain_text = html2text( $html );
        //Fin 
        $plain_text =  strtr(strtolower($plain_text), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÜÚ", "àáâãäåæçèéêëìíîïðñòóôõöøùüú");
	//Eliminando àáâãäåæçèéêëìíîïðñòóôõöøùüú
	$plain_text = str_replace("à","a",$plain_text);
	$plain_text = str_replace("á","a",$plain_text);
	$plain_text = str_replace("â","a",$plain_text);
	$plain_text = str_replace("ã","a",$plain_text);
	$plain_text = str_replace("ä","a",$plain_text);
	$plain_text = str_replace("å","a",$plain_text);
	$plain_text = str_replace("æ","a",$plain_text);
	$plain_text = str_replace("è","e",$plain_text);
	$plain_text = str_replace("é","e",$plain_text);
	$plain_text = str_replace("ê","e",$plain_text);
	$plain_text = str_replace("ë","e",$plain_text);
	$plain_text = str_replace("ì","i",$plain_text);
	$plain_text = str_replace("í","i",$plain_text);
	$plain_text = str_replace("î","i",$plain_text);
	$plain_text = str_replace("ï","i",$plain_text);
	$plain_text = str_replace("ñ","n",$plain_text);
	$plain_text = str_replace("ò","o",$plain_text);
	$plain_text = str_replace("ó","o",$plain_text);
	$plain_text = str_replace("ô","o",$plain_text);
	$plain_text = str_replace("õ","o",$plain_text);
	$plain_text = str_replace("ö","o",$plain_text);
	$plain_text = str_replace("ù","u",$plain_text);
	$plain_text = str_replace("ü","u",$plain_text);
	$plain_text = str_replace("ú","u",$plain_text);
	$plain_text = str_replace("Ž","",$plain_text);
	//Eliminando Articulos
	$plain_text = str_replace(" las "," ",$plain_text);
	$plain_text = str_replace(" los "," ",$plain_text);
	$plain_text = str_replace(" la "," ",$plain_text);
	$plain_text = str_replace(" lo "," ",$plain_text);
	$plain_text = str_replace(" de "," ",$plain_text);
	//Eliminando Simbolos !@#$%^&*()_+=[]{}|
	$plain_text = str_replace("'"," ",$plain_text);
	$plain_text = str_replace('"',' ',$plain_text);
	$plain_text = str_replace("!"," ",$plain_text);
	$plain_text = str_replace("@"," ",$plain_text);
	$plain_text = str_replace("#"," ",$plain_text);
	$plain_text = str_replace("$"," ",$plain_text);
	$plain_text = str_replace("%"," ",$plain_text);
	$plain_text = str_replace("^"," ",$plain_text);
	$plain_text = str_replace("&"," ",$plain_text);
	$plain_text = str_replace("*"," ",$plain_text);
	$plain_text = str_replace("("," ",$plain_text);
	$plain_text = str_replace(")"," ",$plain_text);
	$plain_text = str_replace("_"," ",$plain_text);
	$plain_text = str_replace("-"," ",$plain_text);
	$plain_text = str_replace("+"," ",$plain_text);
	$plain_text = str_replace("="," ",$plain_text);
	$plain_text = str_replace("["," ",$plain_text);
	$plain_text = str_replace("]"," ",$plain_text);
	$plain_text = str_replace("{"," ",$plain_text);
	$plain_text = str_replace("}"," ",$plain_text);
	$plain_text = str_replace("|"," ",$plain_text);
	$plain_text = str_replace("`"," ",$plain_text);
	$plain_text = str_replace("~"," ",$plain_text);
	$plain_text = str_replace("."," ",$plain_text);
	$plain_text = str_replace(","," ",$plain_text);
	$plain_text = str_replace("<"," ",$plain_text);
	$plain_text = str_replace(">"," ",$plain_text);
	$plain_text = str_replace("/"," ",$plain_text);
	$plain_text = str_replace("?"," ",$plain_text);
	$plain_text = str_replace(":"," ",$plain_text);
	$plain_text = str_replace(";"," ",$plain_text);
	$plain_text = str_replace("¿"," ",$plain_text);
	$plain_text = str_replace("Ž","",$plain_text);
	$plain_text = str_replace("¼","",$plain_text);
	$plain_text = str_replace("³","",$plain_text);
	$plain_text = str_replace("²","",$plain_text);
	$plain_text = str_replace("¨","",$plain_text);
	$plain_text = str_replace("®","",$plain_text);
	$plain_text = str_replace("·","",$plain_text);
	
	function elimina_acentos($cadena)
	{
	$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
	$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
	return utf8_encode((strtr($cadena,utf8_decode($tofind),$replac)));

	}	
	//$plain_text = eregi_replace("[\n|\r|\n\r]", ' ', $plain_text);	//elimino el salto de linea
	$plain_text = elimina_acentos($plain_text);
	//ELIMINANDO STOPWORDS
	$search  = array(' un ', ' una ', ' unas ',' unos ',' uno ',' sobre ',' todo ',' tambien ',' tras ',' otro ',' algun ',' alguno ',' alguna ',' algunos ',' algunas ',' ser ',' es ',' soy ',' eres ',' somos ',' sois ',' estoy ',' esta ',' estamos ',' estais ',' estan ',' como ',' en ',' para ',' atras ',' porque ',' por que ',' estado ',' estaba ',' ante ',' antes ',' siendo ',' ambos ',' pero ',' por ',' poder ',' puede ',' puedo ',' podemos ',' podeis ',' pueden ',' fui ',' fue ',' fuimos ',' fueron ',' hacer ',' hago ',' hace ',' hacemos ',' haceis ',' hacen ',' cada ',' fin ',' incluso ',' primero ',' desde ',' conseguir ',' consigo ',' consigue ',' consigues ',' conseguimos ',' consiguen ',' ir ',' voy ',' va ',' vamos ',' vais ',' van ',' vaya ',' gueno ',' ha ',' tener ',' tengo ',' tiene ',' tenemos ',' teneis ',' tienen ',' el ',' la ',' lo ',' las ',' los ',' su ',' aqui ',' mio ',' tuyo ',' ellos ',' ellas ',' nos ',' nosotros ',' vosotros ',' vosotras ',' si ',' dentro ',' solo ',' solamente ',' saber ',' sabes ',' sabe ',' sabemos ',' sabeis ',' saben ',' ultimo ',' largo ',' bastante ',' haces ',' muchos ',' aquellos ',' aquellas ',' sus ',' entonces ',' tiempo ',' verdad ',' verdadero ',' verdadera ',' cierto ',' ciertos ',' cierta ',' ciertas ',' intentar ',' intento ',' intenta ',' intentas ',' intentamos ',' intentais ',' intentan ',' dos ',' bajo ',' arriba ',' encima ',' usar ',' uso ',' usas ',' usa ',' usamos ',' usais ',' usan ',' emplear ',' empleo ',' empleas ',' emplean ',' ampleamos ',' empleais ',' valor ',' muy ',' era ',' eras ',' eramos ',' eran ',' modo ',' bien ',' cual ',' cuando ',' donde ',' mientras ',' quien ',' con ',' entre ',' sin ',' trabajo ',' trabajar ',' trabajas ',' trabaja ',' trabajamos ',' trabajais ',' trabajan ',' podria ',' podrias ',' podriamos ',' podrian ',' podriais ',' yo ',' aquel ');
	$plain_text = str_replace($search, ' ', $plain_text);
        
        $plain_text = str_replace(' A ', ' ', $plain_text);
        $plain_text = str_replace(' a ', ' ', $plain_text);
            
        $id = fopen($targetPath."/".$onlyName.".txt",'w+');
        fwrite($id, $plain_text);
        fclose($id);
        //Fin 
        $direc = $targetPath."/".$onlyName.".txt";
        
        $query = "INSERT INTO noticia (id_noticia,  dir_noticia, nomb_noticia) VALUES (NULL,'$direc','$onlyName')"; 
        mysql_query($query);
}
?>