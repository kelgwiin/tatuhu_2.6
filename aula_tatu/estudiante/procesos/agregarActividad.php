<?php
//Almacena una actividad realizada por el estudiante
if (isset($_GET["id_estudiante"]) && $_GET["id_estudiante"]!="" && isset($_GET["id_actividad"]) && $_GET["id_actividad"]!=""
          && isset($_GET["tipo"]) && $_GET["tipo"]!="" && 
           isset($_GET["ultima"]) && $_GET["ultima"]!=""){
require '../../config.php';
//Progreso del estudiante
$query = "INSERT INTO tbl_persona_actividad(id_actividad, id_persona, completada, fecha) VALUES
          ('".$_GET["id_actividad"]."','".$_GET["id_estudiante"]."','SI', CURDATE())";
$q1=mysql_query($query);

//Recompensas
if($q1){ 
$query = "SELECT id_recompensa,nombre FROM tbl_recompensas WHERE 1"; //Obtenemos recompensas disponibles en el sistema
$q1=mysql_query($query);
if ($q1){
    
$tipos_rec = array();
while($data=mysql_fetch_assoc($q1)){
    $tipos_rec[] = $data;
    if ($data["nombre"] == $_GET["tipo"])
        $id = $data["id_recompensa"];
    else if ($data["nombre"] == "Actividades de un contenido")
        $AC = $data["id_recompensa"];
    else if ($data["nombre"] == "Actividades de un componente")
        $ACP = $data["id_recompensa"];
    else if ($data["nombre"] == "Trofeo")
        $AA = $data["id_recompensa"];
}
$recompensas = "";
$query = "INSERT INTO tbl_per_act_recompensa(id_persona, id_actividad,id_recompensa)
          VALUES ('".$_GET["id_estudiante"]."','".$_GET["id_actividad"]."','".$id."')";
$q1=mysql_query($query);
if($q1){
    $recompensas .= "$id-";  //juego/lectura
 if ($_GET["ultima"] == "1"){ //indica si es la ultima actividad de un contenido
      $query = "INSERT INTO tbl_per_cont_recompensa(id_persona, id_contenido,id_recompensa)
          VALUES ('".$_GET["id_estudiante"]."','".$_GET["contenido"]."','".$AC."')"; 
          $q1=mysql_query($query);
      if ($q1){
          $recompensas .= "$AC-";  //todas las actividades de un contenido (se gana una sola vez)
          //se verifica si estan todas las actividades de un componente
          $query = "SELECT COUNT( DISTINCT A.id_actividad ) CE, COUNT( DISTINCT B.id_actividad ) CA
                    FROM tbl_persona_actividad A
                    RIGHT JOIN (
                    SELECT act.id_actividad
                    FROM tbl_actividades act, tbl_contenido cont
                    WHERE cont.id_componente =  '".$_GET["componente"]."'
                    AND act.id_contenido = cont.id_contenido
                    AND act.usuario =  'ESTUDIANTE'
                    )B ON A.id_actividad = B.id_actividad
                    AND A.id_persona =  '".$_GET["id_estudiante"]."'";
           $q1=mysql_query($query);
           if ($q1){
               $cant = mysql_fetch_row($q1);
               if($cant[0] >= $cant[1]){
                   $query = "INSERT INTO tbl_per_com_recompensa(id_persona, id_componente,id_recompensa)
                    VALUES ('".$_GET["id_estudiante"]."','".$_GET["componente"]."','".$ACP."')";
                    $q1=mysql_query($query);
                    if($q1){
                        $recompensas .= "$ACP-";
                        //se verifica si estan todas las actividades de un area de aprendizaje
                        $query = 'SELECT COUNT( DISTINCT A.id_actividad ) CE, COUNT( DISTINCT B.id_actividad ) CA
                                  FROM tbl_persona_actividad A
                                    RIGHT JOIN (
                                    SELECT act.id_actividad
                                    FROM tbl_actividades act, tbl_contenido cont, tbl_componente comp
                                    WHERE act.usuario =  "ESTUDIANTE"
                                    AND act.id_contenido = cont.id_contenido
                                    AND cont.id_componente = comp.id_componente
                                    AND comp.id_area = "'.$_GET["area"].'"
                                    AND comp.id_grado = "'.$_SESSION["datos_educativos"]["id_grado"].'"
                                    )B ON A.id_actividad = B.id_actividad
                                    AND A.id_persona =  "'.$_GET["id_estudiante"].'"';
                        $q1=mysql_query($query);
                        if ($q1){
                            $cant = mysql_fetch_row($q1);
                            if($cant[0] >= $cant[1]){
                               $query = "INSERT INTO tbl_per_are_recompensa(id_persona, id_area,id_recompensa)
                                VALUES ('".$_GET["id_estudiante"]."','".$_GET["area"]."','".$AA."')"; 
                                $q1=mysql_query($query);
                                if($q1){
                                   $recompensas .= "$AA-"; 
                                }
                            }
                        }
                    }
               }
           }
      }
    }
}
$recompensas[strlen($recompensas)-1]="";
echo $recompensas;
}
}
}

?>