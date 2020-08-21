<?php
	include("../conexion.php");

	if( isset($_POST['nombreProducto']) && isset($_POST['tamanio']) && isset($_POST['unidad']) && isset($_POST['limitePrecio']) && isset($_POST['intervalo']) && isset($_POST['fechaInicial']) && isset($_POST['fechaFinal'])){
		
		//echo("$(\"#salidaErrores\").append(\"Actualizar grafica\");");

		$nombreProducto=$_POST['nombreProducto'];
		$unidad = $_POST['unidad'];
		$tamanio = $_POST['tamanio'];
		$limitePrecio = $_POST['limitePrecio'];
		$intervalo = $_POST['intervalo'];

		$data="var data1=[comodin];";
		$con = new conexion();


		$sql="SELECT DISTINCT(tbl_rango_precios.tbl_mercado_id) AS mercado_id FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_tamanio ON tbl_producto.tbl_tamanio_id = tbl_tamanio.id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id WHERE (tbl_producto.nombre_producto= \"".$nombreProducto."\") AND (tbl_tamanio.nombre_tamanio= \"".$tamanio."\") AND (tbl_unidad_venta.nombre_unidad=\"".$unidad."\")";
		$resultado=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultado)==1){
			$data="var data1=[{x: [''], y: [0], name: 'Mercados:', mode: 'markers', type: 'scatter'},comodin];";
		}

		$sql="SELECT DISTINCT(tbl_rango_precios.tbl_mercado_id) AS mercado_id, tbl_producto.id as producto_id, tbl_unidad_venta.id as unidad_id FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_tamanio ON tbl_producto.tbl_tamanio_id = tbl_tamanio.id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id WHERE (tbl_producto.nombre_producto= \"".$nombreProducto."\") AND (tbl_tamanio.nombre_tamanio= \"".$tamanio."\") AND (tbl_unidad_venta.nombre_unidad=\"".$unidad."\")";

		//echo("$(\"#salidaErrores\").append(\"".utf8_decode($sql)."\");");
		
		$resultadoSql=$con->ejecutarSql($sql);
		//**********************************************echo("$(\"#salidaErrores\").append(\"".utf8_decode($sql)."\");");
		if($con->cantidadRegistros($resultadoSql)>0){
			for($i=0; $i<$con->cantidadRegistros($resultadoSql); $i++){
				$registro=$con->obtenerFila($resultadoSql);

				$mercado_id = $registro['mercado_id'];
				$producto_id = $registro['producto_id'];
				$unidad_id = $registro['unidad_id'];

				$sql2="SELECT AVG(tbl_rango_precios.Precio_bajo) as precio, tbl_mercado.nombre_mercado as mercado, tbl_rango_precios.Fecha as fecha FROM tbl_rango_precios INNER JOIN tbl_mercado ON tbl_rango_precios.tbl_mercado_id = tbl_mercado.id INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_tamanio ON tbl_producto.tbl_tamanio_id = tbl_tamanio.id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id WHERE (tbl_rango_precios.tbl_producto_id =".$producto_id.") AND (tbl_rango_precios.tbl_unidad_venta_id = ".$unidad_id.") AND (tbl_rango_precios.tbl_mercado_id = ".$mercado_id.")";

				if(strcmp($_POST['fechaInicial'], '')!=0 && strcmp($_POST['fechaFinal'], '')==0){
					$sql2=$sql2."  AND (tbl_rango_precios.fecha>'".$_POST['fechaInicial']."')";
				}
				elseif (strcmp($_POST['fechaInicial'], '')==0 && strcmp($_POST['fechaFinal'], '')!=0) {
					$sql2=$sql2."  AND (tbl_rango_precios.fecha<'".$_POST['fechaFinal']."')";
				}
				elseif (strcmp($_POST['fechaInicial'], '')!=0 && strcmp($_POST['fechaFinal'], '')!=0) {
					$sql2=$sql2." AND (tbl_rango_precios.fecha BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."')";
				}

				$sql2=$sql2." GROUP BY tbl_producto.id, tbl_tamanio.id, tbl_unidad_venta.id, intervalo(tbl_rango_precios.fecha) ORDER BY tbl_rango_precios.Fecha ASC";

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

				if(strcmp("precioAlto", $_POST['limitePrecio'])==0){
					$sql2=str_replace("Precio_bajo", "Precio_alto", $sql2);
				}

				
				$resultadoSql2=$con->ejecutarSql($sql2);
				$resultadoSql2=$con->ejecutarSql(utf8_encode($sql2));
				$coordenadasX="x: [comodin],";
				$coordenadasY="y: [comodin],";

				if($con->cantidadRegistros($resultadoSql2)>0){

					for($j=0; $j<$con->cantidadRegistros($resultadoSql2); $j++){

						$registro2=$con->obtenerFila($resultadoSql2);						
						$coordenadasX=str_replace("comodin", "'".$registro2['fecha']."',comodin", $coordenadasX);
						$coordenadasY=str_replace("comodin", $registro2['precio'].",comodin", $coordenadasY);

					}

					$coordenadasX=str_replace(",comodin", "", $coordenadasX);
					$coordenadasY=str_replace(",comodin", "", $coordenadasY);

					$data=str_replace("comodin", "{ ".$coordenadasX.$coordenadasY."type:'scatter',name: '".utf8_encode($registro2['mercado'])."'},comodin", $data);
					
				}
				
			}
			$data=str_replace(",comodin", "", $data);
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
			$salida=$data."Plotly.newPlot('modal_cuerpo', data1, layout);$(\"#modal1\").fadeIn();";
			echo($salida);
		}
		else{
			echo("error en la consulta ".utf8_encode($slq1)."<br>");
		}
			//echo(utf8_encode($salida));
	}	
	else{
		echo("error en las variables enviadas");
	}
?>