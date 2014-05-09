<?php
//Carga una actividad o material dentro de un iframe

if (isset($_GET["id"]) && $_GET["id"]!="" && isset($_GET["area"]) && $_GET["area"]!=""
        && isset($_GET["componente"]) && $_GET["componente"]!=""
        && isset($_GET["contenido"]) && $_GET["contenido"]!=""
        && isset($_GET["ult"]) && $_GET["ult"]!=""
        && isset($_GET["pos"]) && $_GET["pos"]!=""){
require '../../config.php';
$actsMaterial = Array("Libro Interactivo","Material_PDF","Video","Video Youtube");
$actsActividad = Array("Sopa de Letras","Crucigrama");

//Se recupera todo lo necesario para el funcionamiento de la actividad
    $query = 'SELECT A.tipo_actividad, A.enlace FROM sist_actividad A, tbl_actividades B
                WHERE B.id_actividad="'.$_GET["id"].'" AND B.tipo_actividad = A.id_tipo';
    if(!($q1=mysql_query($query))) error(mysql_error());
    $actividad = mysql_fetch_assoc($q1);
    if($actividad){
        $funcionalidad = "../".$actividad["enlace"];
        
        //Materiales Audio-Visuales
        if (in_array($actividad["tipo_actividad"],$actsMaterial)){
            $query= "SELECT ruta, tipo,id_material FROM tbl_act_material WHERE id_actividad='".$_GET["id"]."'";
            
            if(!($q0=mysql_query($query))) error(mysql_error());
            $material = mysql_fetch_assoc($q0);
        }
        else if (in_array($actividad["tipo_actividad"],$actsActividad)){
            
        }
        $get= "?idActividad=".$_GET["id"]."&idEstudiante=".$_SESSION["persona"]["cedula"]."&area=".$_GET["area"]."&componente=".$_GET["componente"]."&contenido=".$_GET["contenido"]."&ultima=".$_GET["ult"]."&pos=".$_GET["pos"];
        $iframe .='<iframe width="100%" height="600" class="iframe" frameborder="0" src="'.$funcionalidad.$get.'"></iframe>';
        echo $iframe;
    }

}

?>