

<?php
	$grado_ = $_SESSION['datos_educativos']['grado'];

		$quinto = substr_count($grado_, "5");
		if($quinto > 0 ){ // Es quinto grado
			$grado_url = "../../miniaula2.5/grados.html?grado=5";			
		}else{// es sexto
			$grado_url = "../../miniaula2.5/grados.html?grado=6";
		}
?>

<script type="text/javascript" src="../../miniaula2.5/js/iframe.js"></script>

<div style="padding-left:0px; color:#fff;">

 <iframe id="" width="" height="800" src = "<?php echo $grado_url;?>" 
	style="margin:0 auto; border: none; width:100%; height:800px; margin-top:1px; margin-left:1px; margin-right: 1px">
</iframe>

</div>

