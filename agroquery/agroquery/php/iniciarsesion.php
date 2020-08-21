<?php
	include("conexion.php");
	if(isset($_POST['usuario'])){
		//echo("alert(\"Inicias sesión como ".$_POST['usuario']."\");");
		$con = new Conexion();
		$sql="SELECT * FROM tbl_usuario WHERE tbl_usuario.id=".$_POST['usuario'];
		$resultado=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultado)==1){			
			$registro=$con->obtenerFila($resultado);
			if(strcmp($registro['activo'], '1')==0){
				session_start();
				if(!empty($_SESSION)){
					if(strcmp($_SESSION['usuario'], $registro['nombre_usuario'])==0){
						echo("location.href='main.php';");
					}
					else{
						echo("$(\"#contenedor_login\").addClass(\"d-none\");$(\"#contenedor_error\").removeClass(\"d-none\");$(\"#contenedor_mu\").addClass(\"d-none\");");
					}
				}
				else{
					echo("$(\"#contenedor_login\").addClass(\"d-none\");$(\"#contenedor_error\").removeClass(\"d-none\");$(\"#contenedor_mu\").addClass(\"d-none\");");
				}
				

			}
			else{
				session_start();
				$_SESSION['usuario']=$registro['nombre_usuario'];
				$_SESSION['idUsuario']=$registro['id'];		
				$sql="UPDATE tbl_usuario SET tbl_usuario.activo = 1 WHERE tbl_usuario.id =".$_POST['usuario'];
				$resultado=$con->ejecutarSql($sql);
				echo("location.href='main.php';");
			}			

		}
		else{

		}
	}
	else{
		echo("alert(\"Error al iniciar sesión\");");
	}
?>