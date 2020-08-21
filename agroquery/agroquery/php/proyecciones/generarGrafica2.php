<?php
	include("../conexion.php");
	include("timestampdiff.php");

	if( isset($_POST['nombreProducto']) && isset($_POST['tamanio']) && isset($_POST['unidad']) && isset($_POST['limitePrecio']) && isset($_POST['intervalo'])){
	
		$nombreProducto=$_POST['nombreProducto'];
		$unidad = $_POST['unidad'];
		$tamanio = $_POST['tamanio'];
		$limitePrecio = $_POST['limitePrecio'];
		$intervalo = $_POST['intervalo'];
		$fechaActual=new dateTime(date("Y-m-d"));
		$cantidadX=0;
		$data="data=[traceZ,comodin];";
		$salida="";
		echo("var traceZ = {x: [''], y: [0], name: 'Mercados:', mode: 'markers', type: 'scatter'};");
		$con = new conexion();

		$sql="SELECT DISTINCT(tbl_rango_precios.tbl_mercado_id) AS mercado_id, tbl_producto.id as producto_id, tbl_unidad_venta.id as unidad_id FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_tamanio ON tbl_producto.tbl_tamanio_id = tbl_tamanio.id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id WHERE (tbl_producto.nombre_producto= \"".$nombreProducto."\") AND (tbl_tamanio.nombre_tamanio= \"".$tamanio."\") AND (tbl_unidad_venta.nombre_unidad=\"".$unidad."\")";
		
		$resultadoSql=$con->ejecutarSql($sql);
		
		if($con->cantidadRegistros($resultadoSql)>0){
			//echo("alert(\"Llegamos aqui\");");
			for($i=0; $i<$con->cantidadRegistros($resultadoSql); $i++){
				$registro=$con->obtenerFila($resultadoSql);

				$mercado_id = $registro['mercado_id'];
				$producto_id = $registro['producto_id'];
				$unidad_id = $registro['unidad_id'];

				$sql2="SELECT AVG(tbl_rango_precios.Precio_bajo) as precio, tbl_mercado.nombre_mercado as mercado, TIMESTAMPDIFF(intervalo, '2017-01-01', tbl_rango_precios.fecha) as X FROM tbl_rango_precios INNER JOIN tbl_mercado ON tbl_rango_precios.tbl_mercado_id = tbl_mercado.id WHERE (tbl_rango_precios.tbl_producto_id =".$producto_id.") AND (tbl_rango_precios.tbl_unidad_venta_id = ".$unidad_id.") AND (tbl_rango_precios.tbl_mercado_id = ".$mercado_id.") GROUP BY TIMESTAMPDIFF(intervalo, '2017-01-01', tbl_rango_precios.fecha)";

				if(strcmp($_POST['intervalo'], "semana")==0 || strcmp($_POST['intervalo'], 'anio')==0){
					$sql2=str_replace("intervalo", "WEEK", $sql2);
					$cantidadX=52;//52 semanas en un año 
				}
				elseif (strcmp($_POST['intervalo'], "mes")==0) {
					$sql2=str_replace("intervalo", "MONTH", $sql2);
					$cantidadX=12;//12 meses en un año
				}
				elseif(strcmp($_POST['intervalo'], "trimestre")==0) {
					$sql2=str_replace("intervalo", "QUARTER", $sql2);

					$cantidadX=4;//4 trimestres en un año
				}
				if(strcmp("precioMaximo", $_POST['limitePrecio'])==0){
					$sql2=str_replace("Precio_bajo", "Precio_alto", $sql2);
				}

				//*******
				//echo("<br>".$sql2."<br>");
				//echo(utf8_encode($sql2));
				$resultadoSql2=$con->ejecutarSql($sql2);
				
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

					if( (($n*$x_cuadrado) - $cuadrado_x)!=0){
							
						$m = ( ( $n*($xy) ) - ($x*$y) )/( ($n*$x_cuadrado) - $cuadrado_x );
						$b = $y_promedio - $m*$x_promedio;
						//echo("<br>--Formula: ".$b." + ".$m."x ---<br>");

						$coordenadasX="x: [comodin],";
						$coordenadasY="y: [comodin],";

						$salida="var traceB".$i."={";
						
							
						for($h=0; $h<$cantidadX; $h++){
							if (strcmp($_POST['intervalo'], 'trimestre') == 0){
								$nuevoY=($b + ($m*( intval( $incrementoIntervalo->sumar(1 ,"quarter") ) )) );
								$coordenadasX=str_replace("comodin", "'".$incrementoIntervalo->obtenerMes()."(".$incrementoIntervalo->obtenerAnio().")',comodin", $coordenadasX);							
							}
							elseif (strcmp($_POST['intervalo'], 'mes') == 0){
								$nuevoY=($b + ($m*( intval( $incrementoIntervalo->sumar(1 ,"month") ) )) );
								$coordenadasX=str_replace("comodin", "'".$incrementoIntervalo->obtenerMes()."(".$incrementoIntervalo->obtenerAnio().")',comodin", $coordenadasX);
							}
							elseif (strcmp($_POST['intervalo'], 'semana') == 0 || strcmp($_POST['intervalo'], 'anio')==0){
								$nuevoY=($b + ($m*( intval( $incrementoIntervalo->sumar(1 ,"week") ) )) );
								$coordenadasX=str_replace("comodin", "'".$incrementoIntervalo->obtenerFecha()."',comodin", $coordenadasX);
																
							}

							$coordenadasY=str_replace("comodin", $nuevoY.",comodin", $coordenadasY);
						}						
						
						$coordenadasX=str_replace(",comodin", "", $coordenadasX);
						$coordenadasY=str_replace(",comodin", "", $coordenadasY);
						$salida=$salida.$coordenadasX.$coordenadasY."type: 'scatter',";
						$salida=$salida."name: '".$registro2['mercado']."'};";
						echo(utf8_encode($salida));//********************
						$data=str_replace("comodin", "traceB".$i.",comodin", $data);
					}
				}//fin if($con->cantidadRegistros($resultado2)>0)
				else{
					echo("error en la consulta ".utf8_encode($slq2)."<br>");
				}
			}//for($i=0; $i<$con->cantidadRegistros($resultadoSql); $i++)
			$data=str_replace(",comodin","",$data);
			$data=$data."var layout={
				autosize:false,
				width:1000,
				height:500, 
				yaxis:{ 
					title:'Precios',
					automargin:true
				}
			};";
			echo($data."Plotly.newPlot('modal_cuerpo', data, layout);$('#modal1').fadeIn();");

		}//fin ($con->cantidadRegistros($resultadoSql)>0)
		else{
			//echo("error en la consulta ".utf8_encode($slq)."<br>");
		}
			//echo(utf8_encode($salida));
	}	
	else{
		echo("error en las variables enviadas");
	}
?>