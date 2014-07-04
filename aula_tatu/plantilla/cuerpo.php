

<?php
	$grado_ = $_SESSION['datos_educativos']['grado'];

		$quinto = substr_count($grado_, "5");
		if($quinto > 0 ){ // Es quinto grado
			echo "es quintooooo";
		}else{// es sexto
			echo "es sexto";
		}
?>

<script type="text/javascript" src="../../miniaula2.5/js/iframe.js"></script>
<a href="../../miniaula2.5/index.html">Miniaula</a>

<div style="padding-left:50px; color:#fff;">

 <iframe id="" width="900" height="350" src = "../../miniaula2.5/index.html" 
	style="margin:0 auto; border: none; width:800px; height:600px; margin-top:-20px;">
</iframe>

</div>

