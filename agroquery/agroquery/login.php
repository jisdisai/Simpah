<?php
   
    session_start();
    if(!empty($_SESSION)){
        header('location:main.php');
    }
   
?>

<!DOCTYPE html>
<html lang="esp">
<head>
	<title>Agroquery | Inicio de Sesión</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">	
  	<link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  	<link href="css/login_carousel.css" rel="stylesheet" type="text/css">
  	<link href="css/main.css" rel="stylesheet" type="text/css">
	<SCRIPT src="javaScript/jquery-3.4.1.min.js"></SCRIPT>
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<script src="javascript/jquery-3.4.1.min.js"></script>
	<script src="javascript/ajax.js"></script>
</head>
	<script type="text/javascript">
		$(document).ready(function(){
		 	var uuo=false;
			$("#contenedor_login").fadeIn(900);
			$("#slider").click(function(){
					//alert("harás sesión como "+$(".active",this).attr("name"));
					$.ajax({
						type: 'post',
						url: 'php/iniciarsesion.php',
						data: {
							'usuario':$(".active",this).attr("name")
						},
						success: function(resp){
							eval(resp);
						}
					});
			});
			$("#cerrar_modal").click(function(){
				if(!uuo){
					$("#contenedor_error").addClass("d-none");
					$("#contenedor_mu").removeClass("d-none").hide().fadeIn();
				}
				else{
					$("#contenedor_error").addClass("d-none");
					$("#contenedor_login").removeClass("d-none").hide().fadeIn();
					uuo=false;
				}
				
			});
			$("#btn_acceder").click(function(){			
				if( $("#email").val()!="" && $("#pass").val()!=""){
					$("#camposVacios").addClass("d-none");
					$.ajax({
          				type:"post",
          				url:"php/verificarUsuario.php",
          				data:{
          					'email':$("#email").val(),
          					'pass':$("#pass").val(),
          				},
          				success: function(resp){
            				//eval(resp);
            				eval(resp);
            				//$("#salida").html(resp);           			
          				}
        			});
				}
				else{
					$("#camposVacios").removeClass("d-none");
				}
				/*$("#slider").each(function(){
					$(this).click(function(){
						alert("diste click a un usuario");
						//alert("Iniciarás sesión como "+$(this).attr("name"));
					});
				});	*/			
				return false;
			});


		});
		
	</script>

<body style="background-image: url('img/bg-masthead.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
	<nav class="navbar navbar-dark static-top" style="background-color: #9EC709">
    	<div class="container">
      		<a class="navbar-brand" href="#">AgroQuery</a>      
    	</div>
  	</nav>
  	<DIV class="container mt-5 pt-5 d-none" id="contenedor_error">
		<DIV class="row">
			<DIV class="col-md-8 col-xl-8 mx-auto">
				<DIV class="card shadow border-danger rounded-4">
					<DIV class="card-header bg-danger text-light text-center">
						<div class="features-icons-icon d-flex">
							<i class="fas fa-window-close ml-auto" id="cerrar_modal" style="cursor: pointer"></i>
						</div>
					</DIV>
					<DIV class="card-body pt-5 pb-5 text-danger">
						Este usuario ya se encuentra en una sesión.												
					</DIV>
					
				</DIV>
			</DIV>
			
		</DIV>
	</DIV>
	<DIV class="container mt-5 pt-5" id="contenedor_login">
		<DIV class="row">
			<DIV class="col-md-6 col-xs-8 mx-auto">
				<DIV class="card shadow border-success rounded-4">
					<DIV class="card-header bg-success text-light text-center">
						Acceder
					</DIV>
					<DIV class="card-body">
						<INPUT type="text" class="form-control mt-2 mb-2" id="email" placeholder="Correo electrónico">
						<INPUT type="password" class="form-control mt-3 " id="pass" placeholder="Contraseña">												
					</DIV>
					<P class="text-center text-danger d-none" id="datosIncorrectos">
						*Contraseña o correo incorrectos.
					</P>
					<P class="text-center text-danger d-none" id="camposVacios">
						*Has omitido algún campo.
					</P>
					<br>
					<DIV class="card-footer text-center">
						<BUTTON class="btn btn-success" id="btn_acceder">Acceder</BUTTON>
					</DIV>
				</DIV>
			</DIV>
			
		</DIV>
	</DIV>
	<!--Dos usuarios-->
	<DIV class="container my-auto pt-5 d-none" id="contenedor_mu">
		<DIV class="row mt-5">
			<DIV class="col-md-8 mx-auto">
				<div id="carouselExampleControls" class="carousel slide " data-ride="carousel">
  					<div class="carousel-inner" id="slider">
    					<div class="carousel-item active">
      						<DIV class="card shadow border-0 w-50 mx-auto" id="user-1">
								<DIV class="card-body">
									<div class="features-icons-icon d-flex">
										<i class=" fa fa-7x fa-user m-auto text-success" aria-hidden="true"></i>
									</div>
								</DIV>
								<DIV class="card-footer text-center bg-success text-light pb-4 pt-4">
									usuario 1
								</DIV>
							</DIV>							
    					</div>
    					<div class="carousel-item ">
      						<DIV class="card shadow border-0 w-50 mx-auto" id="user-2">
								<DIV class="card-body">
									<div class="features-icons-icon d-flex">
										<i class=" fa fa-7x fa-user m-auto text-success" aria-hidden="true"></i>
									</div>
								</DIV>
								<DIV class="card-footer text-center bg-success text-light pb-4 pt-4">
									usuario 2
								</DIV>
							</DIV>							
    					</div>
    					<div class="carousel-item ">
      						<DIV class="card shadow border-0 w-50 mx-auto" id="user-3">
								<DIV class="card-body">
									<div class="features-icons-icon d-flex">
										<i class=" fa fa-7x fa-user m-auto text-success" aria-hidden="true"></i>
									</div>
								</DIV>
								<DIV class="card-footer text-center bg-success text-light pb-4 pt-4">
									usuario 3
								</DIV>
							</DIV>							
    					</div>   			
  					</div>
  					<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
    					<i class="fa fa-arrow-circle-left fa-3x text-success" aria-hidden="true"></i>
    					<span class="sr-only">Previous</span>
  					</a>
  					<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
    					<i class="fa fa-arrow-circle-right fa-3x text-success" aria-hidden="true"></i>
    					<span class="sr-only">Next</span>
  					</a>
				</div>
			</DIV>
		</DIV>			
	</DIV>
	<!--Tres usuarios-->
	

</body>
</html>