<?php
  $correo="";
  if(isset($_POST["correo"])){
    $correo=$_POST["correo"];
  } 
?>

<!doctype html>
<html lang="en">
<head>
    <title>Smart Wizard - a JavaScript jQuery Step Wizard plugin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Include SmartWizard CSS -->
    <link href="dist/css/smart_wizard.css" rel="stylesheet" type="text/css" />

    <!-- Optional SmartWizard theme -->
    <link href="dist/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/fontawesome-free/css/fontawesome.min.css">
    <link href="css/registro/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<HEADER>
    	<NAV class="navbar navbar-dark" style="background-color: #9EC709">
      		<A class="navbar-brand" href="#">AgroQuery</A>
    	</NAV>
    </HEADER>
    <div class="container-fluid ml-0 pl-0 pr-0 mr-0">
    	
        <div id="smartwizard" style="border: none">
            <ul class="col-md-4 offset-md-4 pr-0" id="puntos">
                <li class="offset-md-2"><a href="#step-1">Paso 1<br /><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small></a></li>
                <li><a href="#step-2">Paso 2<br /><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small></a></li>
                <li><a href="#step-3">Paso 3<br /><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small></a></li>
                <li><a href="#step-4">Paso 4<br /><small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small></a></li>
            </ul>

            <div class="contenedor_wizard" style="background:none; border:none">
                <div id="step-1" class="pt-4" style="border:none;">
                   <DIV class="border-bottom border-gray pb-2 pl-5" style="border:none;"><H3>Selecciona el plan</H3><small>Cambia a un plan inferior o superior en cualquier momento</small></DIV>
                   <DIV class="container" style="border:none">
                   	 <DIV class="row">
                   	 	<DIV class="col-sm-4 col-xs-12 offset-md-1.5 mt-2 ">
                   	 		<DIV class="card mt-5 plan planSeleccionado" name="1">
                   	 			<DIV class="card-header text-center cardSeleccionado-header">
                   	 				Esencial
                   	 			</DIV>
                   	 			<DIV class="card-body text-center">
                   	 				<P class="card-text">Un único usuario por vez</P>
                   	 				<P class="card-text">
                   	 					<SMALL class="text-muted">USD3.00</SMALL>
                   	 				</P>
                   	 			</DIV>
                   	 		</DIV>
                   	 	</DIV>
                   	 	<DIV class="col-sm-4 col-xs-12  mt-2 ">
                   	 		<DIV class="card shadow mt-5 plan" name="2">
                   	 			<DIV class="card-header text-center">
                   	 				Profesional
                   	 			</DIV>
                   	 			<DIV class="card-body text-center">
                   	 				<P class="card-text">Hasta 4 usuarios por vez</P>
                   	 				<P class="card-text">
                   	 					<SMALL class="text-muted">USD7.00</SMALL>
                   	 				</P>
                   	 			</DIV>                   	 			
                   	 		</DIV>
                   	 	</DIV>
                   	 	<DIV class="col-sm-4 col-xs-12 mt-2 ">
                   	 		<DIV class="card shadow mt-5 plan" name="3">
                   	 			<DIV class="card-header text-center">
                   	 				Empresarial
                   	 			</DIV>
                   	 			<DIV class="card-body text-center">
                   	 				<P class="card-text ">Hasta 30 usuarios por vez</P>
                   	 				<P class="card-text">
                   	 					<SMALL class="text-muted">USD10.00</SMALL>
                   	 				</P>
                   	 			</DIV>
                   	 			
                   	 		</DIV>
                   	 	</DIV>
                   	 </DIV>
                   </DIV>
                </div>
                <div id="step-2" class="">
                	<h3 class="border-bottom border-gray pb-2 pl-5">Crea tu Contraseña</h3>
                   
                     <DIV class="container-fluid">
                   	 <DIV class="row mt-4">                      
                   	 	<DIV class="col-sm-4 offset-md-4">
                          <label class="label-control text-danger" style="background-color: white" id="correoRepetido">*Este correo ya está asociado a una cuenta.</label>               
                   	 		 <input class="form-control form-control-lg " type="text" placeholder="Email" id="correo">                        
                   	 	</DIV>
                   	 </DIV>
                   	 <DIV class="row mt-4">
                   	 	<DIV class="col-sm-4 offset-md-4">
                        <label class="label-control text-danger" style="background-color: white" id="passDebil">*La contraseña debe contener al menos 6 caracteres.</label>
                   	 		<input class="form-control form-control-lg" type="password" placeholder="Contraseña" id="password">
                   	 	</DIV>
                   	 </DIV>
                   </DIV>
                </div>
                <div id="step-3" class="">
                	<Div class="border-bottom border-gray pb-2 pl-5"><h3>Configura tu tarjeta de crédito o débito</h3>
                		<DIV class="mt-1">
                			<IMG src="img/bac.jpg" style="width: 40px; height: 20px"></IMG>
                			<IMG src="img/visa.png" style="width: 40px; height: 20px" class="pl-1"></IMG>
                			<IMG src="img/american.png" style="width: 40px; height: 20px" class="pl-1"></IMG>
                		</DIV>
                	</Div>
                	<DIV class="container-fluid">                	
                     <DIV class="row mt-4">
                   	 	<DIV class="col-sm-4 offset-md-4">
                   	 		<input class="form-control form-control-lg" type="text" placeholder="Nombre">                   	 		
                   	 	</DIV>
                   	 </DIV>
                   	 <DIV class="row mt-4">
                   	 	<DIV class="col-sm-4 offset-md-4">
                   	 		<input class="form-control form-control-lg" type="text" placeholder="Apellido">
                   	 	</DIV>
                   	 </DIV>
                   	 <DIV class="row mt-4">
                   	 	<DIV class="col-sm-4 offset-md-4">
                   	 		<input class="form-control form-control-lg" type="text" placeholder="Número de la targeta">
                   	 	</DIV>
                   	 </DIV>
                   	 <DIV class="row mt-4">
                   	 	<DIV class="col-sm-4 offset-md-4">
                   	 		<input class="form-control form-control-lg" type="text" placeholder="Fecha de vencimiento (MM/AA)">
                   	 	</DIV>
                   	 </DIV>
                   	 <DIV class="row mt-4">
                   	 	<DIV class="col-sm-4 offset-md-4">
                   	 		<input class="form-control form-control-lg" type="text" placeholder="Código de seguridad (CVV)">
                   	 	</DIV>
                   	 </DIV>
                   	</DIV> 
                </div>
                <div id="step-4" class="">
                    <h3 class="border-bottom border-gray pb-2 pl-5">Crea los usarios de la cuenta (Máximo permitido: X usuario(s))</h3>
                    <div class="container">
                        <table class="table border border-dark">
                          <thead class="thead-dark">
                            <tr>
                              <th scope="col">Nombre de usuario</th>
                              <th scope="col">Aministrador</th>
                              <th scope="col">Acciones</th>                       
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td ><INPUT type="text" class="form-control" value="Usuario de Ejemplo"></td>
                              <td class="text-center" ><INPUT type="checkbox" class="form-control" ></td>
                              <td>
                              <span class="input-group-btn">
                                <button class="btn btn-danger form-control" type="button" name="clave_nueva" id="eliminarUsuario1"><i class="fa fa-trash-o mr-2" aria-hidden="true"></i>Eliminar
                                </button>
                              </span>
                              </td>                       
                            </tr>
                            <tr>
                              <td colspan="3">
                                <BUTTON class="form-control btn-info" id="btn_agregarUsuario">+ Agregar Usuario</BUTTON>
                              </td>
                            </tr>             
                          </tbody>
                        </table>   
                      </div>
                </div>               
            </div>            
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="modal1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Agregar Usuario</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrarUsuario">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <p><INPUT type="text" placeholder="Nombre de usario" class="form-control"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelarUsuario">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Include jQuery -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->

    <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="Bootstrap/popper.min.js"></script>
    <script src="Bootstrap/bootstrap.min.js" ></script>

    <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="dist/js/jquery.smartWizard.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
          var errorCorreo=false;
          var errorPass=false;
          $("#correo").val(<?php echo("\"".$correo."\"")?>);
          var planSeleccionado = "1";
          $("#correoRepetido").hide();
          $("#passDebil").hide();
          

          function verificarCorreoRepetido(){
            $.ajax({
              type:"post",
              url:"php/registro/verificarCorreo.php",
              data:{ 
                'correo': $("#correo").val()
              },
              success(resp){               
                eval(resp);
              }
            });
            if(errorPass || errorCorreo){
                $(".sw-btn-next").each(function(){
                  $(this).attr("disabled",true);
                });
              }
              else{
                $(".sw-btn-next").each(function(){
                  $(this).attr("disabled",false);
                });
            }           
          }
          function verificarPass(){
            if($("#password").val().length<6){
              $("#passDebil").show();
              $(".sw-btn-next").each(function(){
                $(this).attr("disabled",true);
                errorPass=true;
              });
            }
            else{
              $("#passDebil").hide();
              errorPass=false;
              if(errorPass || errorCorreo){
                $(".sw-btn-next").each(function(){
                  $(this).attr("disabled",true);
                });
              }
              else{
                $(".sw-btn-next").each(function(){
                  $(this).attr("disabled",false);
                });
              }
            }
          }
          function cerrarModal(){
            $("#modal1").hide();
          }
          $("#password").change(function(){            
            verificarPass();
          });
          $("#correo").change(function(){
            verificarCorreoRepetido();
           
          });


          $("#cancelarUsuario").click(cerrarModal);
          $("#cerrarUsuario").click(cerrarModal);
          $("#btn_agregarUsuario").click(function(){
            $("#modal1").show();
          });
          $(":checkbox").each(function(){
            $(this).css("height",$("#eliminarUsuario1").css("height"));
          });
        	$(".plan").mouseover(function(){
        		$(this).addClass("text-primary");
        	});
        	$(".plan").mouseout(function(){
        		$(this).removeClass("text-primary");
        	});
            // Step show event
            $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                var posicion=window.location.href;
                posicion=posicion.split("step-")[1];
               
               //alert("You are on step "+stepNumber+" now");               
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
                   $(".sw-btn-next").each(function(){
                    $(this).attr("disabled",false);
                    });
               }else if(stepPosition === 'final'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
               }
               if(posicion=="1"){
                 $(".sw-btn-next").each(function(){
                    $(this).attr("disabled",false);
                   });
               }
               if(posicion=="2"){
                if($("#correo").val()=="" || $("#password").val()==""){
                    verificarCorreoRepetido();
                    verificarPass();
                }
                else{
                  $(".sw-btn-next").each(function(){
                    $(this).attr("disabled",false);
                  });
                }
               }
               
            });

            $("#smartwizard").on("endReset", function() {
              $("#next-btn").removeClass('disabled');
            });


            // Smart Wizard
            $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'dots',
                    transitionEffect:'fade',
                    showStepURLhash: true,
                    toolbarSettings: {toolbarPosition: 'end'
                                      //toolbarButtonPosition: 'end'
                                      //toolbarExtraButtons: [btnFinish, btnCancel]
                                    }
            });

             $("#next-btn").addClass("disabled");
            // External Button Events
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                $("#next-btn").removeClass('disabled');
                return true;
            });

            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function() {
                // Navigate next
                $('#smartwizard').smartWizard("next");
                return true;
            });

            $(".card").hover(function(){
            	//$(this).addClass("border");
            });
            $(".plan").click(function(){
            	$(".plan").each(function(){
            		$(this).removeClass("planSeleccionado");
            		$(".card-header",this).each(function(){
            			$(this).removeClass("cardSeleccionado-header");
            		});
            		$(".card-body",this).each(function(){
            			$(this).removeClass("cardSeleccionado-footer");
            		});
            	});
            	$(this).addClass("planSeleccionado");
            	$(".card-header",this).each(function(){
            		$(this).addClass("cardSeleccionado-header")
            	});
            	$(".card-body",this).each(function(){
            		$(this).addClass("cardSeleccionado-footer");
            	});
              planSeleccionado=$(this).attr("name");

            });
            $(".plan").mouseover(function(){
            	$(".plan").each(function(){
            		$(this).removeClass("mt-5");
            		$(this).removeClass("mt-2");
            		$(this).addClass("mt-5");
            	});
            	$(this).removeClass("mt-5");
            	$(this).addClass("mt-2");
            });
            $(".plan").mouseout(function(){
            	
            		$(this).removeClass("mt-5");
            		$(this).removeClass("mt-2");
            		$(this).addClass("mt-5");
            	
            });

            // Set selected theme on page refresh
           (function ($) {
  "use strict";
  // Auto-scroll
  $('#myCarousel').carousel({
    interval: 5000
  });

  // Control buttons
  $('.next').click(function () {
    $('.carousel').carousel('next');
    return false;
  });
  $('.prev').click(function () {
    $('.carousel').carousel('prev');
    return false;
  });

  // On carousel scroll
  $("#myCarousel").on("slide.bs.carousel", function (e) {
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 3;
    var totalItems = $(".carousel-item").length;
    if (idx >= totalItems - (itemsPerSlide - 1)) {
      var it = itemsPerSlide -
          (totalItems - idx);
      for (var i = 0; i < it; i++) {
        // append slides to end 
        if (e.direction == "left") {
          $(
            ".carousel-item").eq(i).appendTo(".carousel-inner");
        } else {
          $(".carousel-item").eq(0).appendTo(".carousel-inner");
        }
      }
    }
  });
  $(".sw-btn-next").addClass("col-md-10");
  
})
(jQuery);
        });
    </script>
</body>
</html>
