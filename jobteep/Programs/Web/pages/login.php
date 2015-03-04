<?php 
/* Patern (?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
 * Una mayuscula, una minúscula, un número o símbolo y un mínimo de 8 caracteres
 * */
?>
<form data-abide class="peThemeContactForm" method = "post" action = "?menu=login&action=login">
  <div id="personal" class="bay form-horizontal">
  <?php 
		if (SO::$ALERT) {
			echo '<div data-alert class="alert-box info radius">
				'.SO::$MESSAGE.'
			  <a href="#" class="close">&times;</a>
			</div>';
		}
	?>
	  <div class="email-field control-group">
	  	<div class = "control">
			<input class="span9" type="email" name="user" id = "user" placeholder = "Tu email" required>
	    <small class="error">El email introducido no es correcto.</small>
	  	</div>
	  </div>
	  <div class="password-field control-group">
	  	<div class = "control">
	  		<input class="span9" type="password" name="pass" placeholder = "Tu contraseña" id="pass" required pattern=".{6,}">
		    <small class="error">La contraseña debe tener un mínimo de 6 caracteres.</small>
		</div>
	  </div>
	  <div class="control-group">
		<div class="controls send-btn">
			<button type="submit" class="contour-btn red">Entrar</button>
		</div>
	  </div>
	</div>
</form>
<button onclick="location.href = '?menu=register'" class="contour-btn red">Registrarme</button><br>
<small>¿Olvidaste la contraseña? <a href = "?menu=passRecover">Cámbiala</a></small><br>
<small>Equipo de soporte <a href = "mailto:help@jobteep.com">help@jobteep.com</a></small>