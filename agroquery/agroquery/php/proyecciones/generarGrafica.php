<?php
	include("../conexion.php");
	include("timestampdiff.php");

	if(isset($_POST['tipoProducto']) && isset($_POST['mercado']) && isset($_POST['intervalo']) && isset($_POST['limitePrecio']) && isset($_POST['productos'])){
		echo("$(\"#error\").hide();");
		echo("$(\"#contenedor_grafico\").empty();$(\"#contenedor_grafico\").html(\"<DIV id='plot' style='width: 100%'></DIV>\");");
		$salida="";
		$error=false;
		$data="data=[traceZ,comodin];";
		$con = new Conexion();
		$pid = array();
		$uid = array();
		$pus = explode(",",$_POST['productos']);
		$cantidadX=0;
		$fechaActual=new dateTime(date("Y-m-d"));
		echo("var traceZ = {x: [''], y: [0], name: 'Las Proyecciones se generan a partir de la fecha actual', mode: 'markers', type: 'scatter'};");

		for($i=0; $i<count($pus); $i++){
			array_push($pid,explode("-",$pus[$i])[0]);
			array_push($uid,explode("-",$pus[$i])[1]);
		}

		$condicionProducto="tbl_rango_precios.tbl_producto_id IN (comodin)";
		$condicionUnidad="tbl_rango_precios.tbl_unidad_venta_id IN (comodin)";

		for($i=0; $i<count($pid); $i++){
			$condicionProducto=str_replace("comodin", $pid[$i].",comodin", $condicionProducto);
			$condicionUnidad=str_replace("comodin", $uid[$i].",comodin", $condicionUnidad);
		}

		$condicionProducto=str_replace(",comodin", "", $condicionProducto);
		$condicionUnidad=str_replace(",comodin", "", $condicionUnidad);

		$sql="SELECT tbl_producto.nombre_producto AS nombre, tbl_tamanio.nombre_tamanio as tamanio, tbl_unidad_venta.nombre_unidad as unidad FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id INNER JOIN tbl_tamanio ON tbl_producto.tbl_tamanio_id = tbl_tamanio.id WHERE (tbl_rango_precios.tbl_mercado_id = ".$_POST['mercado'].") AND (tbl_producto.tbl_tipo_producto_id = ".$_POST['tipoProducto'].") AND ".$condicionProducto." AND ".$condicionUnidad." GROUP BY tbl_producto.id, tbl_rango_precios.tbl_unidad_venta_id";

		$resultadoSql=$con->ejecutarSql($sql);

		if($con->cantidadRegistros($resultadoSql)>0){

			for($i=0; $i<$con->cantidadRegistros($resultadoSql);$i++){
				
				$registro=$con->obtenerFila($resultadoSql);
				$sql2="SELECT tbl_producto.nombre_producto as nombre, tbl_tamanio.nombre_tamanio as tamanio, tbl_unidad_venta.nombre_unidad as unidad, TIMESTAMPDIFF(intervalo, '2017-01-01', tbl_rango_precios.fecha) as X, AVG(tbl_rango_precios.Precio_bajo) as precio FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_tamanio ON tbl_tamanio.id=tbl_producto.tbl_tamanio_id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id WHERE (tbl_producto.tbl_tipo_producto_id=".$_POST['tipoProducto'].") AND (tbl_rango_precios.tbl_mercado_id=".$_POST['mercado'].") AND (tbl_producto.nombre_producto=\"".$registro['nombre']."\") AND (tbl_tamanio.nombre_tamanio=\"".$registro['tamanio']."\") AND (tbl_unidad_venta.nombre_unidad=\"".$registro['unidad']."\") GROUP BY TIMESTAMPDIFF(intervalo, '2017-01-01', tbl_rango_precios.fecha)";


				if(strcmp($_POST['intervalo'], "semana")==0){
					$sql2=str_replace("intervalo", "WEEK", $sql2);
					$cantidadX=52;//52 semanas en un año 
				}
				elseif (strcmp($_POST['intervalo'], "mes")==0) {
					$sql2=str_replace("intervalo", "MONTH", $sql2);
					$cantidadX=12;//12 meses en un año
				}
				elseif (strcmp($_POST['intervalo'], "trimestre")==0) {
					$sql2=str_replace("intervalo", "QUARTER", $sql2);
					$cantidadX=4;//4 trimestres en un año
				}
				else{
					$sql2=str_replace("intervalo", "YEAR", $sql2);
					$cantidadX=4;//4 años
				}

				if(strcmp("precioMaximo", $_POST['limitePrecio'])==0){
					$sql2=str_replace("Precio_bajo", "Precio_alto", $sql2);
				}
				
				$resultadoSql2=$con->ejecutarSql(utf8_encode($sql2));
				
				//echo("<br>***".utf8_encode($sql2)."***<br>");
				
				if($con->cantidadRegistros($resultadoSql2)>0){


					$xy=0;
					$x=0;
					$y=0;
					$x_cuadrado=0;
					$cuadrado_x=0;
					$n=0;
					$incrementoIntervalo = new timeStampDiff("2017-01-01");
					$xs="";

					for($j=0; $j<$con->cantidadRegistros($resultadoSql2); $j++){

						$registro2=$con->obtenerFila($resultadoSql2);
						$xy=$xy+(floatval($registro2["X"])*floatval($registro2["precio"]));
						$x=$x+floatval($registro2["X"]);
						$y=$y+floatval($registro2["precio"]);
						//$xs=$xs.$registro2['precio'].";";
						$x_cuadrado=$x_cuadrado+pow(floatval($registro2['X']),2);
						$n=$n+1;
						
					}
					
					$cuadrado_x=pow($x,2);					
					$x_promedio=$x/$n;
					$y_promedio=$y/$n;
					//echo("$(\"#salidaErrores\").html(\"".$data."\");");
					if( (($n*$x_cuadrado) - $cuadrado_x)!=0){
						
						$m = ( ( $n*($xy) ) - ($x*$y) )/( ($n*$x_cuadrado) - $cuadrado_x );
						$b = $y_promedio - $m*$x_promedio;
						//echo("<br>--Formula: ".$b." + ".$m."x ---<br>");

						$coordenadasX="x: [comodin],";
						$coordenadasY="y: [comodin],";

						$salida="var trace".$i."={";
						
							
						for($h=0; $h<$cantidadX; $h++){
							if(strcmp($_POST['intervalo'], 'anio')==0){								
								$nuevoY=($b + ($m*( intval( $incrementoIntervalo->sumar(1 ,"year") ) )) );
								$coordenadasX=str_replace("comodin", (intval(date("Y"))+1+$h).",comodin", $coordenadasX);
							}
							elseif (strcmp($_POST['intervalo'], 'trimestre') == 0){
								$nuevoY=($b + ($m*( intval( $incrementoIntervalo->sumar(1 ,"quarter") ) )) );
								$coordenadasX=str_replace("comodin", "'".$incrementoIntervalo->obtenerMes()."(".$incrementoIntervalo->obtenerAnio().")',comodin", $coordenadasX);							
							}
							elseif (strcmp($_POST['intervalo'], 'mes') == 0){
								$nuevoY=($b + ($m*( intval( $incrementoIntervalo->sumar(1 ,"month") ) )) );
								$coordenadasX=str_replace("comodin", "'".$incrementoIntervalo->obtenerMes()."(".$incrementoIntervalo->obtenerAnio().")',comodin", $coordenadasX);
							}
							elseif (strcmp($_POST['intervalo'], 'semana') == 0){
								$nuevoY=($b + ($m*( intval( $incrementoIntervalo->sumar(1 ,"week") ) )) );
								$coordenadasX=str_replace("comodin", "'".$incrementoIntervalo->obtenerFecha()."',comodin", $coordenadasX);
																
							}

							$coordenadasY=str_replace("comodin", $nuevoY.",comodin", $coordenadasY);
						}
					
					
							
							
						
						
						$coordenadasX=str_replace(",comodin", "", $coordenadasX);
						$coordenadasY=str_replace(",comodin", "", $coordenadasY);
						$salida=$salida.$coordenadasX.$coordenadasY."type: 'scatter',";
						$salida=$salida."name: \"".$registro['nombre']."<br>[".$registro['tamanio']."/".$registro['unidad']."]\"};";
						echo(utf8_encode($salida));//********************
						$data=str_replace("comodin", "trace".$i.",comodin", $data);
					}
					else{
						$error=true;
					
					}
				}
			
			}
			if($error){
				echo("$(\"#alerta\").hide();$(\"#error\").show();$(\"plot\").empty();");
			}
			
				$data=str_replace(",comodin]", "]", $data);
				$salida=$data;
				//$salida=str_replace("comodin", "", $data);
				$salida=$salida."var layout={
					autosize:false,
					width:1000,
					height:500, 
					yaxis:{ 
						title:'Precios',
						automargin:true
					}
				};";
				$salida=$salida."Plotly.newPlot('plot', data, layout);$('#alerta').hide();";
				echo(utf8_encode($salida));
			
			//**************************************
			
		}
		else{
			echo("$(\"#plot\").html(<CENTER><H1 style='color:red'>¡No hay registro de venta de estos productos en el Lugar de venta Seleccionado!</H1></CENTER>)");
		}

		
	}
	else{
		echo("alert(\"No hay datos suficientes\");");
	}
	
?>