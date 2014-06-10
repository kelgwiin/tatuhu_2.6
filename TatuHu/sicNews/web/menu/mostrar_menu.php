<script type="text/javascript">
    
</script>
<?php 

    function menuHorizontal($tipoUsu){
        switch ($tipoUsu) {
            //Investigador
            case 1:
                ?>
                    <!--class="active"-->
                <li><a href="index.php"><span class="l2"> </span><span class="r2"> </span><span class="t">Inicio</span></a></li>
                <li><a href="javascript:ir_pag('./busqueda/busqueda.php')"><span class="l2"> </span><span class="r2"> </span><span class="t">Realizar B&uacute;squeda</span></a></li>
                <li><a href="javascript:ir_pag('./carga/carga.php')"><span class="l2"> </span><span class="r2"> </span><span class="t">Gestion de Archivos</span></a></li>
                <li><a href="javascript:ir_pag('./agrupar/agrupar.php')"><span class="l2"> </span><span class="r2"> </span><span class="t">Agrupar</span></a></li>
                <li><a href="javascript:ir_pag('../src/usuario/validarSesion.php?logout=yes')"><span class="l2"> </span><span class="r2"> </span><span class="t">Cerrar Sesi&oacute;n</span></a></li>
                <?php
            break;
            //Administrador
            case 2:
                ?>
                <!--class="active"-->
                <li><a href="index.php"><span class="l2"> </span><span class="r2"> </span><span class="t">Inicio</span></a></li>
                <li><a href="javascript:ir_pag('./parametro/parametro.php')"><span class="l2"> </span><span class="r2"> </span><span class="t">Parametros del Sistema</span></a></li>
                <li><a href="javascript:ir_pag('./usuario/administrar.php')"><span class="l2"> </span><span class="r2"> </span><span class="t">Administrar usuarios</span></a></li>
                <li><a href="javascript:ir_pag('../src/usuario/validarSesion.php?logout=yes')"><span class="l2"> </span><span class="r2"> </span><span class="t">Cerrar Sesi&oacute;n</span></a></li>
                <?php 
            break;  
            //Visitante
            case 3:
                ?>
                <!--class="active"-->
                <li><a href="index.php"><span class="l2"> </span><span class="r2"> </span><span class="t">Inicio</span></a></li>
                <li><a href="javascript:ir_pag('./busqueda/busqueda.php')"><span class="l2"> </span><span class="r2"> </span><span class="t">Realizar B&uacute;squeda</span></a></li>
                <li><a href="javascript:ir_pag('./inicio_sesion/iniciar_sesion.php')"><span class="l2"> </span><span class="r2"> </span><span class="t">Iniciar Sesi&oacute;n</span></a></li>
                <?php 
            break;      
       }    
        
    }
    
    function menuVertical($tipoUsu){
        switch ($tipoUsu) {
            //Usuario Comun
            case 1:
                ?>
                <li><a href="javascript:ir_pag('./busqueda/busqueda.php')"><span class="l"> </span><span class="r"> </span><span class="t">Realizar B&uacute;squeda</span></a></li>
                <li><a href="../src/usuario/validarSesion.php?logout=yes"><span class="l"> </span><span class="r"> </span><span class="t">Cerrar Sesion</span></a></li>
                <?php
            break;
            //Administrador
            case 2:
                ?>
                <li><a href="javascript:ir_pag('./busqueda/busqueda.php')"><span class="l"> </span><span class="r"> </span><span class="t">Realizar B&uacute;squeda</span></a></li>
                <li><a href="javascript:ir_pag('./carga/carga.php')"><span class="l"> </span><span class="r"> </span><span class="t">Gestión de Archivos</span></a></li>
                <li><a href="javascript:ir_pag('./agrupar/agrupar.php')"><span class="l"> </span><span class="r"> </span><span class="t">Agrupar</span></a></li>
                <li><a href="javascript:ir_pag('./parametro/parametro.php')"><span class="l"> </span><span class="r"> </span><span class="t">Parametros del Sistema</span></a></li>
                <li><a href="../src/usuario/validarSesion.php?logout=yes"><span class="l"> </span><span class="r"> </span><span class="t">Cerrar Sesion</span></a></li>
                <?php 
            break;          
       }    
        
    }
?>