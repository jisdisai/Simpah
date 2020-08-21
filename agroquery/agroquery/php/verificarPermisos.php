<?php
	include("conexion.php");
	if(isset($_POST['idUsuario'])){
		$con = new conexion();
		$sql = "SELECT tbl_usuario.administrador FROM tbl_usuario WHERE tbl_usuario.id = ".$_POST['idUsuario'];
		$resultado=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultado)==1){
			$registro=$con->obtenerFila($resultado);
			if(strcmp($registro['administrador'], '1')==0){
				echo("location.href='cuenta.php';");
			}
			else{
				echo("$(\"#errorPermisos\").show();");
			}
		}
		else{
			echo("alert(\"Error al consultar\");");
		}
	}
	else{
		echo("alert(\"Error al recibir los datos\");");
	}
?>