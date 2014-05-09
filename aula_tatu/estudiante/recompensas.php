<?php
require '../config.php';

if($_SESSION['usuario']['tipo'] != 'ESTUDIANTE') die('No autorizado');
p_set_rel_path('../');
$existe = false;
//Consulta de todas las recompensas
if (isset($_GET["all"])){
$query = "SELECT r.id_recompensa, r.nombre, r.ruta, r.descripcion,
    COALESCE(NULL, (SELECT COUNT(id_recompensa) FROM tbl_per_act_recompensa WHERE r.id_recompensa=id_recompensa)) as count1,
    COALESCE(NULL, (SELECT COUNT(id_recompensa) FROM tbl_per_com_recompensa WHERE r.id_recompensa=id_recompensa GROUP BY id_recompensa )) as count2,
    COALESCE(NULL, (SELECT COUNT(id_recompensa) FROM tbl_per_cont_recompensa WHERE r.id_recompensa=id_recompensa GROUP BY id_recompensa)) as count3,
    COALESCE(NULL, (SELECT COUNT(id_recompensa) FROM tbl_per_are_recompensa WHERE r.id_recompensa=id_recompensa GROUP BY id_recompensa)) as count4
    FROM tbl_recompensas AS r";
    $q0=mysql_query($query);
    if(!$q0) die('Error en la consulta de los Contenidos <br><b>'.mysql_error().'</b><br> Consulte al Administrador del Sistema');
    if(mysql_num_rows($q0)>0){
     $medallas="Estas son las recompensas que has ganado por <strong>resolver actividades con Tatu H&uacute;:</strong>
        <br><br>
        <div style='max-width: 350px; text-align:center; margin: 0 auto;'>";
      while($qa0=mysql_fetch_assoc($q0)){
        $cant = 0;
            if ($qa0["count1"])
                $cant = $qa0["count1"];
            elseif ($qa0["count2"])
                $cant = $qa0["count2"];
            elseif ($qa0["count3"])
                $cant = $qa0["count3"];
            elseif ($qa0["count4"])
                $cant = $qa0["count4"];
            if($cant > 0){
            $existe = true;
            $medallas.='<p class="wrapped relative" style="max-width:250px; ">
                             <span class="ribbon"><span class="ribbon-inner">'.$cant.'</span></span>
                             <br>
                             <img src="../'.$qa0["ruta"].'" style="width:auto; height:100px;">
                             <br>
                             '.$qa0["descripcion"].'<br><br>
                     </p><br>';
            }
        }
        $medallas.="</div>";
    }
}
else if (isset($_GET["id_contenido"]) && $_GET["id_contenido"] != ""){
    $query = 'SELECT r.id_recompensa, r.nombre, r.ruta, r.descripcion,
            COALESCE(NULL, (SELECT COUNT(A.id_recompensa) FROM tbl_per_act_recompensa A, tbl_actividades B
            WHERE r.id_recompensa=A.id_recompensa
            AND A.id_actividad = B.id_actividad 
            AND B.id_contenido="'.$_GET["id_contenido"].'" GROUP BY id_recompensa)) as count1,
            COALESCE(NULL, (SELECT COUNT(id_recompensa) FROM tbl_per_cont_recompensa WHERE r.id_recompensa=id_recompensa 
            AND id_contenido="'.$_GET["id_contenido"].'"
            GROUP BY id_recompensa)) as count2
            FROM tbl_recompensas AS r';
    $q0=mysql_query($query);
    if(!$q0) die('Error en la consulta de los Contenidos <br><b>'.mysql_error().'</b><br> Consulte al Administrador del Sistema');
    if(mysql_num_rows($q0)>0){
         $medallas="Estas son las recompensas que has ganado por <strong>resolver actividades con Tatu H&uacute;</strong> en
             el contenido: <br><strong>".$_GET["contenido"]."</strong>
        <br><br>
        <div style='max-width: 350px; text-align:center; margin: 0 auto;'>";
      while($qa0=mysql_fetch_assoc($q0)){
        $cant = 0;
            if ($qa0["count1"])
                $cant = $qa0["count1"];
            if ($qa0["count2"])
                $cant = $qa0["count2"];
            if($cant > 0){
             $existe = true;
            $medallas.='<p class="wrapped relative" style="max-width:250px; ">
                             <span class="ribbon"><span class="ribbon-inner">'.$cant.'</span></span>
                             <br>
                             <img src="../'.$qa0["ruta"].'" style="width:auto; height:100px;">
                             <br>
                             '.$qa0["descripcion"].'<br><br>
                     </p><br>';
            }
        }
        $medallas.="</div>";
    }
}
$contenido='<div id="centro">';
if (!$existe){
    $contenido .= '<img src="../plantilla/img/standard/error.png" alt="no hay actividades"> <spam style="color:red;">A&uacute;n no tienes recompensas... </spam><br><br>
                   <spam style="color:green;">&iexcl;Realiza actividades en el aula para ganar recompensas!</span><br>
                   </div>';   
}
else{
  $contenido.= $medallas.'</div>';   
}

p_contenido('centro',$contenido);

p_con_menu(true);
p_contenido('titulo_1','Recompensas');
p_contenido('titulo_grande_1','Recompensas');
p_contenido('migajas','<a href="index.php"> &Aacute;reas de Aprendizaje </a> &gt; <a href="#">Recompensas</a> ');

p_con_pizarra(true);
p_contenido('pizarra','Tus recompensas por hacer actividades');

p_contenido('tipo_usuario',$_SESSION['usuario']['tipo']);
p_contenido('msg_nombre_usuario','HOLA!');
p_contenido('nombre_usuario',$_SESSION['persona']['nombre'].' '.$_SESSION['persona']['apellido']);

//Botones Izquierda
require '_shortcuts.php';
p_shortcuts_set_activo('Inicio');

p_set_menu_archivo('menu_tatu.php');

p_dibujar();    
/*}
else{
    header("location: index.php");
}*/
?>
