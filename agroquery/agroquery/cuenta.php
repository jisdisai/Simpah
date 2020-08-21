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
		<LINK rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    	<SCRIPT src="Bootstrap/jquery.min.js"></SCRIPT>
    	<SCRIPT src="Bootstrap/popper.min.js"></SCRIPT>
    	<SCRIPT src="Bootstrap/bootstrap.min.js"></SCRIPT>
    	<SCRIPT src="Bootstrap/bootstrap3-typeahead.min.js"></SCRIPT>

    	<SCRIPT src="https://use.fontawesome.com/eeea9c5e9d.js"></SCRIPT>

    	<LINK rel="stylesheet" href="css/cuenta_estilos.css">

	</HEAD>

	<SCRIPT>

		$(document).ready(function(){
      var uid="";
      var tid="";
      var tpid="";
      var cid="";
      var cup=0;
      var cue=0;
      var admins=0;
      var nadmins="comodin";
      $("#btn_aceptar_errorPlan").click(function(){
        $("#errorCambioPlan").hide();
      });
      function obtenerDatosCuenta(){
        $.ajax({
          type:'post',
          url:'php/obtenerDatosCuenta.php',
          data:{
            'idUsuario': '<?php echo($idUsuario)?>'
          },
          success: function(resp){
            eval(resp);
            $("#btn_agregarUsuario").click(function(){
               if(cue>=cup){
                 $("#errorCantidadUsuarios").show();
                }
                else{
                  $("#modal1").show();
                }
              
            });  
            $(".btn_eliminar_usr").each(function(){
              $(this).click(function(){     

                var eliminar_usr = ($(this).attr("id").split("eliminar-usr-")[1]);
                $.ajax({
                  type:'post',
                  url:'php/eliminarUsuario.php',
                  data:{
                    'usuario': eliminar_usr
                  },
                  success: function(resp){
                    eval(resp);
                  }
                });                
              });
            });
            $(".checkAdmin").each(function(){
              if($(this).prop("checked")){
                admins=admins+1;
                nadmins=nadmins.replace(/comodin/g,$(this).attr("id").split("administrador-usr-")[1]+"-1,comodin");
              }
                         
              $(this).click(function(){
                  if($(this).prop("checked")){
                    admins=admins+1;
                    nadmins=nadmins.replace(/comodin/g,$(this).attr("id").split("administrador-usr-")[1]+"-1,comodin");
                  }
                  else{                    
                    if((admins-1)==0){
                      alert("Debe haber al menos un administrador para esta cuenta.");
                      $(this).prop("checked",true);
                    }
                    else{
                      admins=admins-1;
                      nadmins=nadmins.replace(/comodin/g,$(this).attr("id").split("administrador-usr-")[1]+"-0,comodin");
                    }                    
                   
                  }
              });
            });
          }
        });

      }
      $("#btn_aceptar_errorCantidad").click(function(){
        $("#errorCantidadUsuarios").hide();
      });
      $("#btn_confirmar_eliminar").click(function(){
        var usr = ($(this).attr("name")).split("eliminar-usr-")[1];
        $.ajax({
          type:'post',
          url:'php/confirmarEliminar.php',
          data: {
            'usuario': usr
          },
          success: function(resp){
            eval(resp);
          }
        });
      });
      $("#cancelar_eliminar").click(function(){
        $("#confirmarEliminar").hide();
      });
      $("#btn_guardar_correo").click(function(){
        $.ajax({
          type:'post',
          url:'php/actualizarCorreo.php',
          data:{
            'correo': $("#campo_correo").val(),
            'cuenta': cid
          },
          success: function(resp){
            eval(resp);
          }
        });
      });
      $("#btn_guardar_clave").click(function(){
        $.ajax({
          type:'post',
          url:'php/actualizarPassword.php',
          data:{
            'cuenta':cid,
            'claveActual': $("#clave_actual").val(),
            'claveNueva': $("#clave_nueva").val(),
            'claveRepetir': $("#clave_repetir").val()
          },
          success: function(resp){
            eval(resp);
          }
        });
      });
      obtenerDatosCuenta();

      $("#btn_guardar_usuario").click(function(){
        $.ajax({
          type:'post',
          url:'php/actualizarAdmins.php',
          data:{
            'listaAdmins': nadmins.replace(/,comodin/g,""),
            'idUsuario':uid
          },
          success: function(resp){
            eval(resp);
          }
        });
      });
      $("#btn_guardar_tarjeta").click(function(){
       if($("#campo_nombreTarjeta").val()=="" || $("#campo_numeroTarjeta").val()=="" || $("#campo_numeroTarjeta").val().length<16 || $("#campo_vencimientoTarjeta").val()=="" || $("#campo_codigoTarjeta").val()==""){
          $("#errorTarjeta").removeClass("d-none");
       }
       else{
          $("#errorTarjeta").addClass("d-none");
          $.ajax({
            type:'post',
            url:'php/actualizarTarjeta.php',
            data:{
              'tid': tid,
              'nombreTarjeta': $("#campo_nombreTarjeta").val(),
              'numeroTarjeta': $("#campo_numeroTarjeta").val(),
              'fechaTarjeta':$("#campo_vencimientoTarjeta").val(),
              'codigoTarjeta':$("#campo_codigoTarjeta").val()
            },
            success: function(resp){
              eval(resp);
            }
          });
       }
      });
      $("#btn_guardar_plan").click(function(){
        if(tpid.localeCompare("Esencial")==0){
         if(cue>1){
          $("#errorCambioPlan").show();
         }
         else{
          $.ajax({
            type:'post',
            url:'php/actualizarPlan.php',
            data:{
              'tipoPlan':tpid,
              'cuenta':cid
            },
            success: function(resp){
              eval(resp);
            }
          });
         }
        }
        else{
          if(tpid.localeCompare("Profesional")==0){
            if(cue>4){
              $("#errorCambioPlan").show();
            }
            else{
               $.ajax({
                  type:'post',
                  url:'php/actualizarPlan.php',
                  data:{
                    'tipoPlan':tpid,
                    'cuenta':cid
                  },
                  success: function(resp){
                    eval(resp);
                  }
                });
            }
          }
          else{
            $.ajax({
                  type:'post',
                  url:'php/actualizarPlan.php',
                  data:{
                    'tipoPlan':tpid,
                    'cuenta':cid
                  },
                  success: function(resp){
                    eval(resp);
                  }
            });
          }
        }
      });

      $("#nombreUsuario").html("<i class='fa fa-user mr-1' aria-hidden='true'></i><?php echo($usuario)?>");
      $(".btn-cancelar").each(function(){
        $(this).click(function(){
          location.reload();
        });
      });

      $("#btn_guardar_nuevoUsuario").click(function(){
        
        if( $("#nombre_nuevoUsuario").val() == "" ){
          $("#errorNuevoUsuario").removeClass("d-none");
        }
        
        else{
          $.ajax({
            type:'post',
            url:'php/guardarUsuario.php',
            data:{
              'nombreUsuario':$("#nombre_nuevoUsuario").val(),
              'cuenta':cid
            },
            success: function(resp){
              eval(resp);
            }
          });
        }        
      });

      $("#btn_editar_tarjeta").click(function(){
        $(".campo_tarjeta").each(function(){
          $(this).attr("disabled",false);
        });
        $("#btn_guardar_tarjeta").attr("disabled",false);
        $(this).addClass("d-none");
        $("#btn_cancelar_tarjeta").removeClass("d-none");
      });
      $("#btn_editar_plan").click(function(){
        $(".plan").each(function(){
          $(this).removeClass("noSeleccionable");
          $(this).addClass("seleccionable");
        });
        $("#btn_guardar_plan").attr("disabled",false);
        $(this).addClass("d-none");
        $("#btn_cancelar_plan").removeClass("d-none");


          $(".seleccionable").click(function(){
              $(".seleccionable").each(function(){
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
            });
            $(".seleccionable").mouseover(function(){
              $(".seleccionable").each(function(){
                $(this).removeClass("mt-5");
                $(this).removeClass("mt-2");
                $(this).addClass("mt-5");
              });
              $(this).removeClass("mt-5");
              $(this).addClass("mt-2");
            });
            $(".seleccionable").mouseout(function(){
              
                $(this).removeClass("mt-5");
                $(this).removeClass("mt-2");
                $(this).addClass("mt-5");
              
            });

      });
      $("#btn_editar_correo").click(function(){
        $("#campo_correo").attr("disabled",false);
        $("#btn_guardar_correo").attr("disabled",false);
        $(this).addClass("d-none");
        $("#btn_cancelar_correo").removeClass("d-none");
      });
       $("#btn_editar_clave").click(function(){
        $(".pass_bloqueable").each(function(){
          $(this).attr("disabled",false);
        });
        $("#btn_guardar_clave").attr("disabled",false);
        $(this).addClass("d-none");
        $("#btn_cancelar_clave").removeClass("d-none");
      });

      $("#btn_editar_usuario").click(function(){
        $(".usr_bloqueable").each(function(){
          $(this).attr("disabled",false);
        });
        $("#btn_guardar_usuario").attr("disabled",false);
        $(this).addClass("d-none");
        $("#btn_cancelar_usuario").removeClass("d-none");
      });

			function cerrarModal(){
				$("#modal1").hide();
			}
      $(".plan").each(function(){
        $(this).click(function(){
          tpid=$(this).attr("id");
        });
      });
			$("#cancelarUsuario").click(cerrarModal);
			$("#cerrarUsuario").click(cerrarModal);
			$("#btn_agregarUsuario").click(function(){
				$("#modal1").show();
			});
			$(".btn_mostrar").click(function(){
				if($("#"+$(this).attr("name")).attr("type")=="password"){
					$("#"+$(this).attr("name")).attr("type","text");
					$("i",$(this).parent()).removeClass("fa-eye");
					$("i",$(this).parent()).addClass("fa-eye-slash");
				}
				else{
					$("#"+$(this).attr("name")).attr("type","password");
					$("i",$(this).parent()).removeClass("fa-eye-slash");
					$("i",$(this).parent()).addClass("fa-eye");
				}
			});
			$(".card").each(function(){											
				if($(this).attr("name")!="pln"){
					$(this).hide();
				}
			});
			$(".sidebar-item").each(function(){
				$(this).click(function(){
					$(".card").each(function(){
						if($(this).attr("name")!="pln"){
							$(this).hide();
						}
					});
					$("#"+$(this).attr("name")).show();
				});
			});



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
			
		});
	</SCRIPT>

	<BODY style="background-color: #E9EBEE">
		<HEADER>
          <NAV class="navbar navbar-dark navbar-expand-lg">
            <A class="navbar-brand ml-lg-5" href="#"><img class="mr-3" src="img/agroquery.png" style="width: 25px; height: 25px">AgroQuery</A>
            <BUTTON class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <SPAN class="navbar-toggler-icon"></SPAN>
            </BUTTON>
            <DIV class="collapse navbar-collapse w-100 order-3" id="navbarSupportedContent">              
              <UL class="navbar-nav ml-auto">
                <LI class="nav-item ">
                    <A class="nav-link" href="main.php"><I class="fa fa-home mr-1" aria-hidden="true"></I>Inicio</A>
                </LI>
                <LI class="nav-item dropdown active mr-lg-5">
                  <A class="nav-link dropdown-toggle" href="#" id="nombreUsuario" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user mr-1" aria-hidden="true"></i>Nombre de Usuario</A>                  
                  <DIV class="dropdown-menu" aria-labelledby="nombreUsuario">
                    
                    <A class="dropdown-item" id="cerrarSesion" style="cursor: pointer;"><i class="fa fa-sign-out mr-2" aria-hidden="true"></i>Cerrar Sesión</A>
                  </DIV>            
                </LI>
              </UL>
            </DIV>
          </NAV>
        </HEADER>

        <div class="sidebar-container border-right border-success bg-light">
  			
  			<ul class="sidebar-navigation">
    			<li class="header text-light text-bold bg-success">Pago</li>
    			<li class="sidebar-item" name="tarjeta">
      				<a href="#" class="text-dark bg-light">
        				<i class="fa fa-credit-card" aria-hidden="true"></i> Configuración de Tarjeta
      				</a>
    			</li>
    			<li class="sidebar-item" name="plan">
      				<a href="#" class="text-dark bg-light">
        				<i class="fa fa-handshake-o" aria-hidden="true"></i> Selección de Plan
      				</a>
    			</li>
    			<li class="header text-light text-bold bg-success">Inicio de Sesión</li>
    			<li class="sidebar-item" name="email">
      				<a href="#" class="text-dark bg-light">
        				<i class="fa fa-envelope-o" aria-hidden="true"></i> Correo Electrónico
      				</a>
    			</li>
    			<li class="sidebar-item" name="password">
      				<a href="#" class="text-dark bg-light">
        				<i class="fa fa-key" aria-hidden="true"></i>Contraseña
      				</a>
    			</li>
    			<li class="header text-light text-bold bg-success">Perfiles de Usuarios</li>
    			<li class="sidebar-item" name="usuarios">
      				<a href="#" class="text-dark bg-light">
        				<i class="fa fa-users" aria-hidden="true"></i> Usuarios
      				</a>
    			</li>
  			</ul>
		</div>

		<DIV class="content-container">  
			<DIV class="row">
				<DIV class="col-xs-10 col-lg-10 mx-auto mt-1 ">
					<DIV class="card shadow" id="tarjeta">
						<DIV class="card-header pl-3 pt-1">
							<i class="fa fa-credit-card mr-2" aria-hidden="true"></i>Cambiar Configuración de Tarjeta
							<br>								
                			<DIV class="mt-1">
                				<IMG src="img/bac.jpg" style="width: 40px; height: 20px"></IMG>
                				<IMG src="img/visa.png" style="width: 40px; height: 20px" class="pl-1"></IMG>
                				<IMG src="img/american.png" style="width: 40px; height: 20px" class="pl-1"></IMG>
                			</DIV>                										
						</DIV>
						<DIV class="card-body">
							<DIV class="container-fluid">                	
                     			<DIV class="row mt-4">
                   	 				<DIV class="col-sm-12">
                   	 					<input class="form-control form-control-lg campo_tarjeta" type="text" placeholder="Nombre" disabled id="campo_nombreTarjeta">                   	 		
                   	 				</DIV>
                   	 			</DIV>                   	 		
                   	 			<DIV class="row mt-4">
                   	 				<DIV class="col-sm-12">
                   	 					<input class="form-control form-control-lg campo_tarjeta" type="text" placeholder="Número de la targeta" disabled id="campo_numeroTarjeta">
                   	 				</DIV>
                   	 			</DIV>
                   	 			<DIV class="row mt-4">
                   	 				<DIV class="col-sm-12">
                   	 					<input class="form-control form-control-lg campo_tarjeta" type="text" placeholder="Fecha de vencimiento (MM/AA)" disabled id="campo_vencimientoTarjeta">
                   	 				</DIV>
                   	 			</DIV>
                   	 			<DIV class="row mt-4">
                   	 				<DIV class="col-sm-12">
                   	 					<input class="form-control form-control-lg campo_tarjeta" type="text" placeholder="Código de seguridad (CVV)" disabled id="campo_codigoTarjeta">
                   	 				</DIV>
                   	 			</DIV>
                   			</DIV>
                        <BR>
                        <DIV class="text-center">
                          <P id="errorTarjeta" class="text-danger mx-auto d-none">
                            *Datos no válidos
                          </P> 
                        </DIV>
						</DIV>
						<DIV class="card-footer">
							<DIV class="row">
								<DIV class="col-md-4 offset-md-4 ">
									<BUTTON class="form-control btn-primary" id="btn_editar_tarjeta">Editar</BUTTON>
                  <BUTTON class="form-control btn-danger d-none btn-cancelar" id="btn_cancelar_tarjeta">Cancelar</BUTTON>
								</DIV>
								<DIV class="col-md-4 ">
									<BUTTON class="form-control btn_guardar btn-success" id="btn_guardar_tarjeta" disabled>Aplicar</BUTTON>
								</DIV>
							</DIV>							
						</DIV>
					</DIV>
					<DIV class="card shadow" id="password" style="display: block">
						<DIV class="card-header pl-3 pt-1">
							<i class="fa fa-key mr-2" aria-hidden="true"></i>Cambiar Contraseña
							<br>
							<span class="text-muted">Se recomienda usar una contraseña segura que no uses para ningún otro sitio</span>
						</DIV>
						<DIV class="card-body">
							<div class="input-group">
          						<input type="password" class="form-control pwd pass_bloqueable" placeholder="Contraseña actual" id="clave_actual" disabled>
          						<span class="input-group-btn">
            						<button class="btn btn-default reveal border border-left-0 btn_mostrar pass_bloqueable" type="button" name="clave_actual" disabled><i class="fa fa-eye" aria-hidden="true" ></i></button>
          						</span>          
        					</div>
        					<br>
                   <DIV class="text-center">
                          <P id="errorClaveActual" class="text-danger mx-auto d-none">
                            *Contraseña incorrecta.
                          </P>
                  </DIV>
							<div class="input-group">
          						<input type="password" class="form-control pwd pass_bloqueable" placeholder="Nueva Contraseña" id="clave_nueva" disabled>
          						<span class="input-group-btn">
            						<button class="btn btn-default reveal border border-left-0 btn_mostrar pass_bloqueable" type="button" name="clave_nueva" disabled><i class="fa fa-eye" aria-hidden="true"></i></button>
          						</span>          
        					</div>
							<br>
							<div class="input-group">
          						<input type="password" class="form-control pwd pass_bloqueable" placeholder="Repetir contraseña" id="clave_repetir" disabled>
          						<span class="input-group-btn">
            						<button class="btn btn-default reveal border border-left-0 btn_mostrar pass_bloqueable" type="button" name=clave_repetir disabled><i class="fa fa-eye" aria-hidden="true"></i></button>
          						</span>          
        					</div>
                  <br>
                  <DIV class="text-center">
                          <P id="errorClaveRepetir" class="text-danger mx-auto d-none">
                            *Las contraseñas no coinciden.
                          </P>                           
                          <P id="errorClaveCorta" class="text-danger mx-auto d-none">
                            *La contraseña debe tener al menos 8 caracteres.
                          </P>
                  </DIV>
						</DIV>
						<DIV class="card-footer">
							<DIV class="row">
								<DIV class="col-md-4 offset-md-4 ">
									<BUTTON class="form-control btn-primary" id="btn_editar_clave">Editar</BUTTON>
                  <BUTTON class="form-control btn-danger btn-cancelar d-none" id="btn_cancelar_clave">Cancelar</BUTTON>
								</DIV>
								<DIV class="col-md-4 ">
									<BUTTON class="form-control btn_guardar btn-success" id="btn_guardar_clave" disabled>Aplicar</BUTTON>
								</DIV>
							</DIV>							
						</DIV>
					</DIV>
					<DIV class="card shadow" id="email">
						<DIV class="card-header pl-3 pt-1">
							<i class="fa fa-envelope-o mr-2" aria-hidden="true"></i>Cambiar Dirección de Correo Electrónico
							<br>							
						</DIV>
						<DIV class="card-body">
							<INPUT type="text" class="form-control" id="campo_correo" placeholder="Email" disabled>
						</DIV>
            <DIV class="text-center">
              <P id="errorCorreo" class="text-danger mx-auto d-none">
                  *No puedes omitir este campo.
              </P> 
            </DIV>
						<DIV class="card-footer">
							<DIV class="row">
								<DIV class="col-md-4 offset-md-4 ">
									<BUTTON class="form-control btn-primary" id="btn_editar_correo">Editar</BUTTON>
                  <BUTTON class="form-control btn-danger btn-cancelar d-none" id="btn_cancelar_correo">Cancelar</BUTTON>
								</DIV>
								<DIV class="col-md-4 ">
										<BUTTON class="form-control btn_guardar btn-success" id="btn_guardar_correo" disabled>Aplicar</BUTTON>									
								</DIV>							
							</DIV>
						</DIV>						
					</DIV>

					<DIV class="card shadow" id="plan">
						<DIV class="card-header pl-3 pt-1">
							<i class="fa fa-handshake-o mr-2" aria-hidden="true"></i>Cambiar de Plan
							<br>
							<span class="text-muted">El cambio se verá en el pago correspondiente al mes actual</span>							
						</DIV>
						<DIV class="card-body">
							  <DIV class="container" style="border:none">
                   	 <DIV class="row">
                   	 	<DIV class="col-lg-4 col-xs-12 offset-md-1.5 mt-2 ">
                   	 		<DIV class="card mt-5 plan noSeleccionable" id="Esencial" name="pln">
                   	 			<DIV class="card-header text-center ">
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
                   	 	<DIV class="col-lg-4 col-xs-12  mt-2 ">
                   	 		<DIV class="card shadow mt-5 plan noSeleccionable" id="Profesional" name="pln">
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
                   	 	<DIV class="col-lg-4 col-xs-12 mt-2 ">
                   	 		<DIV class="card shadow mt-5 plan noSeleccionable" id="Empresarial" name="pln">
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
						</DIV>
						<DIV class="card-footer">
							<DIV class="row">
								<DIV class="col-md-4 offset-md-4 ">
									<BUTTON class="form-control btn-primary" id="btn_editar_plan">Editar</BUTTON>
                  <BUTTON class="form-control btn-danger btn-cancelar d-none" id="btn_cancelar_plan">Cancelar</BUTTON>
								</DIV>
								<DIV class="col-md-4 ">
										<BUTTON class="form-control btn_guardar btn-success" id="btn_guardar_plan" disabled>Aplicar</BUTTON>									
								</DIV>							
							</DIV>
						</DIV>						
					</DIV>
					<DIV class="card shadow" id="usuarios">
						<DIV class="card-header pl-3 pt-1">
							<i class="fa fa-users mr-2" aria-hidden="true"></i>Modificar Lista de Usuarios
							<br>							
						</DIV>
						<DIV class="card-body" id="div_lista_usuarios">
							<table class="table border border-dark">
  								<thead class="thead-dark">
    								<tr>
      									<th scope="col">Nombre de usuario</th>
      									<th scope="col">Aministrador</th>
      									<th scope="col">Acciones</th>      									
    								</tr>
  								</thead>
  								<tbody id="listaUsuarios">
    								<tr>
      									<td ><INPUT type="text" class="form-control usr_bloqueable" value="Ruben Escobar" disabled></td>
      									<td class="text-center"><INPUT type="checkbox" class="form-control usr_bloqueable" disabled ></td>
      									<td>
      										<span class="input-group-btn">
            									<button class="btn btn-danger form-control usr_bloqueable" type="button" name="eliminar_usuario" disabled><i class="fa fa-trash-o mr-2" aria-hidden="true"></i>Eliminar
            									</button>
          								</span>
          							</td>      									
    								</tr>
    								<tr>
    									<td colspan="3">
      										<BUTTON class="form-control btn-info usr_bloqueable" id="btn_agregarUsuario" disabled>+ Agregar Usuario</BUTTON>
      									</td>
    								</tr>							
     							</tbody>
							</table>
						</DIV>
						<DIV class="card-footer">
							<DIV class="row">
								<DIV class="col-md-4 offset-md-4 ">
									<BUTTON class="form-control btn-primary" id="btn_editar_usuario">Editar</BUTTON>
                  <BUTTON class="form-control btn-danger btn-cancelar d-none" id="btn_cancelar_usuario">Cancelar</BUTTON>
								</DIV>
								<DIV class="col-md-4 ">
										<BUTTON class="form-control btn_guardar btn-success" id="btn_guardar_usuario" disabled>Aplicar</BUTTON>									
								</DIV>							
							</DIV>
						</DIV>						
					</DIV>
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
        							<p><INPUT type="text" placeholder="Nombre de usario" id="nombre_nuevoUsuario" class="form-control"></p>

                       <DIV class="text-center">
                          <P id="errorNuevoUsuario" class="text-danger mx-auto d-none">
                            *Nombre no válido.
                          </P>
                        </DIV>

      							</div>
      							<div class="modal-footer">
        							<button type="button" class="btn btn-primary" id="btn_guardar_nuevoUsuario">Guardar</button>
        							<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar">Cancelar</button>
      							</div>
    						</div>
  						</div>
					</div>

          <div class="modal" tabindex="-1" role="dialog" id="confirmarEliminar">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Eliminar Cuenta</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrarUsuario">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                    <div class="modal-body">
                      <p>Si eliminas a este usuario, la cuenta será borrada y no podrás agregar un nuevo usuario, tampoco se seguirán realizando cobros a la tarjeta asociada a esta cuenta. ¿Estas seguro de querer continuar?</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" id="btn_confirmar_eliminar">Aceptar</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelar_eliminar">Cancelar</button>
                    </div>
                </div>
              </div>
          </div>
          <div class="modal" tabindex="-1" role="dialog" id="errorCantidadUsuarios">
              <div class="modal-dialog" role="document">                
                <div class="modal-content">
                    <DIV class="modal-header text-center">
                      Error
                    </DIV>                      
                    <div class="modal-body">
                      <p>No puedes asociar más usuarios a esta cuenta.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" id="btn_aceptar_errorCantidad">Aceptar</button>
                     
                    </div>
                </div>
              </div>
          </div>
           <div class="modal" tabindex="-1" role="dialog" id="errorCambioPlan">
              <div class="modal-dialog" role="document">                
                <div class="modal-content">
                    <DIV class="modal-header text-center text-light bg-danger">
                      Error
                    </DIV>                      
                    <div class="modal-body">
                      <p class="text-danger">Tienes demasiados usuarios para cambiar a esta plan. Debes eliminar los usuarios suficientes.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" id="btn_aceptar_errorPlan">Aceptar</button>
                     
                    </div>
                </div>
              </div>
          </div>

				</DIV>
			</DIV>
				
			
		</DIV>

	</BODY>
</HTML>