function Rpt_Tirilla(Key){
  var url = 'http://sapyt.com.mx';
  var form = $('<form action="' + url + '" method="post" target="_blank">' +
  '<input type="hidden" name="api_url" value="' + Key + '" />' +
  '</form>');
  $('body').append(form);
  form.submit();
}

/*=====================================================================*/

$(".Revocar").click(function(e){
e.preventDefault();
swal({
  title: "¿Desea REVOCAR los elementos seleccionados?",
  text: 'Si se encuentra seguro haga click en "Continuar", de lo contrario haga click en  "cancelar"!',
  type: "question",
  showCancelButton: true,
  confirmButtonText: "Continuar!",
  cancelButtonText: "No, cancelar!",
}).then(function(isConfirm){
  if (isConfirm) {


     var _token =  $("input[name='_token']").val();
     var Timbres = '';

$('input[type=checkbox]:checked').each(function() {
Timbres += $(this).val() + '|';
});

     fin = Timbres.length - 1;
     Timbres = Timbres.substr( 0, fin );
     Timbres=Timbres.replace('|on|on|on','');
     //alert(Timbres);

       $.ajax({
           url: "/Timbres/Revocar",
           type:'POST',
           data: {_token:_token, Timbres:Timbres },
           success: function(data) {
               if($.isEmptyObject(data.error)){
                 swal(data.success,data.Mensaje,'success');
                   //Rpt_Tirilla(data.Tirilla);
               }else{
                 printErrorMsg(data.error);
               }
           }
       });


  }
});
});

/*=====================================================================*/

$(".Transferir").click(function(e){
e.preventDefault();
swal({
title: "¿Desea TRANSFERIR los elementos seleccionados?",
text: 'Si se encuentra seguro haga click en "Continuar", de lo contrario haga click en  "cancelar"!',
type: "question",
showCancelButton: true,
confirmButtonText: "Continuar!",
cancelButtonText: "No, cancelar!",
}).then(function(isConfirm){
if (isConfirm) {


   var _token =  $("input[name='_token']").val();
   var Timbres = '';
   var NChofer = document.getElementById("CmbNChofer").value;

$('input[type=checkbox]:checked').each(function() {
Timbres += $(this).val() + '|';
});

   fin = Timbres.length - 1;
   Timbres = Timbres.substr( 0, fin );
   Timbres=Timbres.replace('|on|on|on','');

     $.ajax({
         url: "/Timbres/Transferir",
         type:'POST',
         data: {_token:_token, Timbres:Timbres,NChofer:NChofer },
         success: function(data) {
             if($.isEmptyObject(data.error)){
               swal(data.success,data.Mensaje,'success');
             }else{
               swal(data.error,data.error,'error');
               //printErrorMsg(data.error);
             }
         }
     });


}
});

});

/*=====================================================================*/

function mostrarTirillas ( d ) {
// `d` is the original data object for the row
if (d.length==0){
  return 'No se encontraron Resultados';
}

var Filas='';
for(x=0;x<d.length;x++){
  Filas+='<tr>';
  Filas+='<td>'+d[x].FECHA_ALTA+'</td>';
  Filas+='<td>'+d[x].DISPONIBLES+'</td>';
  Filas+='<td>'+d[x].CONTENIDO+'</td>';
  Filas+='<td><button type="button" onclick="ContenidoTirilla('+d[x].TIRILLA_ID+');" class="btn btn-primary btn-xs">Administrar</button></td>';
  Filas+='</tr>';
}

return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" class="table no-margin">'+
    '<tr>'+
      '<td width="200">Fecha</td>'+
      '<td width="200">Timbres disponibles</td>'+
      '<td width="200">Contenido inicial</td>'+
      '<td></td>'+
    '</tr>'+
    Filas+
'</table>';
}

/*=====================================================================*/

function ContenidoTirilla(id){
  var _token =  $("input[name='_token']").val();
  var form = $('<form action="Contenido" method="post">' +
  '<input type="hidden" name="_token" value="'+_token+'" />' +
  '<input type="hidden" name="key" value="'+id+'" />' +
  '</form>');
  $('body').append(form);
  form.submit();
}

/*===================================================================*/

function Reactivar(Id){
  swal({
    title: "¿Desea reactivar el timbre?",
    text: 'Si se encuentra seguro haga click en "Continuar", de lo contrario haga click en  "cancelar"!',
    type: "question",
    showCancelButton: true,
    confirmButtonText: "Continuar!",
    cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
    if (isConfirm) {

       var _token =  $("input[name='_token']").val();

         $.ajax({
             url: "/Timbres/Reactivar",
             type:'POST',
             data: {_token:_token, Id:Id},
             success: function(data) {
                 if($.isEmptyObject(data.error)){
                   swal(data.Titulo,data.Mensaje,'success');
                   $("#Revocado"+id).removeClass('btn-danger').addClass("btn-success");
                 }else{
                   printErrorMsg(data.error);
                 }
             }
         });


    }
  });

}
