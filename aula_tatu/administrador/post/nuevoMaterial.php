<?php
require_once '../../config.php';
require_once '../../plantilla/php/validator/validator_archivos.php';
require_once '../../funcMods/utils.php';

if (isset($_POST["nombre"]) && isset($_POST["retroalimentacion"]) && isset($_POST["tipo"])
    && isset($_POST["usuario"]) && isset($_POST["area"]) && isset($_POST["componente"]) 
    && isset($_POST["contenido"]) 
    && $_POST["nombre"] != "" && $_POST["retroalimentacion"] != "" && $_POST["tipo"]!= "" 
    && $_POST["area"] != "" && $_POST["usuario"] != "" && $_POST["contenido"]!= "" 
    && $_POST["componente"] != "" && ($_POST["usuario"]=="ESTUDIANTE" || $_POST["usuario"]=="PROFESOR")){
   
    //consultamos el orden de la ultima Actividad insertada
    $query = 'SELECT orden+1 AS orden FROM tbl_actividades WHERE id_contenido="'.$_POST["contenido"].'"
              ORDER BY orden DESC LIMIT 0,1';
    $q0 = mysql_query($query); 
    if (!$q0){
        echo "<img src='../plantilla/img/standard/error.png'> Error al consultar el orden del material, recargue la p&aacute;gina e intente nuevamente.";
    }
    else{ 
        $qa0=mysql_fetch_assoc($q0);
        $tipoMatS = split('-', $_POST["tipo"]);
        $idMat = $tipoMatS[0];
        $tipoMat = $tipoMatS[1]; 
        $nombretipoMat = $tipoMatS[2]; 
        //query para la insercion de una actividad generica
        $query = "INSERT INTO tbl_actividades(orden,tipo_actividad, id_contenido, nombre_actividad, 
                  retroalimentacion, usuario)
                  VALUES('".$qa0["orden"]."','".$idMat."','".$_POST["contenido"]."','".htmlentities($_POST["nombre"])."', '".htmlentities($_POST["retroalimentacion"])."','".$_POST["usuario"]."')";

        /***************** validando el form segun el tipo del material *****************/
        $errorArc = false;
        $tipos = Array("pdf","swf","ogv","mp4","png");
        $mensajeError = "";
        //PDF
            if ($tipoMat =="materialpdf"){
                $aux = array_slice($tipos,0,1);
                if (!nombre_correcto($_FILES["archivo0"]["name"]) ||
                    !tipo_correcto ($_FILES["archivo0"]["name"], $aux) ||
                    !tamanio_correcto($_FILES["archivo0"]["tmp_name"], 5242880) || 
                    !check_file($_FILES["archivo0"])){ //5MB
                    $errorArc = true;
                    $mensajeError = "Compruebe el tipo del archivo (debe ser PDF) y el tama&ntilde;o (menor a 5MB)";
                }
            }
         //Libro Interactivo o Diccionario (Varios archivos)
            else if ($tipoMat == "librointeractivo" || $tipoMat == "diccionariointeractivo"){
                   $cantHojas = count($_FILES);
                   $aux = array_slice($tipos,4,1);
                   for ($i = 0; $i < $cantHojas; $i++){
                        if (!nombre_correcto($_FILES["archivo".$i]["name"]) ||
                            !tipo_correcto ($_FILES["archivo".$i]["name"], $aux) ||
                            !tamanio_correcto($_FILES["archivo".$i]["tmp_name"], 153600) ||
                            !check_file($_FILES["archivo".$i])){ //50KB   ------ojoo
                            $errorArc = true;
                            $mensajeError = "Compruebe el tipo de las im&aacute;genes (deben ser PNG) y el tama&ntilde;o (menor a 50KB)";
                            break;
                        }
                        else if ($tipoMat == "diccionariointeractivo" ){ 
                            $tam = valida_tamanio_imagen($_FILES["archivo".$i]["tmp_name"], 120, 100, 140, 200);
                            if ($tam == "MAX"){ //140 * 190
                              $errorArc = true;
                              $mensajeError .= "La imagen ".($i+1)." excede el tama&ntilde;o m&aacute;ximo permitido (140X200)<br>";
                            }
                            else if ($tam == "MIN"){
                                $errorArc = true;
                                $mensajeError .= "La imagen ".($i+1)." excede el tama&ntilde;o m&iacute;nimo permitido (120X100)<br>";
                            }
                        }
                        else if ($tipoMat == "librointeractivo"){    //360*515
                            $tam = valida_tamanio_imagen($_FILES["archivo".$i]["tmp_name"], 300, 500, 370, 520);
                            if ($tam == "MAX"){ 
                              $errorArc = true;
                              $mensajeError .= "La imagen ".($i+1)." excede el tama&ntilde;o m&aacute;ximo permitido (370X520)<br>";
                            }
                            else if ($tam == "MIN"){
                                $errorArc = true;
                                $mensajeError .= "La imagen ".($i+1)." excede el tama&ntilde;o m&iacute;nimo permitido (300X500)<br>";
                            }
                        }
                   }
                    //en el caso del diccionario interactivo comprobamos las palabras y definiciones
                   if ($tipoMat == "diccionariointeractivo"){
                       for ($i = 0; $i < $cantHojas; $i++){
                           if (!isset($_POST["palabra".$i]) || $_POST["palabra".$i]=="" ||
                               !isset($_POST["definicion".$i]) || $_POST["definicion".$i]=="" ){
                               $mensajeError .= "<br>Compruebe que todas las palabras y deficiones del diccionario est&eacute;n llenas correctamente"; 
                               $errorArc = true;
                               break;
                           }
                       }
                   }
            }
         // Materia del tipo Video: MP4 u OGV
            else if($tipoMat == "video"){
                $aux = array_slice($tipos,2,2);
                if (!nombre_correcto($_FILES["archivo0"]["name"]) ||
                    !tipo_correcto ($_FILES["archivo0"]["name"], $aux) ||
                    !tamanio_correcto($_FILES["archivo0"]["tmp_name"], 10485760) ||
                    !check_file($_FILES["archivo0"])){ //2MB
                    $errorArc = true;
                    $mensajeError = "Compruebe el tipo del video (debe ser OGV o MP4) 
                                     y el tama&ntilde;o (menor a 10MB)";
                }
                
            }
         // Video de Youtube
            else if($tipoMat == "videoyoutube"){
                if (isset($_POST["enlace"]) && $_POST["enlace"] != ""){
                    $dir = video_ID($_POST["enlace"]);
                    if (strlen($dir) != 11 ){
                         $errorArc = true;
                         $mensajeError = "Compruebe que el id del video sea correcto";
                    }
                }
                else{
                    $errorArc = true; 
                    $mensajeError = "Compruebe que el enlace del video sea correcto";
                }
            }
            
         // FLASH - Dejar siempre de ultimo
            else{
                $aux = array_slice($tipos,1,1);
                if (!nombre_correcto($_FILES["archivo0"]["name"]) ||
                    !tipo_correcto ($_FILES["archivo0"]["name"], $aux) ||
                    !tamanio_correcto($_FILES["archivo0"]["tmp_name"], 2097152)){ //2MB
                    $errorArc = true;
                    $mensajeError = "Compruebe el tipo de la animaci&oacute;n (debe ser SWF) 
                                     y el tama&ntilde;o (menor a 2MB)";
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
                    $sufix = date("Y").date("m").date("d").substr(md5(uniqid(rand())),0,10);
       //PDF        
                    if ($tipoMat =="materialpdf"){
                      $dir = "uploadLibros/Libro".$_POST["usuario"][0]."_".$sufix;
                      $nombreArch = $dir."/".get_nombre_subida($sufix, $_FILES["archivo0"]["name"]);
                      if(mkdir("../../".$dir,0777)){
                          if (@move_uploaded_file($_FILES["archivo0"]["tmp_name"],"../../".$nombreArch)){
                              $query = "INSERT INTO tbl_act_material(id_actividad,tipo,ruta)
                                               VALUES ('".$ultID."','PDF','".$nombreArch."')";
                          
                              $ruta = "../".$nombreArch;
                          }
                          else{ 
                              $errorSubida = true;
                              $mensajeError = "Error al copiar el Material, compruebe que el directorio uploadLibros/ tiene permisos de escritura";
                          }
                      }
                      else{ 
                          $errorSubida = true;
                          $mensajeError = "Error al crear el directorio, compruebe que el directorio uploadLibros/ tiene permisos de escritura";
                      }
                    }
    //Libro Interactivo - Diccionario Interactivo
                    else if($tipoMat == "librointeractivo" || $tipoMat == "diccionariointeractivo"){
                        $imgs = "";
                        if ($tipoMat == "diccionariointeractivo")
                                $dir = "uploadLibros/Diccionario".$_POST["usuario"][0]."_".$sufix;
                        else
                                $dir = "uploadLibros/Libro".$_POST["usuario"][0]."_".$sufix."/";
                        if(mkdir("../../".$dir,0777)){
                           for ($i = 0; $i < $cantHojas; $i++){
                             $img = ($i<10?"0".$i+1:$i+1).".png";
                             $nombre = $dir."/".$img;
                             if (!@move_uploaded_file($_FILES["archivo".$i]["tmp_name"],"../../".$nombre)){
                                 $errorSubida = true;
                                 $mensajeError = "Error al copiar el Material, compruebe que el directorio uploadLibros/ tiene permisos de escritura";
                                 break;
                             }
                             else{
                                 if ($tipoMat == "diccionariointeractivo"){
                                    $imgs .= $nombre."#";
                                    $pal .= htmlentities($_POST["palabra".$i])."#";
                                    $term .=  htmlentities($_POST["definicion".$i])."#";
                                 }
                             }
                           }
                           if(!$errorSubida){
                                if ($tipoMat == "diccionariointeractivo"){
                                    $imgs = trim($imgs,"#");
                                    $pal = trim($pal,"#");
                                    $term = trim($term,"#");
                                     $query = "INSERT INTO tbl_act_diccionario (id_actividad,terminos,significado,imagenes) VALUES ('".$ultID."','".$pal."','".$term."','".$imgs."')";
                                }
                                else
                                     $query = "INSERT INTO tbl_act_material(id_actividad,tipo,ruta) VALUES ('".$ultID."','Libro Interactivo','".$dir."')";
                           
                                $ruta = "../".$dir;    
                           }
                        }
                    }
           //Archivo de Video
                    else if ($tipoMat == "video"){
                        $dir = "uploadVideos/Video".$_POST["usuario"][0]."_".$sufix;
                        $nombre = $dir."/".get_nombre_subida($sufix, $_FILES["archivo0"]["name"]);
                        if(mkdir("../../".$dir,0777)){
                             $nombre = $dir."/VID_".$sufix."_".$_FILES["archivo0"]["name"];
                             if (!@move_uploaded_file($_FILES["archivo0"]["tmp_name"],"../../".$nombre)){
                                 $errorSubida = true;
                                 $mensajeError = "Error al copiar el Material, compruebe que el directorio uploadVideos/ tiene permisos de escritura";
                             }
                             else{
                                 $query = "INSERT INTO tbl_act_material(id_actividad,tipo,ruta)
                                               VALUES ('".$ultID."','Video','".$nombre."')";
                                 $ruta = "../".$nombre;
                             }
                        }
                    }
                    else if($tipoMat == "videoyoutube"){
                        $query = "INSERT INTO tbl_act_material(id_actividad,tipo,ruta)
                                   VALUES ('".$ultID."','Video Youtube','".$_POST["enlace"]."')";

                    }
          //Flash - Siempre dejar de ultimo
                    else{
                        $dir = "uploadFlash/FWL".$_POST["usuario"][0]."_".$sufix;
                        if(mkdir("../../".$dir,0777)){
                             $nombre = $dir."/".get_nombre_subida($sufix, $_FILES["archivo0"]["name"]);
                             if (!@move_uploaded_file($_FILES["archivo0"]["tmp_name"],"../../".$nombre)){
                                 $errorSubida = true;
                                 $mensajeError = "Error al copiar el Material, compruebe que el directorio uploadVideos/ tiene permisos de escritura";
                                 break;
                             }
                             else{
                                 $query = "INSERT INTO tbl_act_material(id_actividad,tipo,ruta)
                                               VALUES ('".$ultID."','Flash','".$nombre."')";
                                $ruta = "../".$nombreArch;
                                 
                             }
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
                 mysql_query("ROLLBACK");
                $mensajeError = "Error al registar los datos del Material, recargue la p&aacute;gina e intente nuevamente";
             }
             else{
                 $ultIDMat = mysql_insert_id();
                 mysql_query("COMMIT");
             ?>
                 <div style="margin: 0 auto; max-width: 400px;">
                        <span style="color: green;"><img src="../plantilla/img/standard/correcto.png" alt="Correcto"> El material fue registrado exitosamente</span><br>
                        <h3 class="thin"> <span style="font-weight: bold;">Datos del Material: </span></h3>
                        <div style="min-width:200px;max-width:400px; margin: 0 auto;">
                                <p class="big-message" style="min-width:200px;max-width:400px; margin: 0 auto;">
                                        <strong><?php echo $_POST["nombre"]; ?></strong></br>
                                        Nombre del Material <br><br>
                                        <strong><?php echo $nombretipoMat; ?></strong><br>
                                        Tipo  <br><br>
                                        <strong> <a href="material_visualizar.php?id=<?php echo $ultIDMat;?>&idA=<?php echo $ultID;?>&nombre=<?php echo $_POST["nombre"];?>&add" style="font-size:12px">Click para abrir el material</a></strong><br>
                                        Ruta  <br><br>
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