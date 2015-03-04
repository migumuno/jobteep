/**
 * Valida formularios
 */
function validation () {
	var disponible = document.getElementById("user_error").value;
	if (disponible == 'No Disponible')
		return false;
	else
		return true;
}