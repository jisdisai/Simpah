<?php
	include("conexion.php");

	if(isset($_POST['listaAdmins']) && isset($_POST['idUsuario'])){
		$con=new conexion();
		$admins=explode(",", $_POST['listaAdmins']);
		for($i=0; $i<sizeof($admins);$i++){
			$sql="UPDATE tbl_usuario SET administrador=".explode("-",$admins[$i])[1]." WHERE tbl_usuario.id=".explode("-",$admins[$i])[0];
			$resultado=$con->ejecutarSql($sql);
			//echo("alert(\"".$sql."\");");
		}
		$sql="SELECT tbl_usuario.administrador FROM tbl_usuario WHERE tbl_usuario.id=".$_POST['idUsuario'];
		$resultado=$con->ejecutarSql($sql);
		$registro=$con->obtenerFila($resultado);
		if(strcmp($registro['administrador'], "0")==0){
			//echo("location.href:'../main.php';");
			echo("window.location.href=\"main.php\";");
		}
		else{
			echo("location.reload();");		
		}
		

	}
	else{
		echo("alert(\"Error en el envío de datos\");");
	}
?>