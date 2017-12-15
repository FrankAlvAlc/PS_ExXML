$(".Crear").click(function(e){
e.preventDefault();
swal({
  title: "¿Son correctos los datos del ASUNTO?",
  text: 'Si se encuentra seguro haga click en "Continuar", de lo contrario haga click en  "cancelar"!',
  type: "question",
  showCancelButton: true,
  confirmButtonText: "Continuar!",
  cancelButtonText: "No, cancelar!",
}).then(function(isConfirm){
  if (isConfirm) {

     var _token =  $("input[name='_token']").val();
     var CmbDepartamentos = document.getElementById("CmbDepartamentos").value;
     var txtAsunto = document.getElementById("txtAsunto").value;
     var txtDescripcion = document.getElementById("txtDescripcion").value;

       $.ajax({
           url: "/Asuntos/Crear",
           type:'POST',
           data: {_token:_token, CmbDepartamentos:CmbDepartamentos, txtAsunto:txtAsunto, txtDescripcion:txtDescripcion},
           success: function(data) {
               if($.isEmptyObject(data.error)){
                 swal(data.success,data.Mensaje,'success');
                 document.getElementById("CmbDepartamentos").value='';
                 document.getElementById("txtAsunto").value='';
                 document.getElementById("txtDescripcion").value='';
               }else{
                 printErrorMsg(data.error);
               }
           }
       });


  }
});
});
