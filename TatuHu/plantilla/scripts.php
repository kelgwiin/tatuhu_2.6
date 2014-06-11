<title>:: Proyecto Tatu H&uacute; ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta content="Universidad de Carabobo - FACYT" name="author" />
<meta content="Educaci&oacute;n y concienciaci&oacute;n de la comunidad Vivienda Rural de B&aacute;rbula en la prevenci&oacute;n y manejo de riesgos ante desastres naturales, desde un entorno de aprendizaje mediado por las tecnolog&iacute;as.&quot;" name="description" />
<meta content="riesgos, gesti&oacute;n de riesgos, educaci&oacute;n, desastres naturales, tecnolog&iacute;a, TIC, conciencia, prevenci&oacute;n, FACYT, Universidad de Carabobo" name="keywords" />

<link rel="icon" type="image/png" href="images/favicon.ico" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="css/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="css/login/login.css" media="all"/>

<script type="text/javascript" src="js/jquery-1.8.3.js" ></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js" ></script>
  <!--[if lt IE 7]>
  	<link rel="stylesheet" href="css/ie/ie6.css" type="text/css" media="all">
  <![endif]-->
  <!--[if lt IE 9]>
  	<script type="text/javascript" src="js/html5.js"></script>
        <script type="text/javascript" src="js/IE9.js"></script>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->

<?php
//REdireccionamiento dependiendo del dispositivo
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!isset($_GET["complete"])){
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
header('Location: mobile/index.php');
}
//Se verifica si es nueva visita
session_start();
if (!isset($_SESSION["visit_tatuhu"]) || empty($_SESSION['visit_tatuhu'])){
     $_SESSION["visit_tatuhu"] = 1; //Nueva visita, creamos variable de sesion
    /* Verificamos el navegador para mostrar mensaje al usuario (si es IE)
     * Mostramos el mensaje solo la primera vez que el usuario entre despues de abrir
     * el navegador.
     */
  echo '  
        <script type="text/javascript">
          if ( $.browser.msie ) {
            $(function() {
              $("#alertIE").css("display","block");
                  $( "#alertIE" ).dialog({
                      height: 280,
                      width: 400,
                      modal: true,
                      autoOpen:true,
                      buttons: {
                        "Cerrar": function() {
                          $( this ).dialog( "close" );
                        }
                      }
              });
            });
          }
        </script>';
}

$page_current = substr($_SERVER['PHP_SELF']);//Nombre de la petición al server la URI
$pos = strrpos($page_current, '/');//buscando la posición del ultimos slash "/"
$page = substr($page_current, $pos+1);//obteniendo sólo el nombre de la página

//Aplicando estilos inividuales para cada pagina, para no recargar el archivo styles.css
if ($page == "index.php"){   //Estilos para pagina principal
    echo '
        <style>
          aside.inicio{
                      float: right;
                      margin-left: 0;
                      margin-right: 52px;
            }
            .loguito:hover{

            }
        </style> 
    ';
}
elseif ($page == "proyectoTatuHu.php"){
    echo '
    <style>
    	aside.proyecto{
		float: left;
		margin-left: 0;
		margin-right: 52px;
		width: 315px;
	}
	
	#content{
		width: 520px;
	}
    </style>  
    ';
}
elseif ($page == "riesgosNaturales.php"){
    echo '
    <style>
        aside{
          float: left;
          width: 302px;
          margin-left: 0px;
          margin-right: 40px;
        }
    </style> ';
}
elseif ($page == "desarrollosTatuHu.php"){
    echo '
     <style>
        aside{
                    float: right;
                    margin-left: 0;
                    margin-right: 40px;
    
            }
      </style> ';
}
elseif ($page == "utilidadesTatuHu.php" || $page == "descargasTatuHu.php"){
    echo '
    <link rel="stylesheet" href="css/tooltip.css" type="text/css" media="all">
     <style>
        aside{
            margin-left: 0px;
            margin-right: 10px;
        }
        h2{font-weight: bold;}
        .inside{padding-right: 27px;}
        figure{float:left; padding-right: 5px;}
    </style>
    
    ';
}
?>
