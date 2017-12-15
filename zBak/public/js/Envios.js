$(".Asunto").change(function(e){
e.preventDefault();
var _token =  $("input[name='_token']").val();
var CmbAsunto = document.getElementById("CmbAsunto").value;
var combo = document.getElementById("CmbAsunto");
var selected = combo.options[combo.selectedIndex].text;
var Atencion = document.getElementById("txtAtencion").value;

  $.ajax({
      url: "/Envios/Dato/Asunto",
      type:'POST',
      data: {_token:_token, CmbAsunto:CmbAsunto,Atencion:Atencion},
      success: function(data) {
          if($.isEmptyObject(data.error)){
            var Info = '<address>'+
                     '<strong class="text-dark">'+data.Info[0].Clave+' - '+data.Info[0].Nombre+'.</strong><br>'+
                     '<small>'+data.Info[0].DESCRIPCION+'</small>'+

                     '</address>';

            var info_Fin = '<address>'+
                           '<strong class="text-dark">'+data.Info[0].Clave+' - '+data.Info[0].Nombre+'.</strong><br>'+
                           '<small>'+selected+
                           '</small><div id="Atencion_To">PARA: '+data.Atencion_To+'</div></address>';

            document.getElementById("Info_Asunto").innerHTML=Info;
            document.getElementById("InfoRecept").innerHTML=info_Fin;
            document.getElementById("txtDestino").value=data.Info[0].Departamento_ID;
          }else{
            printErrorMsg(data.error);
          }
      }
  });
});

/*====================================*/

$("#Identificar").click(function(e){
 e.preventDefault();

 if($("#txtUName").val().length==0 || $("#txtPwd").val().length==0){
   return swal("Ingrese Usuario y/o Password","No es posible identificarle con datos de sesion incompletos, proporcione los datos solicitados e intentelo nuevamente","warning");
 }

  var _token = $("input[name='_token']").val();
  var Usuario = document.getElementById("txtUName").value;
  var Pwd = document.getElementById("txtPwd").value;

  $.ajax({
    url : "/Envios/Identificar",
    type: "POST",
    data:{_token:_token, Usuario:Usuario, Pwd:Pwd},
    success: function(data){
      if ($.isEmptyObject(data.error)){
        var misDatos=data.Datos;
        //misDatos =data.Datos;
        document.getElementById("txtUsuarioID").value = misDatos[0].USUARIO_ID;//txtUsuarioID
        document.getElementById("txtColaborador").value = misDatos[0].NOMBRE;//txtUsuarioID
        document.getElementById("txtPwd").value='';
        var Info = '<address>'+
                   '<strong class="text-dark">'+data.Departamento+'</strong>'+
                   '<br>'+misDatos[0].NOMBRE+'<br>'+
                   '<abbr title="Date">Fecha:</abbr>'+data.Fecha+' '+
                   '<abbr title="Date"> Hora:</abbr>'+data.Hora+'</address>'
        document.getElementById("InfoEmisor").innerHTML=Info;
        swal("",data.Mensaje,"success");
      }else{
        swal("Falló al identificar!",data.Mensaje,"warning");
        document.getElementById("txtColaborador").value = '';
        document.getElementById("txtUsuarioID").value = 0;
      }
    }
  });

});

function TagPara(valor){
  document.getElementById("Atencion_To").innerHTML='PARA: '+valor;
}

/*====================================*/

$(".GenerarEnvio").click(function (e){
 e.preventDefault();

  /*                                                        /
                  * Area de validaciones*
  /                                                       */

 if($("#txtDestino").val()==0){
   swal("Seleccione destino","Aun no has seleccionado el destino, para ello debes seleccionar un asunto valido","warning");
   return false;
 }

 if($("#CmbAsunto").val()=="x1"){
   swal("Seleccione Asunto","Aun no has seleccionado un asunto valido, por favor proporciona esta informacion e intentalo nuevamente","warning");
   return false;
 }

 if($("#txtUsuarioID").val()==0){
   swal("Firme el envio","Para realizar el envio debe firmar la transaccion (Indentifique su persona en el sistema)","warning");
   return false;
 }

/* if($("#").val().length==0){
   return false;
 }*/
 var _token =  $("input[name='_token']").val();
 var txtTimbre = document.getElementById("txtTimbre").value;
 var txtDestino = document.getElementById("txtDestino").value;
 var CmbAsunto = document.getElementById("CmbAsunto").value;
 var txtUsuarioID = document.getElementById("txtUsuarioID").value;
 var txtAtencion = document.getElementById("txtAtencion").value;
 var txtContenido = document.getElementById("txtContenido").value;
 var RbTipo = $('input:radio[name=RbTipo]:checked').val();

 $.ajax({
   url: "/Envios/Generar",
   type: "POST",
   data: {_token:_token,
          txtTimbre: txtTimbre,
          txtDestino: txtDestino,
          CmbAsunto: CmbAsunto,
          txtUsuarioID: txtUsuarioID,
          txtAtencion: txtAtencion,
          txtContenido: txtContenido,
          RbTipo: RbTipo},
   success: function(data){
     if ($.isEmptyObject(data.error)){
       swal(data.Leyenda, data.Mensaje, "success");
       document.getElementById("txtTimbre").value='';
       document.getElementById("txtDestino").value='';
       document.getElementById("txtUsuarioID").value=0;
       document.getElementById("txtAtencion").value='';
       document.getElementById("txtContenido").value='';
       document.getElementById("txtColaborador").value = '';
       document.getElementById("Info_Asunto").innerHTML="";
       document.getElementById("InfoRecept").innerHTML="";
     }else{
       swal(data.Leyenda, data.Mensaje, "warning");
     }
   }
  });

});

/*==============================================================*/

function depaSelect(DepaId,Depa){

  var combo = document.getElementById("CmbAsunto");
  var selected = combo.options[combo.selectedIndex].text;
  var Atencion = document.getElementById("txtAtencion").value;

  var Info = '<address>'+
           '<strong class="text-dark">'+Depa+'.</strong><br>'+
           '<small></small>'+

           '</address>';

  var info_Fin = '<address>'+
                 '<strong class="text-dark">'+Depa+'.</strong><br>'+
                 '<small>'+selected+
                 '</small><div id="Atencion_To">PARA: '+Atencion+'</div></address>';

  document.getElementById("Info_Asunto").innerHTML=Info;
  document.getElementById("InfoRecept").innerHTML=info_Fin;
  document.getElementById("txtDestino").value=DepaId;

  document.getElementById("Info_Asunto").innerHTML=Info;
  document.getElementById("InfoRecept").innerHTML=info_Fin;
}

/*=============================================================*/

$("#txtBuscar").keypress(function(e){
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 13) ){
    var txtFiltro = document.getElementById("txtBuscar").value;

    var _token = $('input[name="_token"]').val();

      $.ajax({
        url:'/Envios/BDepto',
        type: 'POST',
        data:{_token:_token,txtFiltro:txtFiltro},
        success: function(data){
           if($.isEmptyObject(data.Dato)){
             document.getElementById("ResultadosBusqueda").value='';
           }else{
             document.getElementById("ResultadosBusqueda").innerHTML = data.Dato;
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
//Asunto
