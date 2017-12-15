$(".Rechazo").keypress(function(e){


  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 13) ){
    var Timbre = document.getElementById("txtTimbre_Guia").value;
    var _token = $('input[name="_token"]').val();

      $.ajax({
        url:'/Recepcion/Rechazar',
        type: 'POST',
        data:{_token:_token,Timbre:Timbre},
        success: function(data){

           swal(data.Titulo,data.Mensaje,data.Tipo);

           if($.isEmptyObject(data.Dato)){
             document.getElementById("txtTimbre_Guia").value='';
           }else{
             document.getElementById("txtTimbre_Guia").value='';
             document.getElementById("ajaxResp").innerHTML = data.Dato;
           }
        },
        error:function (data){
           swal("no works","ha ocurrido un error","error");
        }
      });
return false;
}else{
  return true;
}

  return /\d/.test(String.fromCharCode(keynum));
});

/*=======================================================*/

$(".Guia").keypress(function(e){


  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 13) ){
    var Timbre = document.getElementById("txtTimbre_Guia").value;
    var _token = $('input[name="_token"]').val();

      $.ajax({
        url:'/Recepcion/Aceptar',
        type: 'POST',
        data:{_token:_token,Timbre:Timbre},
        success: function(data){

           swal(data.Titulo,data.Mensaje,data.Tipo);

           if($.isEmptyObject(data.Dato)){
             document.getElementById("txtTimbre_Guia").value='';
           }else{
             document.getElementById("txtTimbre_Guia").value='';
             document.getElementById("ajaxResp").innerHTML = data.Dato;
           }
        },
        error:function (data){
           swal("no works","ha ocurrido un error","error");
        }
      });
return false;
}else{
  return true;
}

  return /\d/.test(String.fromCharCode(keynum));
});

/*---------------------------------------------*/

function EliminarPqt(e,Dato){
  e.preventDefault();
  var _token = $('input[name="_token"]').val();// $('input[name="_token"]').val()

  $.ajax({
    url:'/Recepcion/Eliminar',
    type:'POST',
    data:{_token:_token, Dato:Dato},
    success:function(data){
      document.getElementById("txtTimbre_Guia").value='';
      document.getElementById("ajaxResp").innerHTML = data.Dato;
    },
    error:function(data){
      swal("Ha ocurrido un error!","No hemos podido procesar tu solicitud, debido a un error interno del sistema","error");
    }
  });
};

/*============================================*/

function EliminarRechazo(e,Dato){
  e.preventDefault();
  var _token = $('input[name="_token"]').val();// $('input[name="_token"]').val()

  $.ajax({
    url:'/Recepcion/EliminarRechazo',
    type:'POST',
    data:{_token:_token, Dato:Dato},
    success:function(data){
      document.getElementById("txtTimbre_Guia").value='';
      document.getElementById("ajaxResp").innerHTML = data.Dato;
    },
    error:function(data){
      swal("Ha ocurrido un error!","No hemos podido procesar tu solicitud, debido a un error interno del sistema","error");
    }
  });
};

/*---------------------------------------------*/

function ConfirmarRecepcion(){
  //alert("Si works");
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Recepcion/ConfirmarRecepcion',
    type: 'POST',
    data:{_token:_token},
    success:function(data){
      document.getElementById("ajaxResp").innerHTML = '';
      swal(data.Titulo,data.Mensaje,"success");
    },
    error:function(data){
      swal('Error desconocido','Ha ocurrido un error durante el proceso, por lo que no se pudo aplicar la tarea solicitada, le sugerimos contactar con el administrador del sistema',"error");
    }
  });

}

function ConfirmarRechazo(){
  //alert("Si works");
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url:'/Recepcion/ConfirmarRechazo',
    type: 'POST',
    data:{_token:_token},
    success:function(data){
      document.getElementById("ajaxResp").innerHTML = '';
      swal(data.Titulo,data.Mensaje,"success");
    },
    error:function(data){
      swal('Error desconocido','Ha ocurrido un error durante el proceso, por lo que no se pudo aplicar la tarea solicitada, le sugerimos contactar con el administrador del sistema',"error");
    }
  });

}


/*
e.preventDefault();


Que tiene tu espíritu que cuando me toca
me hace temblar
que es Tu presencia que al manifestarse
tengo que cantar
es que soy tan pequeño que al Tu tocarme siento
que voy a desmayar
es que Tu presencia no hay aquí en la tierra
con que comparar

Coro
no Te puedo mirar ni Te puedo tocar
no ha llegado el momento
y a veces en mi afán creo que ya Tu no estas
pero vuelvo y Te siento
y cuando me tocas con Tu Santo Espíritu
lloro, canto, y tiemblo

II
Que hay en Tu interior que sientes por mi
no se como me amas
que misterio existe que a mi dura prueba
conviertes en calma
yo se que a Tu presencia toda la tierra tiembla
y también tiembla mi alma
pero que tiene Tu Espíritu que cuando me toca
me da la bonanza.



*Señor gracias, porque eres un Dios real,
eres un Dios verdadero; y nada se compara
con Tu amor mi Dios.*

y cuando me tocas con Tu Santo Espiritu,
lloro, canto y tiemblo..
*/
