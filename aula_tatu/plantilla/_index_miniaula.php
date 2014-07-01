<?php 
error_reporting(~E_ALL);
$meses=array(1=>'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago','Sep','Oct','Nov','Dic');
?>
<!DOCTYPE html>
<!--[if IEMobile 7]><html class="no-js iem7 oldie"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js ie7 oldie" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js ie8 oldie" lang="en"><![endif]-->
<!--[if (IE 9)&!(IEMobile)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if (gt IE 9)|(gt IEMobile 7)]><!-->
<?php
	if(isset($html['bgcolor']) && $html['bgcolor']!=''){
		echo '<html class="no-js" lang="en" style="background-color:'.$html['bgcolor'].';">';
	}else{
		echo '<html class="no-js" lang="en">';
	}
?>
<!--<![endif]-->
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Aula Virtual Tatu H&uacute;</title>                                                    <!-- EH -->
	<meta name="description" content="Aula virtual Tatu H&uacute;">
	<meta name="author" content="Proyecto PEI - 2012000190">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<!-- ESTILOS -->
	<link rel="stylesheet" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/stylesTatu/paginas_tatu.css">
	<link rel="stylesheet" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/reset_59edcbff.css">
	<link rel="stylesheet" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/style_59edcbff.css">
	<link rel="stylesheet" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/colors_59edcbff.css">
	<link rel="stylesheet" media="print" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/print_59edcbff.css">
	
	<!-- For progressively larger displays -->
	<link rel="stylesheet" media="only all and (min-width: 480px)" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/480_59edcbff.css">
	<link rel="stylesheet" media="only all and (min-width: 768px)" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/768_59edcbff.css">
	<link rel="stylesheet" media="only all and (min-width: 992px)" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/992_59edcbff.css">
	<link rel="stylesheet" media="only all and (min-width: 1200px)" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/1200_59edcbff.css">
	<!-- For Retina displays -->
	<link rel="stylesheet" media="only all and (-webkit-min-device-pixel-ratio: 1.5), only screen and (-o-min-device-pixel-ratio: 3/2), only screen and (min-device-pixel-ratio: 1.5)" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/2x_59edcbff.css">
	<!-- Webfonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
	<!-- Additional styles -->
        <link rel="stylesheet" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/css/styles/dashboard_59edcbff.css">

	<!-- JavaScript at bottom except for Modernizr -->
	<script src="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/js/libs/modernizr.custom.js"></script>
	<!-- For everything else -->
	<link rel="shortcut icon" href="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/img/favicons/favicon.ico">
    <!-- User related CSSs -->
    <?php
        foreach($css['files'] as $f) {
            echo '<link rel="stylesheet" href="'.$f.'">'."\r\n";
        }
    ?>
	<!-- Microsoft clear type rendering -->
	<meta http-equiv="cleartype" content="on">
	<!-- IE9 Pinned Sites: http://msdn.microsoft.com/en-us/library/gg131029.aspx -->
	<meta name="application-name" content="Developr Admin Skin">
	<meta name="msapplication-tooltip" content="Cross-platform admin template.">
	<meta name="msapplication-starturl" content="http://www.display-inline.fr/demo/developr">
	<!-- These custom tasks are examples, you need to edit them to show actual pages -->
	<meta name="msapplication-task" content="name=Agenda;action-uri=http://www.display-inline.fr/demo/developr/agenda.html;icon-uri=http://www.display-inline.fr/demo/developr/img/favicons/favicon.ico">
	<meta name="msapplication-task" content="name=My profile;action-uri=http://www.display-inline.fr/demo/developr/profile.html;icon-uri=http://www.display-inline.fr/demo/developr/img/favicons/favicon.ico">
	<meta charset="UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Noto+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <style>
        <?php
            foreach(@$css['text'] as $c) {
                echo $c."\r\n".'/* ---------------- */'."\r\n";
            }
        ?>
    </style>
</head>

<?php
$body='<body class="clearfix';
if (isset($con_shortcuts) && $con_shortcuts==true) {
    $body.=' with-shortcuts';
}
if (isset($con_menu) && $con_menu==true) {
    $body.=' with-menu';
}
$body.='">';
echo $body;
?>
<!-- Title bar -->
<header role="banner" id="title-bar"><h2>Aula Virtual Tatu H&uacute;</h2></header>
    <?php if (isset($con_menu) && $con_menu==true) { ?>
	<!-- Button to open/hide menu -->
	<a href="javascript:void(0);" id="open-menu"><span>Menu</span></a>
    <?php } ?>
<!-- Button to open/hide shortcuts -->
<a href="javascript:void(0);" id="open-shortcuts"><span class="icon-thumbs"></span></a>
<!-- Main content -->
<section role="main" id="main">
<hgroup id="main-title" class="thin" style="background-color:#d2cc9d; font-family: 'Noto Sans', sans-serif; color:#164f69">
    <h1><?php echo $contenido['titulo_grande_1'];?></h1><br><?php echo $contenido['migajas'];?>
    <h2><?php echo $meses[(date('m')+0)].' <strong>'.date('d').'</strong>';?></h2>
</hgroup>
<?php
        if (isset($pizarra['activo']) && $pizarra['activo']==true) {
            echo '<div align="center" class="dashboard">'.$contenido['pizarra'].' </div>';
        }
 ?>





<!-- Contenido Principal -->
<!--- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->


<?php printf ("Desde Miniauala Grado '%s' <br>",$_SESSION['datos_educativos']['grado']); ?>




<?php echo $contenido['centro']; ?>
<!--- ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->
<!-- Fin contenido Principal -->


</section>
<!-- End main content -->
<!-- Side tabs shortcuts -->
<ul id="shortcuts" role="complementary" class="children-tooltip tooltip-right">
    <?php
    foreach($shortcuts as $nombre=>$sc_data) {
        if(!is_null($sc_data['clase'])) {
            echo '<li'.(($sc_data['current']==true)?' class="current"':'').'><a href="'.$sc_data['link'].'" class="'.$sc_data['clase'].'" title="'.$nombre.'">'.$nombre.'</a></li>';
        }else{
            echo '<li'.(($sc_data['current']==true)?' class="current"':'').'><a href="'.$sc_data['link'].'" class="shortcut-'.strtolower($nombre).'" title="'.$nombre.'">'.$nombre.'</a></li>';
        }
    }

    ?>
</ul>
<?php if (isset($con_menu) && $con_menu==true) { ?>
    <!-- Sidebar/drop-down menu -->
	<section id="menu" role="complementary">
		<div id="menu-content">
			<header><?php echo $contenido['tipo_usuario']; ?></header>
			<div id="profile">
				<img src="<?php echo "../".$_SESSION['persona']['ruta_imagen'] ?>" alt="Imagen de Perfil" class="user-icon">
				<?php echo $contenido['msg_nombre_usuario']; ?>
				<span class="name"><?php echo $contenido['nombre_usuario']; ?></span>
			</div>
		<ul id="access" class="children-tooltip">
                    <?php
                            //Incluyendo menu de la derecha segun tipo de usuario
                            if ($_SESSION['usuario']['tipo'] == 'PROFESOR'){
                                    require_once ('../docente/_access.php');
                            }
                            else if ($_SESSION['usuario']['tipo'] == 'ADMINISTRADOR'){
                                    require_once ('../administrador/_access.php');
                            }
			   else if ($_SESSION['usuario']['tipo'] == 'ESTUDIANTE'){
                                    require_once ('../estudiante/_access.php');
                            }
                    ?>
		</ul>
		<section class="navigable">
			<?php 
				foreach($menu['archivos'] as $a) {
				    require($a);
				}
			?>
		</section>
		<ul class="unstyled-list">
			<?php 
                           if ($_SESSION['usuario']['tipo'] == 'ESTUDIANTE'){
                                    require_once ('../estudiante/mensajes_tatu.php');
                            }
			?>
		</ul>
		</div>
	</section>
	<!-- End sidebar/drop-down menu -->
    <?php
    }
    ?>

	<!-- JavaScript at the bottom for fast page loading -->
	<!-- Scripts -->
	<script src="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/js/libs/jquery-1.8.3.min.js"></script>
	<script src="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/js/setup.js"></script>
	<script src="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/js/developr.navigable.js"></script>
	<script src="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/js/developr.tooltip.js"></script>
	<!-- Template functions -->
    <?php
		$tabs = false;
        foreach ($js_files as $t) {
			if ($t != "plantilla/js/developr.tabs.js")
				echo '<script src="'.(isset($rel_path)?str_replace('//','/',@$rel_path.'/'):'').$t.'"></script>'."\r\n";
			else 
				$tabs = true;
        }
		if ($tabs)
			echo '<script src="'.(isset($rel_path)?str_replace('//','/',@$rel_path.'/'):'').'plantilla/js/developr.tabs.js"></script>'; // Must be loaded last
    ?>
	<script src="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/js/developr.scroll.js"></script>

	<!-- Tinycon -->
	<script src="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/js/libs/tinycon.min.js"></script>
	<script>
		$.template.init();// Call template init (optional, but faster if called manually)
	</script>
    <script src="<?php if (isset($rel_path)) echo str_replace('//','/',@$rel_path.'/'); ?>plantilla/js/libs/fjjf.js"></script>
    <script>
    /** User defined scripts **/
    <?php
        foreach ($js as $t) {
            echo $t."\r\n".'// -----------------'."\r\n";
        }
    ?>
    </script>
</body>
</html>