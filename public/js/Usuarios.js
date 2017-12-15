function ListaColab(txtColab){
  var _token =  $("input[name='_token']").val();
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 13) ){
  $.ajax({
    url:'/Usuarios/BColaborador',
    type:'POST',
    data:{_token:_token,txtColab:txtColab},
    beforeSend: function(){
      document.getElementById("ListaColab").innerHTML='<img src="http://localhost:8000/assets/images/gif-load.gif" width="40" height="40"/> Buscando, Espere...';
    },
    success:function(data){
      document.getElementById("ListaColab").innerHTML=data.Dato;
    },
    error:function(data){
      swal("Error del servidor","Ha ocurrido un error interno en el servidor de la aplicación, intentelo nuevamente, si el problema persiste comuniquese con el administrador del sistema","error")
    }
  });
  return false;
  }else{
    return true;
  }

    return /\d/.test(String.fromCharCode(keynum));
}

/*==========================================================*/

function depaSelect(Dep,Nombre,Paterno,Materno,NomDep,Puesto,Empresa,Rf,Ns){
  var _token =  $("input[name='_token']").val();
  document.getElementById('dNombreColab').innerHTML ='<h4>'+ Nombre+' '+Paterno+' '+Materno+'</h4>';
  var CadenaScript = Ns+'|'+Rf+'|'+Nombre+'|'+Paterno+'|'+Materno+'|'+Puesto+'|'+Empresa+'|'+Dep;
  document.getElementById("txtStringDat").value = CadenaScript;

  var x=$("#dEmpresa");
      x.text(Empresa);

  var x=$("#dDepartamento");
      x.text(NomDep);

  var x=$("#dPuesto");
      x.text(Puesto);
}

/*=========================================================*/

$(".CrearUsuario").click(function(e){
  e.preventDefault();

  if($("#txtUName").val().length==0){
    swal("Falta nombre de usuario","Para registrar el colaborador, es necesario ingresar un nombre de usuario. Si cuenta con correo electronico de la empresa este usuario debe ser igual a su correo","warning");
    return false;
  }

  if($("#txtStringDat").val()==0){
    swal("Seleccione colaborador","Debe seleccionar un colaborador para crear el usuario, verifique su informacion e intentelo nuevamente","warning");
    return false;
  }

  if($("#txtMail").val().length==0){
    swal("Falta correo corporativo","Ingrese el correo corporativo del colaborador","warning");
    return false;
  }

  swal({
    title: "¿Todos sus datos son correctos?",
    text: 'Si se encuentra seguro haga click en "Continuar", de lo contrario haga click en  "cancelar"!',
    type: "question",
    showCancelButton: true,
    confirmButtonText: "Continuar!",
    cancelButtonText: "No, cancelar!",
  }).then(function(isConfirm){
    if (isConfirm) {
      var _token =  $("input[name='_token']").val();
      var DatosGral = document.getElementById('txtStringDat').value;
      var Mail = document.getElementById('txtMail').value;
      var UName = document.getElementById('txtUName').value;
      var Telefono = document.getElementById('txtTelefono').value;
      //var CmbPerfil = document.getElementById('CmbPerfil').value;
      $.ajax({
        url:"/Usuarios/CrearNuevo",
        type: "POST",
        data:{_token:_token,DatosGral:DatosGral,Mail:Mail,UName:UName,Telefono:Telefono},
        success:function(data){
          swal(data.Titulo,data.Mensaje,data.TMensaje);
          document.getElementById("txtMail").value = '';
          document.getElementById("txtUName").value = '';
          document.getElementById("txtTelefono").value = '';
          document.getElementById('txtStringDat').value = 0;
          var x=$("#dNombreColab");
              x.text('<h3>... ... ...</h3>');
        },
        error:function(data){
          swal("Error interno","Ha ocurrido un error en el servidor, intentelo nuevamente y si el problema persiste comuniquese con el administrador del sistema","error");
        }
      });
}
});
});
