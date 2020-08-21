<?php
	include("conexion.php");
	if(isset($_POST['usuario'])){
		$con=new Conexion();

		$sql="SELECT tbl_usuario.tbl_cuenta_id as cuenta FROM tbl_usuario WHERE tbl_usuario.id=".$_POST['usuario'];
		$resultado=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultado)==1){

			$registro=$con->obtenerFila($resultado);
			$cuenta=$registro['cuenta'];

			$sql="DELETE FROM tbl_usuario WHERE tbl_usuario.id=".$_POST['usuario'];
			$resultado=$con->ejecutarSql($sql);
			$sql="DELETE FROM tbl_cuenta WHERE tbl_cuenta.id=".$cuenta;
			$resultado=$con->ejecutarSql($sql);
			session_start();
			session_destroy();
			echo('location.reload();');
		}
		else{
			echo("alert(\"Error al ejecutar la acción\");");
		}
		
	}
	else{
		echo("alert(\"Error en el envío de datos\");");
	}
?>