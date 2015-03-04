/**
 * Validar formato de la fecha
 */
function validarFormatoFecha(campo) {
      var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
      if ((campo.match(RegExPattern)) && (campo!='')) {
            return true;
      } else {
            return false;
      }
}

/**
 * Valorar si la fecha existe
 */
function existeFecha(fecha){
    var fechaf = fecha.split("/");
    var day = fechaf[0];
    var month = fechaf[1];
    var year = fechaf[2];
    var date = new Date(year,month,'0');
    if((day-0)>(date.getDate()-0)){
          return false;
    }
    return true;
}

/**
 * Validación de fecha
 */
function val_fecha (fecha) {
	if(validarFormatoFecha(fecha)) {
	      if(existeFecha(fecha))
	            return true;
	      else
	            return false;
	} else
	      return false;
}

/**
* Validar formulario de intro
*/
function validation () {
	var val = true;
	var fecha = document.getElementById("birthday").value;
	if (!val_fecha(fecha))
		val = false;
	
	if(!val)
		document.getElementById("birthday_error").html("La fecha introducida no es correcta.");
	
	return val;
}