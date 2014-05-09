<?php
require_once '../../config.php';
require_once '../../plantilla/php/validator/validator_archivos.php';
require_once '../../funcMods/utils.php';
require_once '../../plantilla/php/validator/validator_datos_usuario.php';

function sanearPalabra($text){
    $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
    $text = strtolower($text);
    $patron = array (
    '/&agrave;/' => 'a',
    '/&egrave;/' => 'e',
    '/&igrave;/' => 'i',
    '/&ograve;/' => 'o',
    '/&ugrave;/' => 'u',

    '/&aacute;/' => 'a',
    '/&eacute;/' => 'e',
    '/&iacute;/' => 'i',
    '/&oacute;/' => 'o',
    '/&uacute;/' => 'u',

    '/&acirc;/' => 'a',
    '/&ecirc;/' => 'e',
    '/&icirc;/' => 'i',
    '/&ocirc;/' => 'o',
    '/&ucirc;/' => 'u',

    '/&atilde;/' => 'a',
    '/&etilde;/' => 'e',
    '/&itilde;/' => 'i',
    '/&otilde;/' => 'o',
    '/&utilde;/' => 'u',

    '/&auml;/' => 'a',
    '/&euml;/' => 'e',
    '/&iuml;/' => 'i',
    '/&ouml;/' => 'o',
    '/&uuml;/' => 'u',

    '/&auml;/' => 'a',
    '/&euml;/' => 'e',
    '/&iuml;/' => 'i',
    '/&ouml;/' => 'o',
    '/&uuml;/' => 'u',
    '/&aring;/' => 'a');
    $text = preg_replace(array_keys($patron),array_values($patron),$text);
    return strtoupper($text);
}

//print_r($_POST);
if (isset($_POST["nombre"]) && isset($_POST["retroalimentacion"]) && isset($_POST["tipo"])
    &&  isset($_POST["area"]) && isset($_POST["componente"]) 
    && isset($_POST["contenido"]) && isset($_POST["indices"])
    && $_POST["nombre"] != "" && $_POST["retroalimentacion"] != "" && $_POST["tipo"]!= "" 
    && $_POST["area"] != "" && $_POST["contenido"]!= "" && $_POST["componente"] != ""
    && $_POST["indices"] != ""){
   
    //consultamos el orden de la ultima Actividad insertada
    $query = 'SELECT orden+1 AS orden FROM tbl_actividades WHERE id_contenido="'.$_POST["contenido"].'"
              ORDER BY orden DESC LIMIT 0,1';
    $q0 = mysql_query($query); 
    if (!$q0)
        echo "<img src='../plantilla/img/standard/error.png'> Error al consultar el orden del material, recargue la p&aacute;gina e intente nuevamente.";
    else{ 
        $qa0=mysql_fetch_assoc($q0);
        $tipoMat = split('-', $_POST["tipo"]);
        $nombreMat = $tipoMat[2];
        $idMat = $tipoMat[0];
        $tipoMat = $tipoMat[1];
        
        //query para la insercion de una actividad generica
        $query = "INSERT INTO tbl_actividades(orden,tipo_actividad, id_contenido, nombre_actividad, 
                  retroalimentacion, usuario)
                  VALUES('".$qa0["orden"]."','".$idMat."','".$_POST["contenido"]."','".htmlentities($_POST["nombre"])."', '".htmlentities($_POST["retroalimentacion"])."','ESTUDIANTE')";

        /***************** validando el form segun el tipo del material *****************/
        $errorArc = false;
        $tipos = Array("png", "jpg");
        $mensajeError = "";
        //Sopa de letras
        if ($tipoMat =="sopaletras"){
            $ind = split(",",$_POST["indices"]);
            $cant = count($ind)-1;
            $palabras = "";
            for ($i = 0; $i < $cant; $i++){
               if (!isset($_POST["palabra".$i]) || $_POST["palabra".$i]=="" || !nombresValidos($_POST["palabra".$i])){
                   $mensajeError .= "<br>Compruebe que todas las palabras de la sopa de letras est&eacute;n 
                       llenas correctamente, y que no contengan caracteres especiales"; 
                   $errorArc = true;
                   break;
               }
               else{
                   $pal=sanearPalabra($_POST["palabra".$i]);
                   $desc = $desc.$pal.",";
                   $palabras = $palabras.$pal.",";
               }
            }
            if (!$errorArc){
               $palabras = trim($palabras, ',');
               $desc=trim($desc, ',');;
            }
        }
        //Crucigrama
        else if ($tipoMat =="crucigrama" || $tipoMat == "pareodepalabras"){
            $ind = split(",",$_POST["indices"]);
            $cant = count($ind)-1;
             $palabras = "";
             $pistas = "";
             $desc = "";
           for ($i = 0; $i < $cant; $i++){
               if (!isset($_POST["palabra".$i]) || $_POST["palabra".$i]=="" || !nombresValidos($_POST["palabra".$i])
                   || !isset($_POST["definicion".$i]) || $_POST["definicion".$i]=="" ){
                   $mensajeError .= "<br>Compruebe que todas las palabras y pistas del est&eacute;n llenas correctamente, 
                       y que no contengan caracteres especiales";; 
                   $errorArc = true;
                   break;
               }
               else{
                   if ($tipoMat =="crucigrama")
                    $pal=sanearPalabra($_POST["palabra".$i]);
                   else
                    $pal = htmlentities($_POST["palabra".$i]);
                   
                   $palabras = $palabras.$pal."#";
                   $definicion = $definicion.htmlentities($_POST["definicion".$i])."#";
                   $desc = $desc."<span style='color:green'>".$pal."</span>: ".htmlentities($_POST["definicion".$i])."<br>";
               }
           }
           if (!$errorArc){
                $palabras=trim($palabras, '#');;
                $definicion=trim($definicion, '#');;
           }
        }
       //Pareo con Imagenes
        else if ($tipoMat =="pareo"){
          $pistas = "";
          $imagenes = "";
           for ($i = 0; $i < 3; $i++){
               if (!isset($_POST["pista".$i]) || $_POST["pista".$i]=="" ||
                   !isset($_FILES["img".$i])){
                   $mensajeError .= " Compruebe que todas las im&aacute;genes y pistas del crucigrama est&eacute;n llenas correctamente<br>"; 
                   $errorArc = true;
                   break;
               }
               else{
                   if (!nombre_correcto($_FILES["img".$i]["name"]) ||
                            !tipo_correcto ($_FILES["img".$i]["name"], $tipos) ||
                            !tamanio_correcto($_FILES["img".$i]["tmp_name"], 102400) ||
                            !check_file($_FILES["img".$i])){
                            $errorArc = true;
                            $mensajeError .= " Compruebe el tipo de las im&aacute;genes (deben ser PNG &oacute; JPG) y el tama&ntilde;o (menor a 50KB)<br>";
                            break;
                   }
                   else{
                       $tam = valida_tamanio_imagen($_FILES["img".$i]["tmp_name"], 50, 50, 130, 200);
                            if ($tam == "MAX"){
                              $errorArc = true;
                              $mensajeError .= " La imagen ".($i+1)." excede el tama&ntilde;o m&aacute;ximo permitido (130X200)<br>";
                            }
                            else if ($tam == "MIN"){
                                $errorArc = true;
                                $mensajeError .= " La imagen ".($i+1)." excede el tama&ntilde;o m&iacute;nimo permitido (50X50)<br>";
                            }
                   }
               }
               if (!$errorArc){
                   $pistas = $pistas.htmlentities($_POST["pista".$i])."#";
               }
           }
           if (!$errorArc){
               $pistas=trim($pistas, '#');
           }
        }
        /***************** Peparando Querys dependiendo del tipo de Material ***************/
        /*****************       Subiendo segun el tipo de material          ***************/
        if (!$errorArc){
            $errorSubida = false;
            mysql_query("BEGIN");
            $q0=mysql_query($query); //Insertando en tbl_actividades
            if ($q0){
                $ultID = mysql_insert_id();
                if ($tipoMat =="sopaletras"){
                    $query = "INSERT INTO tbl_act_sopadeletras(id_actividad, palabras) 
                                VALUES (".$ultID.",'".$palabras."')";
                }
                else if($tipoMat == "crucigrama"){
                    $query = "INSERT INTO tbl_act_crucigramas(id_actividad,palabras,pistas) VALUES
                                (".$ultID.",'".$palabras."','".$definicion."')";
                }
                else if($tipoMat == "pareodepalabras"){
                    $query="INSERT INTO tbl_act_pareopalabras (id_actividad, pistas, palabras) VALUES
                            (".$ultID.",'".$palabras."','".$definicion."')";
                }
                else if ($tipoMat =="pareo"){
                    $sufix = date("Y").date("m").date("d").substr(md5(uniqid(rand())),0,10);
                    $dir = "uploadActividades/miraDescribe/MD_".$ultID."_".$sufix;
                    if(mkdir("../../".$dir,0777)){
                     for ($i = 0; $i < 3; $i++){
                         $nombreArch = get_nombre_subida($sufix, $_FILES["img".$i]["name"]);
                         $nombre = $dir."/".$nombreArch;
                        if (!@move_uploaded_file($_FILES["img".$i]["tmp_name"],"../../".$nombre)){
                                 $errorSubida = true;
                                 $mensajeError = "Error al copiar las im&aacute;genes, compruebe que el directorio uploadActividades/ tiene permisos de escritura";
                                 break;
                        }
                        $desc = $desc.htmlentities($_POST["pista".$i]).": <a href='../".$dir."/".$nombreArch."' target='_blank' style=\"font-size:12px\">Clic para ver la Imagen</a><br>";
                        $imagenes = $imagenes."miraDescribe/MD_".$ultID."_".$sufix."/".$nombreArch."#";
                     }
                    }
                    if (!$errorSubida){
                        $imagenes = trim($imagenes, "#");
                        $query = "INSERT INTO tbl_act_pareo(id_actividad, pistas, imagenes) VALUES
                              (".$ultID.",'".$pistas."','".$imagenes."')";
                    }
                }
            }
            else{
                $errorSubida = true;
                $mensajeError = "Error al registar los datos del Material, recargue la p&aacute;gina e intente nuevamente";
            }
        }
        if ($errorArc || $errorSubida){
            mysql_query("ROLLBACK");
            echo "<img src='../plantilla/img/standard/error.png'> ".$mensajeError;
        }
        else{
            $q0=mysql_query($query);
            
             if (!$q0){
                 echo "aqu";
                 mysql_query("ROLLBACK");
                 $mensajeError = "Error al registar los datos del Material, recargue la p&aacute;gina e intente nuevamente";
                 echo "<img src='../plantilla/img/standard/error.png'> ".$mensajeError;
             }
             else{
                 mysql_query("COMMIT");
                 
             ?>
                 <div style="margin: 0 auto; max-width: 400px;">
                        <span style="color: green;"><img src="../plantilla/img/standard/correcto.png" alt="Correcto"> La actividad fue creada exitosamente</span><br>
                        <h3 class="thin"> <span style="font-weight: bold;">Datos de la Actividad: </span></h3>
                        <div style="min-width:200px; margin: 0 auto;">
                                <p class="big-message" style="min-width:200px;max-width:400px; margin: 0 auto;">
                                        <strong><?php echo $_POST["nombre"]; ?></strong></br>
                                        Nombre de la Actividad <br><br>
                                        <strong><?php echo $nombreMat; ?></strong><br>
                                        Tipo  <br><br>
                                        <strong><?php echo $desc; ?></strong><br>
                                        <?php if ($tipoMat =="sopaletras"){ ?>
                                            Palabras de la Sopa de Letras  <br><br>
                                        <?php } else if($tipoMat =="crucigrama" ){ ?>
                                            Palabras del Crucigrama  <br><br>
                                        <?php } else if($tipoMat =="pareo") {?>
                                            Pistas e im&aacute;genes del Pareo  <br><br>
                                        <?php } else if($tipoMat =="pareodepalabras") {?>
                                            Pistas del Pareo  <br><br>
                                        <?php } ?>  
                                </p>
                        </div>
                    </div>
              <?php
             }
        }
    }
}
else{
    echo "<img src='../plantilla/img/standard/error.png'> Error al enviar los datos del material, verifique que est&eacute;n llenos los campos obligatorios o recargue la p&aacute;gina";
}
?>