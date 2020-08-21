<?php
	include("../conexion.php");
	$con=new Conexion();
	$sql="SELECT tbl_tipo_producto.name_tipo_producto, tbl_tipo_producto.id from tbl_tipo_producto";
	$salida="";
	$resultadoSql=$con->ejecutarSql($sql);
	if($con->cantidadRegistros($resultadoSql)>0){
		$salida=$salida."$('#select_tipoProducto').empty();$('#select_mercado').empty();";
		
		for($i=0; $i<$con->cantidadRegistros($resultadoSql);$i++){
			$registro=$con->obtenerFila($resultadoSql);
			if(strcmp($registro['name_tipo_producto'], "GBMN")!=0){
				$salida=$salida."$('#select_tipoProducto').append(\"<OPTION value='".$registro['id']."'>".$registro['name_tipo_producto']."</OPTION>\");";
			}
			
		}
		//echo($salida);
		$sql="SELECT nombre_mercado, id FROM tbl_mercado";
		$resultadoSql=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultadoSql)>0){
			//$salida=$salida."$('#select_mercado').prepend(\"<OPTION value='default'>Todos</OPTION>\");";
			for($i=0; $i<$con->cantidadRegistros($resultadoSql);$i++){
				$registro=$con->obtenerFila($resultadoSql);
				$salida=$salida."$('#select_mercado').append(\"<OPTION value='".$registro['id']."' >".$registro['nombre_mercado']."</OPTION>\");";
			}
		
		}
		echo(utf8_encode($salida));
	}
	else{
		echo("Error");
	}

?>