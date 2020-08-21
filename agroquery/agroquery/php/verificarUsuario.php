<?php
	include("conexion.php");
	if(isset($_POST['email']) && isset($_POST['pass'])){
		//echo("alert(\"Se recibio: ".$_POST['email']." y ".$_POST['pass']."\")");
		$con = new Conexion();
		$salida="";
		
		$sql = "SELECT * FROM tbl_cuenta WHERE tbl_cuenta.correo_cuenta = '".$_POST['email']."' AND tbl_cuenta.password_cuenta='".$_POST['pass']."';";
		//$sql="SELECT * FROM tbl_cuenta WHERE tbl_cuenta.correo_cuenta = '".$_POST['email']."'";
		$resultado=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultado)==1){			
			$registro=$con->obtenerFila($resultado);			
			$id_cuenta=$registro['id'];
			$sql="SELECT * FROM tbl_usuario WHERE tbl_usuario.tbl_cuenta_id=".$id_cuenta;
			$resultado=$con->ejecutarSql($sql);

			if($con->cantidadRegistros($resultado)>1){
				//echo("alert('multiples usuarios');");
				$salida=$salida."$(\"#contenedor_login\").addClass(\"d-none\");";
				$salida=$salida."$(\"#slider\").empty();";

				for($i=0; $i<$con->cantidadRegistros($resultado); $i++){
					$registro=$con->obtenerFila($resultado);
					$salida=$salida."$(\"#slider\").append(\"";
					if($i==0){
						$salida=$salida."<div class='carousel-item active' name='".$registro['id']."'>";
					}
					else{
						$salida=$salida."<div class='carousel-item' name='".$registro['id']."'>";
					}					
      				$salida=$salida."<DIV class='card shadow border-0 w-50 mx-auto card-usuario' id='user-1' name='".$registro['id']."' >";
					$salida=$salida."<DIV class='card-body'>";
					$salida=$salida."<div class='features-icons-icon d-flex'>";
					$salida=$salida."<i class='fa fa-7x fa-user m-auto text-success' aria-hidden='true'></i></div></DIV>";								
					$salida=$salida."<DIV class='card-footer text-center bg-success text-light pb-4 pt-4'>".$registro['nombre_usuario']."</DIV></DIV></div>";
					$salida=$salida."\");";    					
				}
				$salida=$salida."$(\"#contenedor_mu\").removeClass(\"d-none\");";
				echo(utf8_encode($salida));
			}
			else{
				if($con->cantidadRegistros($resultado)==1){
					session_start();
					$registro=$con->obtenerFila($resultado);

					if(strcmp($registro['activo'], '1')!=0){						
						$_SESSION['usuario']=$registro['nombre_usuario'];
						$_SESSION['idUsuario']=$registro['id'];
						$sql="UPDATE tbl_usuario SET tbl_usuario.activo = 1 WHERE tbl_usuario.id =".$registro['id'];
						$resultado=$con->ejecutarSql($sql);
						echo("location.href='main.php';");
					}
					else{
						if(!empty($_SESSION)){
							if(strcmp($_SESSION['usuario'], $registro['nombre_usuario'])==0){
								echo("location.href='main.php';");
							}
							else{
								echo("$(\"#contenedor_login\").addClass(\"d-none\");$(\"#contenedor_error\").removeClass(\"d-none\");uuo=true;");
							}
						}
						else{
							echo("$(\"#contenedor_login\").addClass(\"d-none\");$(\"#contenedor_error\").removeClass(\"d-none\");uuo=true;");
						}
						
					}
					
				}
			}
			echo("$(\"#datosIncorrectos\").addClass(\"d-none\");");
		}
		else{
			echo("$(\"#datosIncorrectos\").removeClass(\"d-none\");");
		}
	}
	else{
		echo("alert(\"Error al recibir los datos\");");
	}
?>