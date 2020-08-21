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
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->


    <META charset="UTF-8">
    <META name="vieport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <script src="Bootstrap/jquery.min.js"></script>
    <script src="Bootstrap/popper.min.js"></script>
    <script src="Bootstrap/bootstrap.min.js"></script>
    <script src="Bootstrap/bootstrap3-typeahead.min.js"></script>
    
    <SCRIPT src="javascript/tab.js"></SCRIPT>
    <link rel="stylesheet" href="css/reportes_estilos.css">    
    <SCRIPT src="javascript/plotly-latest.min.js"></SCRIPT>
    <SCRIPT src="javascript/ajax.min.js"></SCRIPT>    
    <script src="javascript/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="css/bootstrap-multiselect.css">
    <LINK href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <LINK href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <script src="https://use.fontawesome.com/eeea9c5e9d.js"></script>


    

    <title>Agroquery | Reportes</title>


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
       var datosProductos="";
       var nombreProducto_global="";
       var tamanio_global="";
       var unidad_global=""; 
       $("#btn_cerrarModal").click(function(){
          $("#modal_cuerpo").empty();
          $("#modal1").hide();
        });

       $("#btn-buscar").css("height",$("#referencialHeight").css("height"));
       $.ajax({
          type:"post",
          url:"php/reportes/actualizarTipoProducto.php",
          success(resp){
              //$("#salidaErrores").html(resp);
          eval(resp);
          }
       });
       $("#select_tipoProducto").change(function(){
        $.ajax({
          type:"post",
          url:"php/reportes/actualizarMercados.php",
          data: {            
            'tipoProducto':$("#select_tipoProducto").val()
          },
          success(resp){
            //$("#salidaErrores").html(resp);
            eval(resp);
            $("#contenedor_select_productos").empty();
            $("#contenedor_select_productos").html("<SELECT class=\"form-control\" disabled></SELECT>");
          }
        });
       });

       $("#select_mercado").change(function(){
        $("#fechaInicial").attr("disabled",false);
        $("#fechaFinal").attr("disabled",false);
        $("#btn-buscar").attr("disabled",false);
        $("#contenedor_select_productos").empty();
        
        //$("#select_productos").append("<option>opcion 1</option> <option>opcion 2</option>");
         $.ajax({
          type:"post",
          url:"php/reportes/actualizarProductos.php",
          data: {
            'mercado':$("#select_mercado").val(),
            'tipoProducto':$("#select_tipoProducto").val()
          },
          success(resp){
            $("#select_productos").empty();
            $("#contenedor_select_productos").html("<SELECT id='select_productos' name='productos' multiple class='form-control'></SELECT>");
            eval(resp);
            $('#select_productos').multiselect({
                nonSelectedText: '0 Elementos Seleccionados',
                enableFiltering: true,  
                enableCaseInsensitiveFiltering: true,
                buttonWidth:$("#contenedor_select_productos").css("width"),
                includeSelectAllOption: true
            });
           
          }
        });

       });

       $("#form_parametros").submit(function(){
        

        var productos=$(this).serialize();
        if(productos!=""){
          datosProductos=productos;
          if((productos.split("&productos=").length)>1){
            datosProductos=datosProductos.split("&")[0]+",";
            datosProductos=datosProductos+(productos.split("&productos=")[1]).split("&")[0];
            for(i=2; i<(productos.split("&productos=").length); i++){
              datosProductos=datosProductos+",";
              datosProductos=datosProductos+(productos.split("&productos=")[i]).split("&")[0];
            }
          }
          datosProductos=datosProductos.replace("productos=","");
          $.ajax({
            type:'post',
            url:'php/reportes/obtenerTabla.php',
            data:{
              'productos': datosProductos,
              'mercado': $("#select_mercado").val(),
              'tipoProducto': $("#select_tipoProducto").val(),
              'fechaInicial': $("#fechaInicial").val(),
              'fechaFinal': $("#fechaFinal").val()
            },
            success(resp) {
              eval(resp);
              
            }
          });
          generarGrafica();
        }
        else{
          alert("Debes seleccionar al menos un producto");
        }
        return false;
       });
       $("#div_precios").css("height",$("#div_intervalos").css("height"));
       $("#select_intervalo").change( function(){
        if($("#form_parametros").serialize()!=0){
          generarGrafica();
        }        
       });
       $("#radio_precioBajo").click(function(){
        if($("#form_parametros").serialize()!=""){

          generarGrafica();
        }
       });
       $("#checkbox_leyenda").click(function(){
        if($(this).prop("checked")){
          $(".infolayer").each(function(){
            $(this).show();
          });
        }
        else{
          $(".infolayer").each(function(){
            $(this).hide();
          });
        }
       });
       $("#radio_precioAlto").click(function(){
        if($("#form_parametros").serialize()!=""){
          
          generarGrafica();
        }
       });
       function generarGrafica(){       
         $.ajax({
            type:'post',
            url:'php/reportes/generargrafica.php',
            data:{
              'tipoProducto': $("#select_tipoProducto").val(),
              'mercado': $("#select_mercado").val(),
              'productos': datosProductos,
              'fechaInicial': $("#fechaInicial").val(),
              'fechaFinal':$("#fechaFinal").val(),
              'intervalo':$("#select_intervalo").val(),
              'limitePrecio': $("#parametros_grafica").serialize().split("=")[1]
            },
            success(resp){             
              eval(resp);
              //$("#salidaErrores").html(resp);
              $(".traces").click(function (e){
                texto = $("text",this).attr("data-unformatted");                  
                var nombreProducto=texto.split("<br>")[0];
                nombreProducto_global=nombreProducto;
                var tamanio=(texto.split("[")[1]).split("/")[0];
                tamanio_global=tamanio;
                var unidad=(texto.split("]")[0]).split("/")[1];
                unidad_global=unidad;
                $.ajax({
                  type:"post",
                  url:"php/reportes/generarGrafica2.php",
                  data:{
                    'nombreProducto': nombreProducto,
                    'tamanio':tamanio,
                    'unidad': unidad,
                    'limitePrecio': $('input:radio[name=limitePrecio]:checked').val(),
                    'intervalo': $("#select_intervalo").val(),
                    'fechaInicial':$("#fechaInicial").val(),
                    'fechaFinal':$("#fechaFinal").val()
                  },
                  success(resp){
                    eval(resp);
                    //$("#salidaErrores").html(resp);

                  }

                });
                            
                return false;
              });             
            }

          });
       }
       $("#select_intervalo2").change(function(){
        $("#modal_cuerpo").empty();
        $.ajax({
          type:"post",
          url:"php/reportes/generarGrafica2.php",
          data:{
            'nombreProducto': nombreProducto_global,
            'tamanio':tamanio_global,
            'unidad': unidad_global,
            'limitePrecio': $('input:radio[name=limitePrecio]:checked').val(),
            'intervalo': $("#select_intervalo2").val(),
            'fechaInicial':$("#fechaInicial").val(),
            'fechaFinal':$("#fechaFinal").val()
            },
              success(resp){
                $("#modal1").hide();
                eval(resp);
                //$("#plot").html(resp);
                

              }

            });
      });
      });
    </SCRIPT>
  </head>
  <body>
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
                <OPTION>Todos</OPTION>
              </SELECT>
            </DIV>

          </DIV> 


           <DIV class="col-xs-12 col-md-3">
            
            <label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Lugar de Venta </label>
            <DIV class="border border-success rounded mt-3 pt-3 pb-2 pr-2 pl-2 mb-2">               
              <SELECT class="form-control" id="select_mercado" disabled>
                
              </SELECT>
            </DIV>

          </DIV> 

           <DIV class="col-xs-12 col-md-5">
            
            <label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Productos </label>
            <DIV class="border border-success rounded mt-3 pt-3 pb-2 pr-2 pl-2 mb-2" id="contenedor_select_productos">               
              <SELECT class="form-control" disabled>
              
              </SELECT>
            </DIV>

          </DIV>

        </DIV>

        <DIV class="row">
          <DIV class="col-xs-12 col-md-4">
            
            <label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Fecha Inicial</label>
            <DIV class="border border-success rounded mt-3 pt-2 pb-2 pr-2 pl-2 mb-2" id="referencialHeight">               
              <INPUT type="date" class="form-control" id="fechaInicial" disabled></INPUT>
            </DIV>

          </DIV>

           <DIV class="col-xs-12 col-md-4">
            
            <label class="label-control position-absolute pr-1 ml-2 pl-1" style="background-color: white; color: #1D8348">Fecha Final</label>
            <DIV class="border border-success rounded mt-3 pt-2 pb-2 pr-2 pl-2 mb-2">               
              <INPUT type="date" class="form-control" id="fechaFinal" disabled></INPUT>
              <STYLE>
                .form-control{
                  border: none;
                  font-size: 18px;
                  color:green;
                  box-shadow: none;
                  
                }
                .btn-success{
                  color:white;


                }


              </STYLE>
            </DIV>

          </DIV>
           <DIV class="col-xs-12 col-md-4">
              <INPUT type="submit" class="form-control btn btn-success mt-3" id="btn-buscar" disabled value="Buscar">
           </DIV>

        </DIV>

      </FORM>
    </DIV>  
    <div class="container border mt-4 shadow pb-3 mb-5" id="parametros" style="background-color: white">
      <DIV class=" row encabezado_parametros">
        <H3 class="ml-2 ">Resultados</h3>
      </DIV>
      <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-expanded="true">Reportes</a>
        </li>
        <li class="nav-item pestana">
          <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" >Visualización de datos</a>
        </li>
      </ul>
      <div class="tab-content border mb-0 pb-0" id="myTabContent">
        <div class="tab-pane fade show active bm-0 pb-0" id="tab1" role="tabpanel" aria-labelledby="1-tab">
          <div class="tab-pane-header mb-0 pb-0" style="height: 500px; overflow-y: scroll; background-color: white; padding: 0">
           <table class="table mb-0 pb-0" style="background-color: white; width: 100%"><thead class="thead-dark" id="encabezado_tabla">
              <tr >
                <th>Tipo de Producto</th>
                <th>Mercado</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Tamaño</th>
                <th>Unidad de venta</th>
                <th>Moneda</th>
                <th>Precio menor</th>
                <th>Precio menor</th>
              </tr></thead>
              <tbody id="tablaResultados">
              <tr class="text-center">
                <td>0 valores encontrados</td>
              </tr>
              </tbody>       
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="2-tab" id="tab-pane">
          <div class="tab-pane-header pb-0 mb-0"  style="background-color: white; overflow-x: scroll; overflow-y: scroll;">
            <form id="parametros_grafica">
            <div class="row" id="parametros_grafica">
              <DIV class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4" id="div_intervalos">            
                  <label class="label-control position-absolute pr-1 ml-2 pl-1" style=" background-color: white; color: #1D8348">Intervalos</label>
                    <DIV class="border border-success rounded mt-3 pt-2 pr-2 pl-2 ">               
                      <SELECT class="form-control mb-2" id="select_intervalo" style="background-color: white">
                      <OPTION value="semana">Semana</OPTION>
                      <OPTION value="mes" selected>Mes</OPTION>
                      <OPTION value="trimestre">Trimestre</OPTION>
                      <OPTION value="anio">Año</OPTION>
                      </SELECT>
                    </DIV>
              </DIV> 
               <DIV class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">            
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
              <DIV class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4" id="div_leyenda">
                <label class="label-control position-absolute pr-1 ml-2 pl-1" style=" background-color: white; color: #1D8348">Leyenda</label>
                    <DIV class="border border-success rounded mt-3 pt-3 pb-2 pr-2 pl-2 mb-2">               
                     <label class="checkbox-inline ml-4 ">
                        <input type="checkbox" checked id="checkbox_leyenda">&nbsp&nbspMostrar Leyenda
                      </label>
                    </DIV>
              </DIV> 
            </div>
          </form>
            <div class="row pb-0 mb-0"  style=" width: 100%">
              <div id="plot" class="ml-1"></div>
            </div>

          </div>          
        </div>    
      </div>
    </div>
    

    <div class="modal" tabindex="-1" role="dialog" id="modal1">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Precio en cada punto de venta</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn_cerrarModal">  
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body" id="modal_cuerpo" style="overflow-x: scroll;">
                  
                </div>
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
            </div>
          </div>
      </div>
      <DIV id="salidaErrores">
      </DIV>
    
  </body>
</html>