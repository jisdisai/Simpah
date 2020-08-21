<?php
	include("conexion.php");
	if(isset($_POST['correo']) && isset($_POST['cuenta'])){
		$con = new Conexion();
		$sql="UPDATE tbl_cuenta SET tbl_cuenta.correo_cuenta = '".$_POST['correo']."' WHERE tbl_cuenta.id =".$_POST['cuenta'];
		$resultado=$con->ejecutarSql($sql);
		echo("location.reload();");
	}
	else{
		echo("alert(\"Error en el envío de datos\");");
	}
?>