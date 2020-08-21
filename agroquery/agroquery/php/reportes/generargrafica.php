<?php
	include("../conexion.php");
	if(isset($_POST['productos']) && isset($_POST['mercado']) && isset($_POST['tipoProducto']) && isset($_POST['fechaInicial']) && isset($_POST['fechaFinal']) && isset($_POST['intervalo']) && isset($_POST['limitePrecio'])){
		$data="var data=[comodin];";
		$con = new Conexion();
		$pid = array();
		$uid = array();
		
		$pus = explode(",",$_POST['productos']);
		if(count($pus)==1 && strcmp($_POST['productos'], 'default')!=0 ){
			$data="var data=[{x: [''], y: [0], name: 'Las fechas mostradas son las <br>primeras dentro del intervalo', mode: 'markers', type: 'scatter'},comodin];";
		}
		//echo("var traceZ = {x: [''], y: [0], name: 'Las Proyecciones se generan a partir de la fecha actual', mode: 'markers', type: 'scatter'};");
		
		if(strcmp($_POST['productos'], 'default')!=0){
			for($i=0; $i<count($pus); $i++){
				array_push($pid,explode("-",$pus[$i])[0]);
				array_push($uid,explode("-",$pus[$i])[1]);
			}
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
		if(strcmp($_POST['productos'], 'default')==0){
			$sql=str_replace("AND ".$condicionProducto." AND ".$condicionUnidad, "", $sql);
		}



		$resultadoSql=$con->ejecutarSql($sql);

		if($con->cantidadRegistros($resultadoSql)>0){
			for($i=0; $i<$con->cantidadRegistros($resultadoSql);$i++){
				
				$registro=$con->obtenerFila($resultadoSql);
				$sql2="SELECT tbl_producto.nombre_producto as nombre, tbl_tamanio.nombre_tamanio as tamanio, tbl_unidad_venta.nombre_unidad as unidad, AVG(tbl_rango_precios.Precio_bajo) as precio, tbl_rango_precios.Fecha as fecha FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_tamanio ON tbl_tamanio.id=tbl_producto.tbl_tamanio_id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id WHERE (tbl_producto.tbl_tipo_producto_id=".$_POST['tipoProducto'].") AND (tbl_rango_precios.tbl_mercado_id=".$_POST['mercado'].") AND (tbl_producto.nombre_producto=\"".$registro['nombre']."\") AND (tbl_tamanio.nombre_tamanio=\"".$registro['tamanio']."\") AND (tbl_unidad_venta.nombre_unidad=\"".$registro['unidad']."\")";

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


				if(strcmp($_POST['intervalo'], "semana")==0){
					$sql2=str_replace("intervalo", "WEEK", $sql2);
					
				}
				elseif (strcmp($_POST['intervalo'], "mes")==0) {
					$sql2=str_replace("intervalo", "MONTH", $sql2);
					
				}
				elseif (strcmp($_POST['intervalo'], "trimestre")==0) {
					$sql2=str_replace("intervalo", "QUARTER", $sql2);
					
				}
				else{
					$sql2=str_replace("intervalo", "YEAR", $sql2);
					
				}

				if(strcmp("precioAlto", $_POST['limitePrecio'])==0){
					$sql2=str_replace("Precio_bajo", "Precio_alto", $sql2);
				}
				//echo("$(\"#salidaErrores\").append(\"".utf8_encode($sql2)."<br>\");");

				$resultadoSql2=$con->ejecutarSql(utf8_encode($sql2));
				$coordenadasX="x: [comodin],";
				$coordenadasY="y: [comodin],";
				//$salida=$salida."var trace".$i."={";

				for($j=0; $j<$con->cantidadRegistros($resultadoSql2); $j++){
					$registro2=$con->obtenerFila($resultadoSql2);
					$coordenadasX=str_replace("comodin", "'".$registro2['fecha']."',comodin", $coordenadasX);
					$coordenadasY=str_replace("comodin", $registro2['precio'].",comodin", $coordenadasY);				
				}
				$coordenadasX=str_replace(",comodin", "", $coordenadasX);
				$coordenadasY=str_replace(",comodin", "", $coordenadasY);
				$data=str_replace("comodin", "{ ".$coordenadasX.$coordenadasY."type:'scatter',name: \"".utf8_encode($registro['nombre'])."<br>[".utf8_encode($registro['tamanio'])."/".utf8_encode($registro['unidad'])."]\"},comodin", $data);
				//$salida=$salida.$coordenadasX.$coordenadasY."type: 'scatter',";
				//$salida=$salida.utf8_encode("name: '".$registro['nombre']." [".$registro['tamanio']."/".$registro['unidad']."]'};");		
				//$data=str_replace("comodin", "trace".$i.", comodin", $data);

			}
			$data=str_replace(",comodin", "", $data);
			//$data=str_replace(", comodin]", "]", $data);
			//$salida=$salida.$data."Plotly.newPlot('plot', data);";
			$data=$data."var layout={
				autosize:false,
				width:1000,
				height:500, 
				yaxis:{ 
					title:'Precios',
					automargin:true
				}
			};";
			$salida=$data."Plotly.newPlot('plot', data, layout);";
			echo(($salida));
			
		}
		else{
			echo("error");//echo("$(\"#plot\").html(<CENTER><H1 style='color:red'>¡No hay registro de venta de estos productos en el Lugar de venta Seleccionado!</H1></CENTER>)");
		}

		
	}
	
?>