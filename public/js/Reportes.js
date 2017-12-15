function verReporte(id){
  switch(id){
    case 2:
      var Inicio = document.getElementById('txtInicio').value;
      var Final = document.getElementById('txtFinal').value;

      if(Inicio.length==0){
        swal("Selecciona la fecha inicial","Para visualizar el reporte es necesario seleccionar la fecha de inicio","warning");
        return false;
      }

      if(Final.length==0){
        swal("Selecciona la fecha final","Para visualizar el reporte es necesario seleccionar la fecha final","warning");
        return false;
      }

      var url = '/ReportesViewer';
      var _token = $('input[name="_token"]').val();
      var form = $('<form action="' + url + '" method="post" target="_blank">' +
      '<input type="hidden" name="CU" value="' + id + '" />' +
      '<input type="hidden" name="Inicio" value="' + Inicio + '" />' +
      '<input type="hidden" name="Final" value="' + Final + '" />' +
      '<input type="hidden" name="_token" value="' + _token + '" />' +
      '</form>');
      $('body').append(form);
      form.submit();
    break;
  }
}


function rpt_AcuseK(e,Dato){
  var keynum = window.event ? window.event.keyCode : e.which;
  
  if ((keynum == 13) ){

    rpt_Acuse(Dato);
    return false;
}else{
  return true;
}

  return /\d/.test(String.fromCharCode(keynum));
};

function rpt_Acuse(Dato){
  var Guia = document.getElementById("txtGuiaFrm").value;
  var _token = $('input[name="_token"]').val();
  var url = '/ReportesViewer';

  var form =
  $('<form action="' + url + '" method="post" target="_blank">' +
      '<input type="hidden" name="CU" value="' + Dato + '" />' +
      '<input type="hidden" name="_token" value="' + _token + '" />' +
      '<input type="hidden" name="Guia" value="' + Guia + '" />' +
  '</form>');

  $('body').append(form);
  form.submit();
}
