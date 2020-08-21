<?php
    $usuario="";
    session_start();
    if(empty($_SESSION)){
        header('location:login.php');
    }
    else{
        $usuario=$_SESSION['usuario'];
        $idUsuario=$_SESSION['idUsuario'];
    }
?>
<!DOCTYPE HTML>
<HTML>
	<HEAD>
		<META charset="UTF-8">
    	<META name="vieport" content="width=device-width, initial-scale=1">
    	<LINK rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    	<SCRIPT src="Bootstrap/jquery.min.js"></script>
    	<SCRIPT src="Bootstrap/popper.min.js"></script>
    	<SCRIPT src="Bootstrap/bootstrap.min.js"></script>
        <title>Principal</title>
    	<LINK rel="stylesheet" href="css/main_estilos.css">

    	<LINK href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  		<LINK href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  		<script src="https://use.fontawesome.com/eeea9c5e9d.js"></script>
  		
	</HEAD>

	<SCRIPT>
       
		$(document).ready(function(){			
			$("#nombreUsuario").html("<i class='fa fa-user mr-1' aria-hidden='true'></i><?php echo($usuario)?>");
            $("#cerrarSesion").click(function(){            
                $.ajax({
                    type:'post',
                    url:'php/cerrarSesion.php',
                    data: {
                        'idUsuario': '<?php echo($idUsuario)?>'
                    },
                    success: function(resp){
                        eval(resp);
                    }            
                });
                return false;
            });
             $("#card_cuenta").click(function(){            
                $.ajax({
                    type:'post',
                    url:'php/verificarPermisos.php',
                    data: {
                        'idUsuario': '<?php echo($idUsuario)?>'
                    },
                    success: function(resp){
                        eval(resp);
                    }            
                });
                return false;
            });
            $("#btn_modal_aceptar").click(function(){
                $("#errorPermisos").hide();
            });

		});
        
		
	</SCRIPT>

	<BODY>
		<HEADER>
      		<NAV class="navbar navbar-dark navbar-expand-lg">
        		<A class="navbar-brand ml-lg-5" href="#"><img class="mr-3" src="img/agroquery.png" style="width: 25px; height: 25px">AgroQuery</A>
        		<BUTTON class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        			<SPAN class="navbar-toggler-icon"></SPAN>
        		</BUTTON>
		    		<DIV class="collapse navbar-collapse w-100 order-3" id="navbarSupportedContent">        			
        			<UL class="navbar-nav ml-auto">
                <LI class="nav-item active">
                    <A class="nav-link" href="main.php"><I class="fa fa-home mr-1" aria-hidden="true"></I>Inicio</A>
                </LI>
        				<LI class="nav-item dropdown mr-lg-5">
        					<A class="nav-link dropdown-toggle" href="#" id="nombreUsuario" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user mr-1" aria-hidden="true"></i>
        						Nombre de Usuario
        					</A>        					
        					<DIV class="dropdown-menu" aria-labelledby="nombreUsuario">
        						
        						<A class="dropdown-item" id="cerrarSesion" style="cursor: pointer;"><i class="fa fa-sign-out mr-2" aria-hidden="true"></i>Cerrar Sesión</A>
        					</DIV>      			
        				</LI>
        			</UL>
        		</DIV>
      		</NAV>
        </HEADER>

      	

      	<div class="container mt-5 mb-5">
    		<div class="row">

                <div class="modal mt-5" id="errorPermisos" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center bg-danger">
                                <h5 class="modal-title text-light">Error</h5>                        
                            </div>
                            <div class="modal-body text-danger">
                                <p>No cuentas con los permisos requeridos para realizar cambios sobre la configuración de la cuenta.</p>
                            </div>
                            <div class="modal-footer">                       
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_modal_aceptar">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>

        		<div class="col-xs-12 col-lg-4" id="contenedor_cards">
            		<div class="card shadow text-center mb-4 card_enlace" id="card_reportes">
                		<a class="img-card  border border-danger" href="reportes.php">
                    		<img src="img/reportes.png" class="icono mt-2 pb-3"/>
                		</a>
                		<br/>
                		<div class="card-content">
                    		<h4 class="card-title">
                        		<a href="reportes.php" class="text-danger">
                            		Reportes
                        		</a>
                    		</h4>
                    		<div class="">
	                        	Consulta los precios registrados y visualiza su comportamiento
                    		</div>
                		</div>
                		<div class="card-read-more">
                    		<a class="btn btn-link btn-block" href="reportes.php">
                        		Ir a Reportes
                    		</a>
                		</div>
            		</div>
        		</div>
        		<div class="col-xs-12 col-lg-4" id="contenedor_cards">
            		<div class="card shadow text-center mb-4 card_enlace" id="card_proyecciones">
                		<a class="img-card border border-warning " href="proyecciones.php">
                    		<img src="img/proyecciones.png" class="icono mt-2 pb-3"/>
                		</a>
                		<br/>
                		<div class="card-content">
                    		<h4 class="card-title">
                        		<a href="proyecciones.php" class="text-warning">
                            		Proyecciones
                        		</a>
                    		</h4>
                    		<div class="">
	                        	Obten proyecciones del comportamiento de los precios a futuro
                    		</div>
                		</div>
                		<div class="card-read-more">
                    		<a class="btn btn-link btn-block" href="proyecciones.php">
                        		Ir a Proyecciones
                    		</a>
                		</div>
            		</div>
        		</div>
        		<div class="col-xs-12 col-lg-4" id="contenedor_cards">
            		<div class="card shadow text-center mb-4 card_enlace" id="card_cuenta">
                		<a class="img-card border border-info">
                    		<img src="img/usuarios.png" class="icono mt-2 pb-3"  />
                		</a>
                		<br/>
                		<div class="card-content">
                    		<h4 class="card-title">
                        		<a  class="text-info">
                            		Configuración de Cuenta
                        		</a>
                    		</h4>
                    		<div class="">
	                        	Reestablece tus credenciales de acceso, configuración de tarjeta o selección de plan
                    		</div>
                		</div>
                		<div class="card-read-more text-primary">
                    		<a class="btn btn-link btn-block ">
                        		Ir a ajustes de usuarios
                    		</a>
                		</div>
            		</div>
        		</div>
    		</div>
		</div>

      	<FOOTER class="footer fixed-bottom">
    			<DIV class="container">
      				<DIV class="row">
        				<DIV class="col-lg-6 offset-xs-3 offset-lg-3 text-center">
          					<p class="text-muted small ">&copy; AgroQuery 2020. Derechos Reservados.</p>
        				</DIV>        
      				</DIV>
    			</DIV>
  		</FOOTER>
	</BODY>
</HTML>