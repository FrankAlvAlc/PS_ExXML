/*
******************
Archivo para validar que los campos de los formularios no esten vacios
******************
*/
function Longitud(txt,Tam){
      txt="#"+txt;
			if ($(txt).val().length>=Tam){
				return false;
				}else{
					return true;
					}
  }


  function soloLetras(e,txt,Tam) {
      var Respuesta;
  		Respuesta =Longitud(txt,Tam);
      if(Respuesta==true){
      key = e.keyCode || e.which;
      tecla = String.fromCharCode(key).toString();
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";//Se define todo el abecedario que se quiere que se muestre.
      especiales = [8,  6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

      tecla_especial = false
      for(var i in especiales) {
          if(key == especiales[i]) {
              tecla_especial = true;
              break;
          }
      }

      if(letras.indexOf(tecla) == -1 && !tecla_especial){
//  alert('Tecla no aceptada');
          return false;
        }
      }
      return Respuesta;
  }
