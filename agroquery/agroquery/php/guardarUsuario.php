<?php
	include("conexion.php");
	if(isset($_POST['nombreUsuario']) && isset($_POST['cuenta'])){
		$con=new Conexion();
		$sql="INSERT INTO tbl_usuario (`nombre_usuario`,`tbl_cuenta_id`,`administrador`,`activo`) VALUES ('".$_POST['nombreUsuario']."',".$_POST['cuenta'].",0,0)";
		$resultado=$con->ejecutarSql($sql);
		echo("location.reload();");

	}
	else{
		echo("alert(\"Error en el envío de datos\");");
	}
?>