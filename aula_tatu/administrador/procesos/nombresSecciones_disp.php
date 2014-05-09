<?php
require '../../config.php';
$nombres = array(
    "A"=>"A","B"=>"B","C"=>"C","D"=>"D","E"=>"E","F"=>"F","G"=>"G","H"=>"H",
    "I"=>"I","J"=>"J","K"=>"K","L"=>"L","M"=>"M","N"=>"N","&Ntilde;"=>"&Ntilde;","O"=>"O",
    "P"=>"P","Q"=>"Q","R"=>"R","S"=>"S","T"=>"T","U"=>"U","V"=>"V","W"=>"W","X"=>"X","Y"=>"Y","Z"=>"Z"
);
if (isset($_GET["id_grad"]) && $_GET["id_grad"]!="" && isset($_GET["id_ins"]) && $_GET["id_ins"]!=""){
   $query="SELECT seccion FROM tbl_seccion WHERE id_grado='".$_GET["id_grad"]."' AND id_colegio='".$_GET["id_ins"]."'";
   $q0=mysql_query($query);
   if(!$q0) die(mysql_error());
    while($qa0=mysql_fetch_assoc($q0)){
        if(in_array($qa0['seccion'],$nombres))
            unset ($nombres[$qa0['seccion']]);
    }
    $cant = count($nombres);
    $secciones='';
    if ($cant>0){
        foreach($nombres as $s){
           $secciones.='<option value="'.$s.'">'.$s.'</option>';
        }
        echo $secciones;
    }
    else
    {
        
    }
    
}
else{
    echo "0";
}
?>