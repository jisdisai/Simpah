function iniciarSesion(){
  var usuario= $("#txt-Usuario").val();
  var contrasenia= $("#txt-Password").val();

  $.ajax({
    url:"ajax/acciones-sesion.php",
    data:{
          "accion":"iniciar-sesion",
          "txt-Usuario":usuario,
          "txt-Password":contrasenia
        },
    dataType: 'json',
    method: "POST",
    success: function(respuesta){  
      console.log(respuesta);
      if (respuesta.loggedin == 0) {
        $("#status").html(respuesta.mensaje);
      }
      else {
       
          window.location="administrador.php";
      }
    },
    error:function(e){
      console.log("Error");
    }
  });
}

