<?php
	include("../conexion.php");
	$con=new Conexion();
	$salida="";
	$data="data=[comodin];";
	if( (isset($_POST['id_tipoProducto'])) && (isset($_POST["id_mercado"])) ){
		
		$tipoProducto=$_POST["id_tipoProducto"];
		$mercado=$_POST["id_mercado"];
		$sql="SELECT tbl_producto.nombre_producto AS nombre, tbl_tamanio.nombre_tamanio as tamanio, tbl_unidad_venta.nombre_unidad as unidad FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id INNER JOIN tbl_tamanio ON tbl_producto.tbl_tamanio_id = tbl_tamanio.id WHERE (tbl_rango_precios.tbl_mercado_id = ".$mercado.") AND (tbl_producto.tbl_tipo_producto_id = ".$tipoProducto.") GROUP BY tbl_producto.id, tbl_rango_precios.tbl_unidad_venta_id";
		$resultadoSql=$con->ejecutarSql($sql);

		if($con->cantidadRegistros($resultadoSql)>0){
			for($i=0; $i<$con->cantidadRegistros($resultadoSql);$i++){
				
				$registro=$con->obtenerFila($resultadoSql);
				$sql2="SELECT tbl_producto.nombre_producto as nombre, tbl_tamanio.nombre_tamanio as tamanio, tbl_unidad_venta.nombre_unidad as unidad, YEAR (tbl_rango_precios.Fecha) as anio, AVG(tbl_rango_precios.Precio_bajo) as precioBajo FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_tamanio ON tbl_tamanio.id=tbl_producto.tbl_tamanio_id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id WHERE (tbl_producto.tbl_tipo_producto_id=".$tipoProducto.") AND (tbl_rango_precios.tbl_mercado_id=".$mercado.") AND (tbl_producto.nombre_producto=\"".$registro['nombre']."\") AND (tbl_tamanio.nombre_tamanio=\"".$registro['tamanio']."\") AND (tbl_unidad_venta.nombre_unidad=\"".$registro['unidad']."\") GROUP BY YEAR(tbl_rango_precios.Fecha), tbl_rango_precios.tbl_producto_id, tbl_rango_precios.tbl_unidad_venta_id";


				
				$resultadoSql2=$con->ejecutarSql($sql2);
				
				if($con->cantidadRegistros($resultadoSql2)>0){

					$xy=0;
					$x=0;
					$y=0;
					$x_cuadrado=0;
					$cuadrado_x=0;
					$n=0;

					$xs="";
					for($j=0; $j<$con->cantidadRegistros($resultadoSql2); $j++){

						$registro2=$con->obtenerFila($resultadoSql2);
						$xy=$xy+(floatval($registro2["anio"])*floatval($registro2["precioBajo"]));
						$x=$x+floatval($registro2["anio"]);
						$y=$y+floatval($registro2["precioBajo"]);
						$xs=$xs.$registro2['precioBajo'].";";
						$x_cuadrado=$x_cuadrado+pow(floatval($registro2['anio']),2);
						$n=$n+1;
						
					}
						$cuadrado_x=pow($x,2);
						
						$x_promedio=$x/$n;
						$y_promedio=$y/$n;

						if( (($n*$x_cuadrado) - $cuadrado_x)!=0){
							
						

							$m = ( ( $n*($xy) ) - ($x*$y) )/( ($n*$x_cuadrado) - $cuadrado_x );
							$b = $y_promedio - $m*$x_promedio;

						
						
							$anioactual=intval(date("Y"));
							$salida="var trace".$i." = {";
							$salida=$salida." x: ['".($anioactual+1)."', '".($anioactual+2)."', '".($anioactual+3)."', '".($anioactual+4)."' ],";
							$salida=$salida." y: [ ".( $b+($m*($anioactual+1)) ).", ".( $b+($m*($anioactual+2)) ).", ".( $b+($m*($anioactual+3)) ).", ".( $b+ ($m*($anioactual+4)) )."],";
							$salida=$salida."type: 'scatter',";
							$salida=$salida."name: '".$registro['nombre']." [".$registro['tamanio']."/".$registro['unidad']."]'};";
							echo(utf8_encode($salida));

							//echo(utf8_encode($registro['nombre']."-".$registro['unidad']."-".$registro["tamanio"].": M:".$m.", B: ".$b."<br>"));
							$data=str_replace("comodin", "trace".$i.", comodin", $data);
						}
				}
			
			}
			$data=str_replace(", comodin]", "]", $data);
			$salida=$data;
			$salida=str_replace("comodin", "", $data);
			$salida=$salida."Plotly.newPlot('plot', data);";
			echo($salida);
			
		}
		else{
			echo("$(\"#plot\").html(<CENTER><H1 style='color:red'>¡No hay registro de venta de estos productos en el Lugar de venta Seleccionado!</H1></CENTER>)");
		}
	}
?>