$(".Login").click(function(e){
  var _token =  $("input[name='_token']").val();
  var txtUsuario = document.getElementById("txtUsuario").value;
  var txtPwd = document.getElementById("txtPwd").value;
  $.ajax({
    url:'/Login',
    type: 'POST',
    data:{_token:_token,txtUsuario:txtUsuario, txtPwd:txtPwd},
    successUrl:"/Menu",
    success: function(data){
    swal(data.Titulo,data.Mensaje,data.TMensaje);
    },
    error:function(data){
      swal("Error interno","Ha ocurrido un error interno en el servidor, no fue posible iniciar sesión","error");
    }
  });
});


$("#formLogin").on('submit',function(e){
  e.preventDefault();
  console.log("entra en la funcion");
})
