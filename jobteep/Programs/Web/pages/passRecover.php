<form data-abide class="peThemeContactForm" method = "post" action = "?menu=login&action=passRecover">
  <?php 
	if (SO::$ALERT) {
		echo '<div data-alert class="alert-box info radius">
			'.SO::$MESSAGE.'
		  <a href="#" class="close">&times;</a>
		</div>';
	}
  ?>
  <div id="personal" class="bay form-horizontal">
  	  <div class="email-field control-group">
	  	<div class = "control">
			<input class="span9" type="email" name="user" id = "user" value="Usuario" onclick="if(this.value=='Usuario') this.value=''" onblur="if(this.value=='') this.value='Usuario'" required>
	    <small class="error">El email introducido no es correcto.</small>
	  	</div>
	  </div>
	  <div class="control-group">
		<div class="controls send-btn">
			<button type="submit" class="contour-btn red">Recuperar</button>
		</div>
	  </div>
  </div>
</form>
<small>Ya me acuerdo, <a href = "?menu=login">entrar.</a></small><br>
<small>Equipo de soporte <a href = "mailto:help@jobteep.com">help@jobteep.com</a></small>