<script type="text/javascript">
    function menu(){
        
      $(".myMenu").buildMenu({
          template:"yourMenuVoiceTemplate",
          additionalData:"",
          menuSelector:".menuContainer",
          menuWidth:150,
          openOnRight:false,
          containment:"window",
          iconPath:"./menu/ico/",
          hasImages:true,
          fadeInTime:100,
          fadeOutTime:200,
          menuTop:0,
          menuLeft:0,
          submenuTop:0,
          submenuLeft:4,
          opacity:1,
          shadow:false,
          shadowColor:"black",
          shadowOpacity:.2,
          openOnClick:true,
          closeOnMouseOut:false,
          closeAfter:500,
          minZindex:"auto",
          hoverIntent:0, //if you use jquery.hoverIntent.js set this to time in milliseconds; 0= false;
          submenuHoverIntent:0 //if you use jquery.hoverIntent.js set this to time in milliseconds; 0= false;
      });
        
    }
</script>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#EDEDED">
    <tr>
        <td width="180" height="33" style="padding:10px" class="style"></td>
        <td valign="bottom">
            <table  border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="container">
                <tr>
                    <td class="myMenu">
                        <!-- start horizontal menu -->
                        <table class="rootVoices" cellspacing='0' cellpadding='0' border='0'><tr>
                        <td class="rootVoice {menu: 'menu_1'}" >Gestion Archivos</td>
                        <td class="rootVoice {menu: 'menu_2'}" >Agrupar</td>
                        </tr></table>
                        <!-- end horizontal menu -->
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div id="menu_1" class="mbmenu">                                                
<a rel="title" class="{action: 'showMessage(\'menu_2.1\')', img: 'icon_13.png'}"> Elige una opción </a>
<a href="javascript:ir_pag('./carga/carga.php')" class="{action: 'showMessage(\'Sub Menú 1\')'}">Subir</a>
<a class="{action: 'showMessage(\'Sub Menú 1\')'}">Eliminar</a>
<!--<a class="{action: 'showMessage(\'Sub Menú 2\')'}">Sub Menú 2</a>
<a rel="separator"> </a>
<a class="{action: 'showMessage(\'Sub Menú 3\')'}">Sub Menú 3</a>-->
</div>
<div id="menu_2" class="mbmenu">
<a href="javascript:ir_pag('./agrupar/agrupar.php')" class="{action: 'showMessage(\'Sub Menú 1\')'}">Agrupar</a>
<!--<a class="{action: 'showMessage(\'Sub Menú 2\')'}">Sub Menú 2</a>
<a rel="separator"> </a>
<a class="{action: 'showMessage(\'Sub Menú 3\')'}">Sub Menú 3</a>-->
</div>

