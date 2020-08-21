<?php
	include("conexion.php");
	if(isset($_POST['idUsuario'])){
		$con = new Conexion();
		
	}
	else{
		echo("alert(\"Error de envio de datos\")");
	}
?>