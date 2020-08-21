<?php
	include('../conexion.php');

	if(isset($_POST['productos']) && isset($_POST['mercado']) && isset($_POST['tipoProducto']) && isset($_POST['fechaInicial']) && isset($_POST['fechaFinal'])){
		$con= new Conexion();
		$salida="";
		$condicionProducto="tbl_rango_precios.tbl_producto_id IN (comodin)";
		$condicionUnidad="tbl_rango_precios.tbl_unidad_venta_id IN (comodin)";
		$pid = array();
		$uid = array();
		$pus = explode(",",$_POST['productos']);

		if(strcmp($_POST['productos'], 'default')!=0){
			for($i=0; $i<count($pus); $i++){
				array_push($pid,explode("-",$pus[$i])[0]);
				array_push($uid,explode("-",$pus[$i])[1]);
			}
		}

		for($i=0; $i<count($pid); $i++){
			$condicionProducto=str_replace("comodin", $pid[$i].",comodin", $condicionProducto);
			$condicionUnidad=str_replace("comodin", $uid[$i].",comodin", $condicionUnidad);
		}

		$condicionProducto=str_replace(",comodin", "", $condicionProducto);
		$condicionUnidad=str_replace(",comodin", "", $condicionUnidad);

		$sql="SELECT tbl_tipo_producto.name_tipo_producto as tipoProducto, tbl_mercado.nombre_mercado as mercado, tbl_unidad_venta.nombre_unidad as unidad, tbl_moneda.nombre_moneda as moneda, tbl_tamanio.nombre_tamanio as tamanio, tbl_rango_precios.Fecha, tbl_producto.nombre_producto as producto, tbl_rango_precios.Precio_bajo as precioBajo, tbl_rango_precios.Precio_alto as precioAlto FROM tbl_rango_precios INNER JOIN tbl_producto on tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_tamanio ON tbl_producto.tbl_tamanio_id = tbl_tamanio.id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id INNER JOIN tbl_mercado ON tbl_rango_precios.tbl_mercado_id = tbl_mercado.id INNER JOIN tbl_moneda ON tbl_rango_precios.tbl_moneda_id = tbl_moneda.id INNER JOIN tbl_tipo_producto ON tbl_producto.tbl_tipo_producto_id = tbl_tipo_producto.id WHERE (tbl_rango_precios.tbl_mercado_id=".$_POST['mercado'].") AND (tbl_producto.tbl_tipo_producto_id = ".$_POST['tipoProducto'].") AND ".$condicionProducto." AND ".$condicionUnidad;


		if(strcmp($_POST['fechaInicial'], '')!=0 && strcmp($_POST['fechaFinal'], '')==0){
			$sql=$sql."  AND (tbl_rango_precios.fecha>'".$_POST['fechaInicial']."')";
		}
		elseif (strcmp($_POST['fechaInicial'], '')==0 && strcmp($_POST['fechaFinal'], '')!=0) {
			$sql=$sql."  AND (tbl_rango_precios.fecha<'".$_POST['fechaFinal']."')";
		}
		elseif (strcmp($_POST['fechaInicial'], '')!=0 && strcmp($_POST['fechaFinal'], '')!=0) {
			$sql=$sql." AND (tbl_rango_precios.fecha BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."')";
		}

		//$sql=$sql." AND ".$condicionProducto." AND ".$condicionUnidad;

		if(strcmp($_POST['productos'], 'default')==0){
			$sql=str_replace(" AND ".$condicionProducto." AND ".$condicionUnidad, "", $sql);
		}
		
		$resultado=$con->ejecutarSql($sql);
		
		if($con->cantidadRegistros($resultado)>0){

			$salida=$salida."$(\"#tablaResultados\").empty();";			
			for($i=0; $i<$con->cantidadRegistros($resultado);$i++){
				
				$registro=$con->obtenerFila($resultado);
				$salida=$salida.utf8_encode("$(\"#tablaResultados\").append(\"<tr scope='row'><td>".$registro['tipoProducto']."</td><td>".$registro['mercado']."</td><td>".$registro['Fecha']."</td><td>".$registro['producto']."</td><td>".$registro['tamanio']."</td><td>".$registro['unidad']."</td><td>".$registro['moneda']."</td><td>".$registro['precioBajo']."</td><td>".$registro['precioAlto']."</td></tr>\");");
					//echo("$(\"#salidaErrores\").append(\"".utf8_encode($registro['producto'])."\");");
			}
			echo(($salida));
			
			
		}
		else{
			$salida="$(\"#tablaResultados\").empty();";	
			$salida=$salida.utf8_encode("$(\"#tablaResultados\").append(\"<tr scope='row'><td>Se encontraron 0 resultados</td></tr>\");");
			echo($salida);
		}


	}
	else {
		$salida="$(\"#tablaResultados\").empty();";	
			$salida=$salida.utf8_encode("$(\"#tablaResultados\").append(\"<tr scope='row'><td>Se encontraron 0 resultados</td></tr>\");");
			echo($salida);
	}
?>