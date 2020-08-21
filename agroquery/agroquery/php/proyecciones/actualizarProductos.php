<?php
	include("../conexion.php");
	$con=new Conexion();
	if(isset($_POST['tipoProducto']) && isset($_POST['mercado']) && (strcasecmp($_POST['mercado'], '')!=0) && (strcmp($_POST['mercado'],'default')!=0) ){
		$tipoProducto=$_POST['tipoProducto'];
		$mercado=$_POST['mercado'];
		$salida="";
		$sql="SELECT tbl_producto.nombre_producto AS nombre, tbl_producto.id as pid, tbl_tamanio.nombre_tamanio as tamanio, tbl_unidad_venta.nombre_unidad as unidad, tbl_unidad_venta.id as uid FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_unidad_venta ON tbl_rango_precios.tbl_unidad_venta_id = tbl_unidad_venta.id INNER JOIN tbl_tamanio ON tbl_producto.tbl_tamanio_id = tbl_tamanio.id WHERE (tbl_rango_precios.tbl_mercado_id = ".$mercado.") AND (tbl_producto.tbl_tipo_producto_id = ".$tipoProducto.") GROUP BY tbl_producto.id, tbl_rango_precios.tbl_unidad_venta_id";
		$resultado=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultado)!=0){
			$salida=$salida."$(\"#select_productos\").empty();";
			for($i=0; $i<$con->cantidadRegistros($resultado); $i++){
				$registro=$con->obtenerFila($resultado);
				$salida=$salida."$(\"#select_productos\").prepend(\"<OPTION value='".$registro['pid']."-".$registro['uid']."'>".$registro['nombre']." [".$registro['tamanio']." / ".$registro['unidad']."]</OPTION>\");";
			}

			echo(utf8_encode($salida));

		}
		else{
			echo("$(\"#select_productos\").empty();");
		}

	}
	else{
		//echo("alert('Error de envio de mercado y tipoProducto')");
	}
?>