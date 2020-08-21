<?php
	include("conexion.php");
	if(isset($_POST['tipoPlan']) && isset($_POST['cuenta'])){
		$con = new Conexion();
		$sql="UPDATE tbl_cuenta set tbl_cuenta.tbl_tipo_cuenta_id = (SELECT tbl_tipo_cuenta.id FROM tbl_tipo_cuenta WHERE tbl_tipo_cuenta.nombre_tipo_cuenta LIKE '".$_POST['tipoPlan']."' ) WHERE tbl_cuenta.id = '".$_POST['cuenta']."'";
		$resultado=$con->ejecutarSql($sql);
		echo("location.reload();");
	}
	else{
		echo("alert(\"Error en el envío de datos\");");
	}
?>