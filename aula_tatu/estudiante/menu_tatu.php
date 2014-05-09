<ul class="big-menu">
	<li class="with-right-arrow">
          <?php $areas = $_SESSION["interfaz"]["areas"]; ?>
                <span><span class="list-count"><?php echo count($areas); ?></span>&Aacute;reas de Aprendizaje</span>
		<ul class="big-menu">
                    <?php
                        foreach($areas as $indice=>$elemento){
                    ?>
			<li><a href="<?php echo "componentes.php?id_area=".$elemento["id_area"]."&pos=".$indice;?>">
                            <?php echo $elemento["nombre_area"];?></a> </li>
                    <?php 
                        }
                    ?>
		</ul>
	</li>
        <li>
		<a href="recompensas.php?all">Mis Recompensas</a>
	</li>
</ul>