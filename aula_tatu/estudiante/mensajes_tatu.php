<?php if (isset($_SESSION['datos_educativos'])){ ?>
<li class="title-menu " style="background:none">Mi Escuela y Grado</li>
<li>
        <ul class="calendar-menu">
                <li style="text-align:center;">
                                <strong><?php echo $_SESSION['datos_educativos']['nombre_colegio'];?></strong><br>
								<?php echo $_SESSION['datos_educativos']['grado'].'- "'.$_SESSION['datos_educativos']['seccion'].'"';?>
								
                </li>
        </ul>
</li>
<?php }  if (isset($_SESSION["interfaz"]["mensaje"])){?>
<li class="title-menu " style="background:none">Mensajes de Tatu H&uacute;</li>
<li>
        <ul class="calendar-menu">
                <li>
                                <time><b><?php echo date('d'); ?></b> <?php echo $meses[(date('m')+0)]; ?></time>
                                "<?php echo $_SESSION["interfaz"]["mensaje"]; ?>"
                </li>
        </ul>
</li>

<?php } ?>