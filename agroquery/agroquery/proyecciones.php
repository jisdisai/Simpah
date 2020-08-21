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
		<TITLE>Proyecciones</TITLE>
		<LINK rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<LINK rel="stylesheet" href="css/proyecciones_estilos.css">
    	<SCRIPT src="Bootstrap/jquery.min.js"></script>
    	<SCRIPT src="Bootstrap/popper.min.js"></script>
    	<SCRIPT src="Bootstrap/bootstrap.min.js"></script>
    	<SCRIPT src="Bootstrap/bootstrap3-typeahead.min.js"></script>  
    	<SCRIPT src="javascript/plotly-latest.min.js"></SCRIPT>
    	<SCRIPT src="javascript/ajax.min.js"></SCRIPT>
	    <SCRIPT src="javascript/bootstrap-multiselect.js"></script>
    	<LINK rel="stylesheet" href="css/bootstrap-multiselect.css">
      <LINK href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
      <LINK href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
      <script src="https://use.fontawesome.com/eeea9c5e9d.js"></script>


    	<SCRIPT>
    		$(document).ready(function(){
    			var nombreProducto_global="";
				var unidad_global="";
				var tamanio_global="";
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
			//funciones
				function actualizarSelects(){
					$.ajax({
          				type:"post",
          				url:"php/proyecciones/actualizarSelects.php",
          				success: function(resp){
            				if(resp.localeCompare('error')==0){
            					alert("error");
            				}
            				else{
              					eval(resp);     
            				}
          				}
        			});  
				}
				function actualizarMercados(){
					$.ajax({
          				type:"post",
          				url:"php/proyecciones/actualizarSelectsMercados.php",
          				data:{'tipoProducto':$("#select_tipoProducto").val()},
          				success: function(resp){
            				if(resp.localeCompare('error')==0){
            					alert("error");
            				}
            				else{
              					eval(resp);
              					$("#select_mercado").attr("disabled",false);
            				}
          				}
        			}); 
				}
				function actualizarProductos(){
					$.ajax({
						type:"post",
						url:"php/proyecciones/actualizarProductos.php",
						data:{
							"tipoProducto": $("#select_tipoProducto").val(),
							"mercado": $("#select_mercado").val()
						},
						success: function(resp){
							$("#contenedor_select_productos").empty();
							$("#contenedor_select_productos").html("<SELECT id='select_productos' name='productos' multiple class='form-control'></SELECT>");
							eval(resp);
							$('#select_productos').multiselect({
  								nonSelectedText: '0 Elementos Seleccionados',
  								enableFiltering: true,  
  								enableCaseInsensitiveFiltering: true,
  								buttonWidth: $("#contenedor_select_productos").css("width"),
  								includeSelectAllOption: true
 							});
 							$("#btn_buscar").attr("disabled",false);
						}
					});
				}
				//Eventos
				$("#select_tipoProducto").change(function(){
					actualizarMercados();			
					$("#contenedor_selectProductos").empty();
				});
				$("#form_parametros").submit(function(){
					if($(this).serialize().split("limitePrecio")[0]!=""){
						var productos=$(this).serialize().split("&limitePrecio")[0];

						productos=productos.replace(/&productos=/g,",");
						productos=productos.replace(/productos=/g,"");					
						datosProductos=productos;
						$.ajax({
							type:"post",
							url:"php/proyecciones/generarGrafica.php",
							data: {
								'tipoProducto': $("#select_tipoProducto").val(),
								'mercado':$("#select_mercado").val(),
								'productos':datosProductos,
								'limitePrecio':$('input:radio[name=limitePrecio]:checked').val(),
								'intervalo':$("#select_intervalos").val(),
							},
							success(resp){							
								eval(resp);								
								//$("#salidaErrores").html(resp);						
								$(".traces").click(function (e){
									//texto=$("text", this).html();
									texto = $("text",this).attr("data-unformatted");									
									var nombreProducto=texto.split("<br>")[0];
									nombreProducto_global=nombreProducto;
									var tamanio=(texto.split("[")[1]).split("/")[0];
									tamanio_global=tamanio;
									var unidad=(texto.split("]")[0]).split("/")[1];
									unidad_global=unidad;
									$.ajax({
										type:"post",
										url:"php/proyecciones/generarGrafica2.php",
										data:{
											'nombreProducto': nombreProducto,
											'tamanio':tamanio,
											'unidad': unidad,
											'limitePrecio': $('input:radio[name=limitePrecio]:checked').val(),
											'intervalo': $("#select_intervalos").val()
										},
										success(resp){
											//$("#salidaErrores").html(resp);
											eval(resp);
											//$("#alerta").hide();
										}
									});								
								});							
							}					
						});
					}
					else{
						alert("Debes seleccionar al menos un Producto");
					}					
					return false;				
				});
				$("#select_mercado").change(actualizarProductos);
				$("#select_intervalo2").change(function(){
					$("#modal_cuerpo").empty();
					$.ajax({
						type:"post",
						url:"php/proyecciones/generarGrafica2.php",
						data:{
							'nombreProducto': nombreProducto_global,
							'tamanio':tamanio_global,
							'unidad': unidad_global,
							'limitePrecio': $('input:radio[name=limitePrecio]:checked').val(),
							'intervalo': $("#select_intervalo2").val()
							},
						success(resp){
							$("#modal1").hide();
							eval(resp);
						}
					});
				});
				$("#cerrarModal").click(function(){
					$("#modal_cuerpo").empty();
					$("#modal1").hide();
				});
				//Llamada de funciones
				actualizarSelects();
				//Ajustes de elementos
				$("#btn_buscar").css("height",$("#contenedor_select_intervalos").css("height"));
				$("#error").hide();
    		});
    	</SCRIPT>    	
	</HEAD> 
	<BODY style="background-color: #E9EBEE">
		<HEADER>
          <NAV class="navbar navbar-dark navbar-expand-lg" style="background-color: #9EC709">
            <A class="navbar-brand ml-lg-5" href="#"><img class="mr-3" src="img/agroquery.png" style="width: 25px; height: 25px">AgroQuery</A>
            <BUTTON class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <SPAN class="navbar-toggler-icon"></SPAN>
            </BUTTON>
            <DIV class="collapse navbar-collapse w-100 order-3" id="navbarSupportedContent">              
              <UL class="navbar-nav ml-auto">
                <LI class="nav-item ">
                    <A class="nav-link" href="main.php"><I class="fa fa-home mr-1" aria-hidden="true"></I>Inicio</A>
                </LI>
                <LI class="nav-item dropdown mr-lg-5 active">
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
    	<DIV class="container border shadow mt-5" id="parametros" style="background-color: white">
      		<DIV class="row encabezado_parametros" >
        		<h3 class="ml-2" class="etiqueta">Parámetros de Búsqueda</h3>
      		</DIV>
      		<FORM id="form_parametros">
        		<DIV class="row mt-3">
		          	<DIV class="col-xs-12 col-md-4">
            			<label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Tipo de Productos </label>
            			<DIV class="border border-success rounded mt-3 pt-3 pb-2 pr-2 pl-2 mb-2">               
              				<SELECT class="form-control" id="select_tipoProducto">
              				</SELECT>
            			</DIV>
          			</DIV>
           			<DIV class="col-xs-12 col-md-4">            
            			<label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Lugar de Venta </label>
            			<DIV class="border border-success rounded mt-3 pt-3 pb-2 pr-2 pl-2 mb-2">               
              				<SELECT class="form-control" id="select_mercado" disabled>
              				</SELECT>
            			</DIV>
          			</DIV>
           			<DIV class="col-xs-12 col-md-4">
                        <label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Productos </label>
            			<DIV class="border border-success rounded mt-3 pt-3 pb-2 pr-2 pl-2 mb-2" id="contenedor_select_productos">               
              				<SELECT class="form-control" disabled>
              				</SELECT>
            			</DIV>
          			</DIV>
        		</DIV>
        		<DIV class="row">
          			<DIV class="col-xs-12 col-md-4">            
            			 <label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Límite de precios</label>
            			<DIV class="border border-success rounded mt-3 pt-3 pb-2 pr-2 pl-2 mb-2">               
              				<LABEL class="radio-inline pl-3">
                				<INPUT type="radio" name="limitePrecio" value="precioAlto" checked/> Precio Mínimo
              				</LABEL>
              				<LABEL class="radio-inline pl-3">
                				<INPUT type="radio" name="limitePrecio" value="precioBajo" /> Precio Máximo
              				</LABEL> 
            			</DIV>
          			</DIV>
          			<DIV class="col-xs-12 col-md-4">            
            			<label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Intervalos</label>
            			<DIV class="border border-success rounded mt-3 pt-2 pb-2 pr-2 pl-2 mb-2" id="contenedor_select_intervalos">               
              			<SELECT class="form-control" id="select_intervalos" name="intervalo">
                  			<OPTION value="semana" >Semana</OPTION>
                  			<OPTION value="mes">Mes</OPTION>
                  			<OPTION value="trimestre">Trimestre</OPTION>
                  			<OPTION value="anio" selected="true">Año</OPTION>
              			</SELECT>
            			</DIV>
          			</DIV>
           			<DIV class="col-xs-12 col-md-4">
              			<INPUT type="submit" class="form-control btn btn-success mt-3" id="btn_buscar" disabled value="Buscar">
           			</DIV>
        		</DIV>
      		</FORM>
    	</DIV>
    	<DIV class="container border mt-4 shadow" id="parametros" style="background-color: white;">
      		<DIV class=" row encabezado_parametros">
        		<H3 class="ml-2 ">Resultados</H3>
      		</DIV>
      		<DIV class="row text-center mt-5" id="alerta">
      			<Div class="alert alert-warning alert-dismissible fade show col-lg-6 offset-lg-3 col-xs-12" role="alert">
  					Debes definir los <strong>parámetros de búsqueda</strong> de los registros con los que se generarán las proyecciones.    				
  					
				</Div>
      		</DIV>
      		<DIV class="row text-center mt-5" id="error">
      			<Div class="alert alert-warning alert-dismissible fade show col-lg-6 offset-lg-3 col-xs-12" role="alert">
  					Uno o más de los productos seleccionados no cuenta con los suficientes datos para generar una proyección. Intenta con un intervalo menor de tiempo.    				
  					
				</Div>
      		</DIV>
      		<DIV class="row mr-0 pr-0" id="contenedor_grafico" style="width:100%;  overflow-x: scroll; overflow-y: scroll; margin: 0">
      			<DIV id="plot" style="width: 100%"></DIV>
      		</DIV>
      	</DIV>
      	<DIV class="modal" tabindex="-1" role="dialog" id="modal1">
  			<DIV class="modal-dialog modal-lg" role="document">
    			<DIV class="modal-content">
      				<DIV class="modal-header">
        				<H5 class="modal-title">Precio en cada punto de venta</H5>
        					<BUTTON type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrarModal">	
          						<SPAN aria-hidden="true">&times;</SPAN>
        					</BUTTON>
      				</DIV>
      				<DIV class="modal-body" id="modal_cuerpo" style="overflow-y: scroll">        					
      				</DIV>
      				<DIV class="modal-footer">
      					<DIV class="container-fluid">
      						<DIV class="row">      							
      							<DIV class="col-xs-12 col-md-4">            
            						<label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Intervalos</label>
            						<DIV class="border border-success rounded mt-3 pt-2 pb-2 pr-2 pl-2 mb-2" id="contenedor_select_intervalos">               
              							<SELECT class="form-control" id="select_intervalo2" name="intervalo">
                  							<OPTION value="semana" >Semana</OPTION>
                  							<OPTION value="mes">Mes</OPTION>
                  							<OPTION value="trimestre">Trimestre</OPTION>
                  							<OPTION value="anio" selected="true">Año</OPTION>
              							</SELECT>
            						</DIV>
          						</DIV>
      						</DIV>
      					</DIV>        					
      				</DIV>
    			</DIV>
  			</DIV>
		</DIV>
      	<DIV class="container mt-4" id="salidaErrores">
      		
      	</DIV>
	</BODY>
</HTML>