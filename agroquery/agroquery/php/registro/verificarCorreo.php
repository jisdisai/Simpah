<?php
	include("../conexion.php");
	$con=new Conexion();
	if(isset($_POST['correo'])){
		if(strcmp($_POST["correo"], "")!=0){
			$sql=("SELECT COUNT(tbl_cuenta.id) as cantidad FROM tbl_cuenta WHERE tbl_cuenta.correo_cuenta LIKE ('".$_POST['correo']."')");
			$resultado=$con->ejecutarSql($sql);
			$registro=$con->obtenerFila($resultado);
			if(intval($registro['cantidad'])>0){
				echo(utf8_encode("$(\"#correoRepetido\").html(\"*Ya hay una cuenta asociada a este correo\");$(\"#correoRepetido\").show();errorCorreo=true;"));
			}
			else{
				echo("$(\"#correoRepetido\").hide();errorCorreo=false;");
			}
		}
		else{
			echo("$(\"#correoRepetido\").html(\"*Rellene este campo\");$(\"#correoRepetido\").show();errorCorreo=true;");
		}
	}
	else{
		echo("alert(\"Error al conectar con la Base de datos\");");
	}
?>