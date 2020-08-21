<?php
	include("conexion.php");
	if(isset($_POST['tid']) && isset($_POST['nombreTarjeta']) && isset($_POST['numeroTarjeta']) && isset($_POST['codigoTarjeta']) && isset($_POST['fechaTarjeta'])){
		$con= new Conexion();
		$sql="UPDATE tbl_tarjeta_credito SET tbl_tarjeta_credito.codigo_seguridad='".$_POST['codigoTarjeta']."', tbl_tarjeta_credito.nombre_pertenece='".$_POST['nombreTarjeta']."', tbl_tarjeta_credito.numero_tarjeta='".$_POST['numeroTarjeta']."', tbl_tarjeta_credito.vencimiento='".$_POST['fechaTarjeta']."' WHERE tbl_tarjeta_credito.id=".$_POST['tid'];
		$resultado=$con->ejecutarSql($sql);
		echo("location.reload();");
	}
	else{
		echo("alert(\"Error en el envio de datos\");");
	}
?>