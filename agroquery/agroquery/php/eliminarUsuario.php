<?php
	include("conexion.php");
	if(isset($_POST['usuario'])){
		$con=new Conexion();
		$sql="SELECT COUNT(tbl_usuario.id) as cantidad FROM tbl_usuario WHERE tbl_usuario.tbl_cuenta_id = (SELECT tbl_usuario.tbl_cuenta_id FROM tbl_usuario WHERE tbl_usuario.id = ".$_POST['usuario']." )";
		$resultado=$con->ejecutarSql($sql);
		$registro=$con->obtenerFila($resultado);
		if(intval($registro['cantidad'])>1){
			$sql="DELETE FROM tbl_usuario WHERE tbl_usuario.id =".$_POST['usuario'];
			$con->ejecutarSql($sql);
			echo("location.reload();");
		}
		else{
			$salida="";
			$salida=$salida."$(\"#btn_confirmar_eliminar\").attr(\"name\",\"eliminar-usr-".$_POST['usuario']."\");";
			$salida=$salida."$(\"#confirmarEliminar\").show();";
			echo($salida);
		}
	}
	else{
		echo("alert(\"Error en el envío de datos\");");
	}
?>