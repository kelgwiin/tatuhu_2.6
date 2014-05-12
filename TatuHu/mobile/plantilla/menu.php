 <ul data-role="listview" data-divider-theme="b" data-inset="true" class="menu ui-corner-all">
    <li data-theme="c" class="proyecto">
        <a href="proyecto.php" data-transition="slide">
            El Proyecto
        </a>
    </li>
    <li data-theme="c" class="riesgos">
        <a href="riesgos.php" data-transition="slide">
            Riesgos Naturales
        </a>
    </li>
    <li data-theme="c" class="desarrollos">
        <a href="desarrollos.php" data-transition="slide">
            Desarrollos
        </a>
    </li>
    <li data-theme="c" class="login" >
        <a href="#Login" data-transition="pop" data-rel="popup" >
            Login
        </a>
    </li>
</ul>
<div id="redireccion"></div>
<div data-role="popup" id="Login" data-theme="b" style="max-width:300px;">
	<form id="myform">
	    <div style="padding:10px 20px;">
			  <h3>Acceso al Aula Tatu H&uacute;</h3>
			  <div id="message" style="heigth:20px;max-width:220px;"></div>
		          <input type="text" name="login" id="user" value="" placeholder="usuario" data-theme="a">
				  <span class="error user">Este campo es obligatorio</span>
		          <input type="password" name="pass" id="pass" value="" placeholder="contrase&ntilde;a" data-theme="a">
				  <span class="error pass">Este campo es obligatorio</span>
		    	  <div data-theme="b" ><button type="submit" data-theme="b" class="ui-btn-hidden" aria-disabled="false">Entrar</button></div>
		</div>
	</form>
</div>

