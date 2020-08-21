<?php
	include("conexion.php");
	if(isset($_POST['cuenta']) && isset($_POST['claveActual']) && isset($_POST['claveNueva']) && isset($_POST['claveRepetir'])){
		$salida=("$(\"#clave_actual\").removeClass(\"border-danger\");$(\"#errorClaveActual\").addClass(\"d-none\");");
		$salida=$salida."$(\"#errorClaveRepetir\").addClass(\"d-none\");$(\"#clave_nueva\").removeClass(\"border-danger\");$(\"#clave_repetir\").removeClass(\"border-danger\");";
		$salida=$salida."$(\"#errorClaveCorta\").addClass(\"d-none\");$(\"#clave_nueva\").removeClass(\"border-danger\");$(\"#clave_repetir\").removeClass(\"border-danger\");";

		echo($salida);
		$cuenta=$_POST['cuenta'];
		$claveActual=$_POST['claveActual'];
		$claveNueva=$_POST['claveNueva'];
		$claveRepetir=$_POST['claveRepetir'];
		$con = new Conexion();
		$sql="SELECT tbl_cuenta.password_cuenta FROM tbl_cuenta WHERE tbl_cuenta.id=".$cuenta;
		$resultado=$con->ejecutarSql($sql);
		$salida="";
		if($con->cantidadRegistros($resultado)==1){
			$registro=$con->obtenerFila($resultado);
			if(strcasecmp($claveActual, $registro['password_cuenta'])!=0){
				$salida="$(\"#errorClaveActual\").removeClass(\"d-none\");";
				$salida=$salida."$(\"#clave_actual\").addClass(\"border-danger\").val(\"\");";
				echo($salida);
			}
			else{
				if(strcmp($claveNueva, $claveRepetir)!=0){
					$salida="$(\"#errorClaveRepetir\").removeClass(\"d-none\");";	
					$salida=$salida."$(\"#clave_nueva\").addClass(\"border-danger\").val(\"\");";
					$salida=$salida."$(\"#clave_repetir\").addClass(\"border-danger\").val(\"\");";
					echo($salida);
				}
				else{
					if(strlen($claveNueva)<8){
						$salida="$(\"#errorClaveCorta\").removeClass(\"d-none\");";	
						$salida=$salida."$(\"#clave_nueva\").addClass(\"border-danger\").val(\"\");";
						$salida=$salida."$(\"#clave_repetir\").addClass(\"border-danger\").val(\"\");";
						echo($salida);
					}
					else{
						$sql="UPDATE tbl_cuenta SET tbl_cuenta.password_cuenta = '".$claveNueva."' WHERE tbl_cuenta.id =".$cuenta;
						$resultado=$con->ejecutarSql($sql);
						echo("location.reload();");
					}
				}
			}
		}
		else{
			echo("alert(\"Error al consultar la contraseña\");");
		}

	}
	else{
		echo("alert(\"Error en el envío de datos\");");
	}
?>