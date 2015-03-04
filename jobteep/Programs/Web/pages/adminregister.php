<?php 
/* Patern (?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$
 * Una mayuscula, una minúscula, un número o símbolo y un mínimo de 8 caracteres
 * */
?>
<form data-abide method = "post" action = "?menu=adminregister&action=adminregister">
  <?php 
	if (SO::$ALERT) {
		echo '<div data-alert class="alert-box info radius">
			'.SO::$MESSAGE.'
		  <a href="#" class="close">&times;</a>
		</div>';
	}
	?>
  <div class="email-field">
    <label>Usuario <small>requerido</small>
      <input type="text" name = "user" id = "user" required>
    </label>
  </div>
  <div class="password-field">
    <label>Contraseña <small>requerida</small>
      <input type="password" name = "pass" id="pass" required>
    </label>
  </div>
  <div class="password-confirmation-field">
    <label>Confirmar Contraseña <small>requerida</small>
      <input type="password" name = "pass2" id = "pass2" required data-equalto="pass">
    </label>
    <small class="error">Las contraseñas no coinciden.</small>
  </div>
  <div class = "text-center"><button type="submit">Enviar</button></div>
</form>