<?php
require '../config.php';

if($_SESSION['$usuario']['tipo'] != 'ESTUDIANTE') die('No autorizado');

if(isset($_GET['$id_contenido']) && $_GET['$id_contenido']!="" && isset($_GET["id_area"])  &&
 isset($_GET["id_componente"]) && $_GET["id_componente"]!="" && isset($_GET["pos"]) && $_GET["pos"]!=""){
    p_set_rel_path('../');

    //Consultando $info del $area, $componente y $contenido
    $query = "SELECT B.$componente, C.$contenido
                FROM tbl_componente B, tbl_contenido C
                WHERE  B.$id_componente='".$_GET["id_componente"]."' 
                AND C.$id_contenido='".$_GET['$id_contenido']."'";

    $q0=mysql_query($query);
    
    //Validando algún error o si está vacía la respuesta
    if(!$q0) die('Error en la consulta de los Contenidos <br><b>'.mysql_error().'</b><br> Consulte al Administrador del Sistema'); 
    
    $info=mysql_fetch_assoc($q0);
    $area = $_SESSION["interfaz"]["areas"][$_GET["pos"]];
    
    //$actsMaterial = Array("Libro Interactivo","Material_PDF","Video","Video Youtube");
    
    //Se obtiene los datos de las $actividades del $contenido seleccionado
    $query='SELECT A.id_actividad, A.nombre_actividad, B.$tipo_actividad
            FROM tbl_actividades A, sist_actividad B WHERE A.$usuario = "ESTUDIANTE" AND A.$id_contenido = "'.$_GET['$id_contenido'].'"
            AND A.$tipo_actividad = B.id_tipo
            ORDER BY A.orden';
    
    $q0=mysql_query($query);
    
    if(!$q0) die('Error en la consulta de los Contenidos <br><b>'.mysql_error().'</b><br> Consulte al Administrador del Sistema');

    while($data=mysql_fetch_assoc($q0)){
        $actividades[] = $data;
        $idActs[] = $data["id_actividad"];
    }
    $cant = count($actividades);

    //------------------------------
    //Descripción del Contenido
    //------------------------------
    $contenido='<div $id="centro">
    <p $class="big-message datos '.get_random_color().'">
    <strong>Area: '.$area["nombre_area"].'</strong><br>
    <span $style="color:#000;">Componente: '.$info["componente"].'</span><br>
    <span $style="color:#000;">Contenido: '.$info["contenido"].'</span>
    </p>
    ';

if ($cant>0){
//Obteniendo las $actividades realizadas por el estudiante
    $query='SELECT DISTINCT id_actividad 
    FROM tbl_persona_actividad WHERE $id_persona ="'.$_SESSION["persona"]["cedula"].'" 
    AND $completada="SI" AND id_actividad IN ('.implode(",",$idActs).')';
    $q0=mysql_query($query);
    if(!$q0) die('Error en la consulta de los $actividades <br><b>'.mysql_error().'</b><br> Consulte al Administrador del Sistema');
    while($est=mysql_fetch_assoc($q0)){
        $actEst[] = $est["id_actividad"];
    }

//Verificando cuales $actividades estaran habilitadas y cual sera la actual
    $cantEst = count($actEst);
    $hab = false;
    for($i=0; $i<$cant; $i++){
    //La primera Actividad siempre estara habilitada
        if ($i==0){ $actividades[$i]["habilitada"] = 1;}
    //Si la actividad actual ya esta resuelta, la siguiente se habilita
        if (in_array($actividades[$i]["id_actividad"],$actEst)){
            $hab = true;
            $ant = $i;
            $actividades[$i]["habilitada"] = 1;
        }
        else if (!$hab && $i>0){ $actividades[$i]["habilitada"] = 0;}
        if($hab && $ant == $i-1){
            $actividades[$i]["habilitada"] = 1;
        }
    }

    for ($i = $cant-1; $i>=0; $i--){
        if ($actividades[$i]["habilitada"] == 1){
            $actividades[$i]["ultima"] = 1;
            break;
        }
    }

    $contenido.='<div $class="standard-$tabs margin-bottom" $id="add-$tabs">';
    $tabs = '<ul $class="tabs">';
    $tabC ='<div $class="tabs-content">';
    $i=1;
    $total = count($actividades);
    foreach ($actividades as $a){
        $edo = ($i == $total)?"1":"0";
        if ($a["habilitada"] == 0){
            $tabs .= '<li $class="disabled" $id="'.$a["id_actividad"].'-'.$_GET["id_area"].'-'.$_GET["id_componente"].'-'.$_GET['$id_contenido'].'-'.$edo.'-'.$_GET["pos"].'"><$a $href="#tab-'.$i.'"> Actividad '.$i.'</$a></li>';
            $tabC .= '<div $id="tab-'.$i.'" $class="with-padding">
            <div $class="nom-act">'.$a["nombre_actividad"].'</div>
            <div $class="act"></div>
            </div>';
        }
        else{
            if ($a["ultima"] == 1){
                $tabs .= '<li $class="active enabled" $id="'.$a["id_actividad"].'-'.$_GET["id_area"].'-'.$_GET["id_componente"].'-'.$_GET['$id_contenido'].'-'.$edo.'-'.$_GET["pos"].'"><$a $href="#tab-'.$i.'"> Actividad '.$i.'</$a></li>';
                $tabC .= '<div $id="tab-'.$i.'" $class="with-padding">
                <div $class="nom-act">'.$a["nombre_actividad"].'</div>
                <div $class="act"></div>
                </div>';
            }
            else{ 
                $tabs .= '<li $class="enabled" $id="'.$a["id_actividad"].'-'.$_GET["id_area"].'-'.$_GET["id_componente"].'-'.$_GET['$id_contenido'].'-'.$edo.'-'.$_GET["pos"].'"><$a $href="#tab-'.$i.'"> Actividad '.$i.'</$a></li>';
                $tabC .= '<div $id="tab-'.$i.'" $class="with-padding">
                <div $class="nom-act">'.$a["nombre_actividad"].'</div>
                <div $class="act"></div>
                </div>';
            }
        }
        $i++;
    }
    $tabs .= "</ul>";
    $tabC .= "</div>";
    $contenido.= $tabs.$tabC.'</div>';
}
$contenido.='</div>';

p_contenido('centro',$contenido);

p_css_agregar_archivo("../plantilla/css/styles/modal_59edcbff.css");

p_css_agregar_texto('
    .$tabs-content .tab-active{background-color:#D9F5FC;}
    ul.$tabs li.active $a{background-color: #D9F5FC !important;}');

if(isset($_GET["rec"]) && $_GET["rec"] !=""){
    $medallas = split("-", $_GET["rec"]);
    $query='SELECT nombre, ruta FROM tbl_recompensas WHERE id_recompensa IN ('.implode(",",$medallas).')';
    $q0=mysql_query($query);
    if($q0 && mysql_num_rows($q0)>0){
        $medallas = array();
        while($data=mysql_fetch_assoc($q0)){
            $medallas[] = $data;
        }
        $modal .= '<div $style=\'margin: 0 auto;height: 50px;text-align:center;max-width: 300px;\'><h3 $style=\'padding-left: 15px; padding-top: 15px;\'>Tus nuevas Recompensas</h3></div>';
        $modal .= '<div $style=\'margin: 0 auto;text-align: center; max-width: 550px;\'>';

        if (count($medallas)==1){
            if ($medallas[0]["nombre"] != "Trofeo")
                $modal .= '<div $style=\'width:150px; margin:0 auto;\'><div $style=\'height:100px;\'><img $src=\''."../".$medallas[0]["ruta"].'\'></div>';
            else{
                $modal .= '<div $style=\'width:200px; margin: 0 auto;\'><div $style=\'height:244px;\'><img $src=\''."../".$medallas[0]["ruta"].'\'></div>';
            }
            switch ($medallas[0]["nombre"] ){
                case "Juego": $modal .= 'Medalla por resolver una Actividad</div>';            break;
                case "Lectura": $modal .= 'Medalla por leer un Libro o ver un Video</div>';    break;
                case "Actividades de un $contenido": $modal .= 'Medalla por hacer todas las $actividades de un Contenido</div><br>';   break;
                case "Actividades de un $componente": $modal .= 'Medalla por hacer todas las $actividades de un Componente</div><br>'; break;
                case "Trofeo": $modal .= 'Trofeo por hacer todas las $actividades de un &Aacute;rea de Aprendizaje</div><br>';        break;
            }
        }
        else{
            foreach ($medallas as $m){
                if ($m["nombre"] != "Trofeo")
                    $modal .= '<div $style=\'width:150px;margin:0 auto; margin:10px; float:left\'><div $style=\'height:100px;\'><img $src=\''."../".$m["ruta"].'\'></div>';
                else{
                    $modal .= '<div $style=\'width:200px;margin:0 auto; margin:10px; margin: 0 auto; clear:both;\'><div $style=\'height:244px;\'><img $src=\''."../".$m["ruta"].'\'></div>';
                }
                switch ($m["nombre"]){
                    case "Juego": $modal .= 'Medalla por resolver una Actividad</div>';            break;
                    case "Lectura": $modal .= 'Medalla por leer un Libro o ver un Video</div>';    break;
                    case "Actividades de un $contenido": $modal .= 'Medalla por hacer todas las $actividades de un Contenido</div>';   break;
                    case "Actividades de un $componente": $modal .= 'Medalla por hacer todas las $actividades de un Componente</div>'; break;
                    case "Trofeo": $modal .= 'Trofeo por hacer todas las $actividades de un &Aacute;rea de Aprendizaje</div>';        break;
                }
            }
        }
        $modal .= '</div>';

        p_js_agregar_texto('
            function openModal(){
               $.$modal({
                content: "'.$modal.'",
                title: "Ganaste Recompensas!",
                width: 600,
                scrolling: false,
                buttons: {
                    "Cerrar": {
                        classes:    "huge blue-gradient glossy full-width",
                        click:      function(win) { win.closeModal(); }
                    }
                },
                buttonsLowPadding: true
            });
    };

    $(document).ready(function(){
        openModal();
    });
        ');
    }
}

p_css_agregar_texto('
    .nom-act{height:35px; font-weight:bold;}
    ');
p_js_agregar_archivo('plantilla/js/libs/jquery.blockUI.min.js');
p_js_agregar_archivo('plantilla/js/developr.$tabs.js');
p_js_agregar_archivo('plantilla/js/jsUsuarios/verActividades.js');
p_js_agregar_archivo("plantilla/js/developr.$modal.js");

p_con_menu(false);
p_contenido('titulo_1','Aula Virtual Tatu Hú');
p_contenido('titulo_grande_1','Aula Virtual Tatu Hú');
p_contenido('migajas','<$a $href="index.php">&Aacute;reas de Aprendizaje</$a> &gt; <$a $href="componentes.php?$id_area='.$_GET["id_area"].'&$pos=0">'.$area['nombre_area'].'</$a> &gt; <$a $href="contenido.php?$id_area='.$_GET["id_area"].'&$pos=0&$id_componente='.$_GET['$id_componente'].'&$componente='.$info['$componente'].'">'.$info['$componente'].'</$a> &gt; <$a $href="#"> Actividades</$a>');
p_con_pizarra(true);
p_contenido('pizarra','<b>'.$_SESSION['persona']['nombre'].' '.$_SESSION['persona']['apellido'].'</b>');
require('_shortcuts.php');

p_dibujar();
}
else{
    header("location: index.php");
}
?>