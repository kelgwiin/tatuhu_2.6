<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
            <!--  Created by Artisteer v3.0.0.32906  Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"  -->
        <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <title>Inicio</title>
        <!--<link rel="stylesheet" type="text/css" href="./js/bootstrap-3.0.3/dist/css/bootstrap.min.css" media="screen" />-->
        <link rel="stylesheet" type="text/css" href="./css/plantilla2/style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="./css/estilos.css" />
        <link rel="stylesheet" type="text/css" href="./js/jquery-ui-1.10.3.custom/css/smoothness/jquery-ui-1.10.3.custom.min.css" />
        <link rel="stylesheet" type="text/css" href="./js/JSCal2-1.9/src/css/jscal2.css" />
        <link rel="stylesheet" type="text/css" href="./js/JSCal2-1.9/src/css/border-radius.css" />
        <link rel="stylesheet" type="text/css" href="./js/JSCal2-1.9/src/css/steel/steel.css" />
        <link rel="stylesheet" type="text/css" href="./js/uploadify-v2.1.4/uploadify.css"  />
        <link rel="stylesheet" type="text/css" href="./js/prettyLoader/css/prettyLoader.css" media="screen" charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="./js/lofslidernews/css/layout.css" />
        <link rel="stylesheet" type="text/css" href="./js/lofslidernews/css/style3.css" />
        <link rel="stylesheet" type="text/css" href="./js/jqueryui-editable-1.5.1/jqueryui-editable/css/jqueryui-editable.css" />
        
        <!--<script type="text/javascript" src="./js/jquery-1.6.2.js"></script>-->
        <script type="text/javascript" src="./js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="./js/jquery-migrate-1.2.1.js"></script>
        <script type="text/javascript" src="./js/uploadify-v2.1.4/swfobject.js"></script>
        <script type="text/javascript" src="./js/uploadify-v2.1.4/jquery.uploadify.v2.1.4.min.js"></script>      
        <script type="text/javascript" src="./js/jquery.validate.js"></script>
        <script type="text/javascript" src="./js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
        <script type="text/javascript" src="./js/multicombo.js"></script>
        <script type="text/javascript" src="./js/JSCal2-1.9/src/js/jscal2.js"></script>
        <script type="text/javascript" src="./js/JSCal2-1.9/src/js/lang/es.js"></script>
        <script type="text/javascript" src="./css/plantilla2/script.js"></script>
        <script type="text/javascript" src="./js/prettyLoader/js/jquery.prettyLoader.js"></script>
        <script type="text/javascript" src="./js/Highstock-1.3.7/js/highstock.js"></script>
        <script type="text/javascript" src="./js/Highcharts-3.0.7/js/modules/exporting.js"></script>        
        <script type="text/javascript" src="./js/Highstock-1.3.7/js/modules/exporting.js"></script>
        <!--<script type="text/javascript" src="./js/bootstrap-3.0.3/dist/js/bootstrap.min.js"></script>-->
        <script language="javascript" type="text/javascript" src="./js/lofslidernews/js/jquery.easing.js"></script>
        <script language="javascript" type="text/javascript" src="./js/lofslidernews/js/script.js"></script>
        <script language="javascript" type="text/javascript" src="./js/jqFancyTransitions.1.8.min.js"></script>
        <script language="javascript" type="text/javascript" src="./js/jqueryui-editable-1.5.1/jqueryui-editable/js/jqueryui-editable.min.js"></script>
        <script language="javascript" type="text/javascript" src="./js/jquery.cycle.all.js"></script>
        <script type="text/javascript">    
            var $j = jQuery.noConflict();        
            function ir_pag(url){	        
                $j("#contenido").load(url);
            }

            function cerrar(){
                $j.ajax({
                    type: 'POST',
                    url:'../src/facade/usuarioFacade.php?modo=7',
                    async: false,
                    dataType: "text",				   
                    success: function(data){
                        location.href = "http://hpserver-elearning.facyt.uc.edu.ve/TatuHu/riesgosNaturales.php";
                   }
                });
            }
            
            function tutorial(){
                /*var w = window.open("", "popupWindow", "width=900, height=600, scrollbars=yes");
                var $w = $j(w.document.body);
                $w.html('<embed width="400" height="300" src="./css/videos/tutorial.mp4">');
                return false;*/
                
                $j("#dialog-tutorial").dialog({
                    modal: true,
                    width: 800, 
                    height: 600,
                    resizable: false, 
                    draggable: false,
                    autoOpen: false, 
                    buttons:{				
                            Salir: function() {
                                $j(this).dialog('close');
                                return false;
                            }
                    }
                });
                $j("#dialog-tutorial").dialog('open');
                return false;
            }
            $j(document).ready( function(){	
                $j.prettyLoader({
                    //animation_speed: 'fast', /* fast/normal/slow/integer */
                    bind_to_ajax: true, /* true/false */
                    //delay: false, /* false OR time in milliseconds (ms) */
                    loader: './js/prettyLoader/images/prettyLoader/ajax-loader.gif' /* Path to your loader gif */
                    //offset_top: 13, /* integer */
                    //offset_left: 10 /* integer */
                });
            });

        </script>
        <style>	
            ul.lof-main-wapper li {
                position:relative;	
            }
        </style>
    </head>
    <body>
        <div id="art-page-background-glare">
            <div><!-- id="art-page-background-glare-image" -->
                <div id="art-main">
                    <div class="art-sheet">
                        <div class="art-sheet-tl"></div>
                        <div class="art-sheet-tr"></div>
                        <div class="art-sheet-bl"></div>
                        <div class="art-sheet-br"></div>
                        <div class="art-sheet-tc"></div>
                        <div class="art-sheet-bc"></div>
                        <div class="art-sheet-cl"></div>
                        <div class="art-sheet-cr"></div>
                        <div class="art-sheet-cc"></div>
                        <div class="art-sheet-body">
                            
                            <?php 
                            error_reporting(0);
                            session_start();
                            require('../src/usuario/validarSesion.php');
                            $bandera = validar_sesion();
                            //echo $bandera;
                            //$bandera = 1;
                            require './menu/mostrar_menu.php';
                            $tipoUsu = $_SESSION['tipoUs'];
                            if($bandera == 0){
                                $tipoUsu = $_SESSION['tipoUs'];;
                            }
                            else{                                
                                $tipoUsu = 3;
                            }
                            
                            ?>
                            <div class="art-nav">
                                <div class="l"></div>
                                <div class="r"></div>
                                <ul class="art-menu">
                                    <?php 
                                        menuHorizontal($tipoUsu);                                    
                                    ?>
                                </ul>
                            </div>
                            <div class="art-header">
                                <div class="art-header-center">
                                    <div class="art-header-jpeg">
                                        <div id="tatuHu"><a onclick="javascript:cerrar();" href="#"><img src="./css/plantilla2/images/logo.png"></img></a></div>
                                        <div id="titulo"><a href="./index.php"><img src="./css/imagenes/tatuhu.png"></img></a></div>
                                        <!--<div id="facyt"><img src="./css/plantilla2/images/facyt.png"></img></div>
                                        <div id="uc"><img src="./css/plantilla2/images/uc.png"></img></div> -->
                                    </div>
                                </div>

                            </div>
                            <?php 
                            //}
                            ?>
                            <div class="art-content-layout">
                                <div class="art-content-layout-row">
                                    <div class="art-layout-cell art-content">
                                        <div class="art-post">
                                            <?php 
                                                if($tipoUsu != 3){
                                            ?> 
                                            <div align="right"><strong>
                                                    <?php 
                                                        if($_SESSION['tipoUs'] == 1){
                                                            echo "Usuario: ".$_SESSION['nombre'];
                                                        } 
                                                        else{
                                                            echo "Administrador: ".$_SESSION['nombre'];  
                                                        }
                                                    ?>
                                            </strong></div>
                                            <?php 
                                                }
                                                else{
                                                 ?>    
                                            <br>
                                                <?php 
                                                }
                                            ?>    
                                            <div class="art-post-body">
                                                <table height="380px" width="100%" border="0" align="center"> 
                                                    <tr>
                                                        <td>
                                                            <div align="center" id="contenido">                                                                
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <div class="texto-inicio">
                                                                                <h2 class="art-postheader"><p>BIENVENIDOS</p></h2>
                                                                                <br/>
                                                                                <br/>
                                                                                Sistema para la categorizacion de informaci&oacute;n en materia de desastres naturales, orientado a identificar
                                                                                las necesidades de capacitaci&oacute;n en relaci&oacute;n al reisgo de las comunidades
                                                                            </div>                                                                       
                                                                            <br></br>
                                                                            <table valing="top" width="100%" align="center" cellpadding="7" cellspacing="5">
                                                                                <tr>
                                                                                    <td width="70%" align="right">
                                                                                        <!--<img class="grafico" src="./css/imagenes/grafico.png" width="500px" height="200px"/>-->
                                                                                        <img src="./css/imagenes/grafico.png" width="500px" height="200px"/>
                                                                                    </td>
                                                                                    <td valign="bottom" width="30%" align="left">
                                                                                        <a href="#" onclick="tutorial();">
                                                                                            <img src="./css/plantilla2/images/logo.png" width="60px" height="60px"></img>
                                                                                            &#191;ayuda&#63;
                                                                                        </a>
                                                                                        <div id="dialog-tutorial" style="display:none" title="Tutorial del sistema">
                                                                                            <table align="center">
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <embed width="700" height="400" src="./css/videos/tutorial.mp4"></embed>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div> 
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                            <br></br>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="cleared"></div>
                                            </div>
                                        </div>
                                        <div class="cleared"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="cleared"></div>
                            <div class="art-footer">
                                <div class="art-footer-t"></div>
                                <div class="art-footer-l"></div>
                                <div class="art-footer-b"></div>
                                <div class="art-footer-r"></div>
                                <div class="art-footer-body">
                                    <div class="art-footer-text">                                        
                                        <p>Desarrollado por: Frank Malav&eacute;. Le&oacute;n, L., & Giugni M.</p>
                                    </div>
                                    <div class="cleared"></div>
                                </div>
                            </div>
                            <div class="cleared"></div>
                        </div>
                    </div>
                    <div class="cleared"></div>
                </div>
            </div>
        </div>
    </body>
</html>
