
/*-----------------------------------*/

$(".TimbrarEnvio").click(function(e){
  e.preventDefault();

  //Fila.fadeOut();
 var Dato = $(this).data('envio');
 var _token =  $("input[name='_token']").val();
 var Timbre = document.getElementById("txtTimbre").value;
 //alert(Dato);
 $.ajax({
   url:"/Timbrar/Envio",
   type:"POST",
   data:{_token:_token, Dato:Dato , txtTimbre:Timbre},
   success: function(data){
     if ($.isEmptyObject(data.error)){
       swal(data.Leyenda,data.Mensaje,"success");
       $("#tr"+Dato).fadeOut();
     }else{
       swal(data.Leyenda,data.Mensaje,"error");
     }
   },
   error:function (data){
        swal("Ocurrio un error!",data.Message,"error");
   }
 });
});

/*-----------------------------------*/

$(".IngresarTimbre").click(function(){
  var Dato = $(this).data('envio');
  $("#TimbrarEnvio").data( 'envio', Dato );
});

/*-----------------------------------*/

$(".AsignaReparto").click(function(e){
  e.preventDefault();

 var _token =  $("input[name='_token']").val();

  $.ajax({
   url:"/Monitor/Reparto",
   type:"POST",
   data:{_token:_token},
   success: function(data){
    document.getElementById('Contenido-Combo').innerHTML=data.Datos;
   },
   error:function (data){
        swal("Ocurrio un error!",data.Message,"error");
   }
 });
});

/*--------------------------------------------*/

$(".ConfirmarReparto").click(function(e){
  e.preventDefault();
  var Timbres='';
  $('input[type=checkbox]:checked').each(function() {
  Timbres += $(this).val() + '|';
  });

       fin = Timbres.length - 1;
       Timbres = Timbres.substr( 0, fin );
       Timbres=Timbres.replace('|on|on|on','');

       var Responsable = document.getElementById('CmbRepatidor').value;

      // alert(Responsable);

  var _token = $("input[name='_token']").val();
  $.ajax({
    url : "/Monitor/ConfirmaReparto",
    type: "POST",
    data: {_token:_token, Timbres:Timbres, Responsable:Responsable},
    success:function(data){
      swal(data.Titulo,data.Mensaje,"success");
      $('input[type=checkbox]:checked').each(function() {
      Id = $(this).val();
      $("#tr"+Id).fadeOut();
      });

    },
    error:function(data){
       swal("Error 500","Error interno del servidor","error");
    }
  });
});

/*===================================================*/

 function ReprogramarDestino(){
  var _token =  $("input[name='_token']").val();

   $.ajax({
    url:"/Monitor/CatDepartamento",
    type:"POST",
    data:{_token:_token},
    success: function(data){
     document.getElementById('Combo-Departamentos').innerHTML=data.Datos;
    },
    error:function (data){
         swal("Ocurrio un error!",data.Message,"error");
    }
  });
 }

 /*===================================================*/

 function CambiarDestino(){
   var _token =  $("input[name='_token']").val();
   var Depto = document.getElementById('CmbDepartamento').value;
   var Timbres='';
   $('input[type=checkbox]:checked').each(function() {
   Timbres += $(this).val() + '|';
   });

   fin = Timbres.length - 1;
   Timbres = Timbres.substr( 0, fin );
   Timbres=Timbres.replace('|on|on|on','');

    $.ajax({
     url:"/Monitor/CambiarDestino",
     type:"POST",
     data:{_token:_token,Depto:Depto, Timbres:Timbres},
     success: function(data){
       swal('Destino cambiado',data.Mensaje,'success');
      //document.getElementById('Combo-Departamentos').innerHTML=data.Datos;
     },
     error:function (data){
          swal("Ocurrio un error!",data.Message,"error");
     }
   });
 }

 /*================================================*/

 
