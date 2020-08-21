<?php
	include("../conexion.php");
	$con=new Conexion();
	$salida="";
	if(isset($_POST["tipoProducto"]) && ((strcmp($_POST["tipoProducto"], "")!=0)) && (strcmp($_POST["tipoProducto"],"default")!=0)){
		$tipoProducto=$_POST["tipoProducto"];
		$sql="SELECT tbl_mercado.nombre_mercado, tbl_mercado.id FROM tbl_rango_precios INNER JOIN tbl_producto ON tbl_rango_precios.tbl_producto_id = tbl_producto.id INNER JOIN tbl_mercado ON tbl_rango_precios.tbl_mercado_id=tbl_mercado.id WHERE (tbl_producto.tbl_tipo_producto_id=".$tipoProducto.")  GROUP BY(tbl_mercado.id)";
		$resultadoSql=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultadoSql)>0){
			$salida=$salida."$(\"#select_mercado\").empty();";
			for($i=0; $i<$con->cantidadRegistros($resultadoSql);$i++){
				$registro=$con->obtenerFila($resultadoSql);
				$salida=$salida."$('#select_mercado').append(\"<OPTION value='".$registro['id']."'>".$registro['nombre_mercado']."</OPTION>\");";
			}
			echo(utf8_encode($salida));
		}
		else{
			echo("$(\"#select_mercado\").empty();");
		}	
	}
	else{
		echo("$(\"#select_mercado\").empty();");
	}
?>