$(".Timbre").keypress(function(e){

  var Timbre = document.getElementById("txtTimbre_Guia").value;
  var _token = $('input[name="_token"]').val();
  if ($("#txtTimbre_Guia").val().length==13){
    $.ajax({
      url:'/Organizar/Recept',
      type: 'POST',
      data:{_token:_token,Timbre:Timbre},
      success: function(data){
       if($.isEmptyObject(data.error)){
         swal(data.Leyenda,data.Mensaje,"success");
         document.getElementById("ajaxResp").innerHTML = data.Estructura;
         document.getElementById("txtTimbre_Guia").value='';

       }
      },
      error:function (data){
         swal("no works","ha ocurrido un error","error");
      }
    });
  }
});
