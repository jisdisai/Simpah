<?php
	include("conexion.php");
	$salida="";
	$idCuenta="";
	if(isset($_POST['idUsuario'])){
		echo("uid=".$_POST['idUsuario'].";");
		$con = new Conexion();
		$sql="SELECT tbl_tarjeta_credito.nombre_pertenece as nombreTarjeta, tbl_tarjeta_credito.numero_tarjeta as numeroTarjeta, tbl_tarjeta_credito.vencimiento as fechaTarjeta, tbl_tarjeta_credito.id as tarjetaId, tbl_tarjeta_credito.codigo_seguridad as codidoTarjeta FROM tbl_tarjeta_credito INNER JOIN tbl_cuenta ON tbl_tarjeta_credito.cuenta_id = tbl_cuenta.id INNER JOIN tbl_usuario ON tbl_cuenta.id = tbl_usuario.tbl_cuenta_id WHERE tbl_usuario.id=".$_POST['idUsuario'];
		$resultado=$con->ejecutarSql($sql);
		if($con->cantidadRegistros($resultado)==1){
			$registro=$con->obtenerFila($resultado);
			//$salida=$salida."$(\"\").val();";
			$salida=$salida."$(\"#campo_nombreTarjeta\").val('".$registro['nombreTarjeta']."');";
			$salida=$salida."$(\"#campo_numeroTarjeta\").val('".$registro['numeroTarjeta']."');";
			$salida=$salida."$(\"#campo_vencimientoTarjeta\").val('".$registro['fechaTarjeta']."');";
			$salida=$salida."$(\"#campo_codigoTarjeta\").val('".$registro['codidoTarjeta']."');";
			$salida=$salida."tid='".$registro['tarjetaId']."';";
			echo($salida);

			$sql="SELECT tbl_cuenta.correo_cuenta as correo, tbl_cuenta.id as idCuenta FROM tbl_cuenta INNER JOIN tbl_usuario ON tbl_cuenta.id = tbl_usuario.tbl_cuenta_id WHERE tbl_usuario.id =".$_POST['idUsuario'];
			$resultado = $con->ejecutarSql($sql);
			if($con->cantidadRegistros($resultado)==1){
				$registro=$con->obtenerFila($resultado);
				$salida="$(\"#campo_correo\").val('".$registro['correo']."');";
				$idCuenta=$registro['idCuenta'];
				$salida=$salida."cid='".$idCuenta."';";
				echo($salida);

				$sql="SELECT COUNT(tbl_usuario.id) as cantidad FROM tbl_usuario WHERE tbl_usuario.tbl_cuenta_id=".$idCuenta;
				$resultado=$con->ejecutarSql($sql);
				$registro=$con->obtenerFila($resultado);
				echo("cue=".$registro['cantidad'].";");


				$sql="SELECT tbl_tipo_cuenta.cantidad_usuarios as cantidad FROM tbl_tipo_cuenta INNER JOIN tbl_cuenta ON tbl_tipo_cuenta.id = tbl_cuenta.tbl_tipo_cuenta_id WHERE tbl_cuenta.id=".$idCuenta;
				$resultado=$con->ejecutarSql($sql);
				$registro=$con->obtenerFila($resultado);
				echo("cup=".$registro['cantidad'].";");


				$sql="SELECT tbl_tipo_cuenta.nombre_tipo_cuenta as tipoCuenta, tbl_tipo_cuenta.id as idTipoCuenta FROM tbl_tipo_cuenta INNER JOIN tbl_cuenta ON tbl_tipo_cuenta.id = tbl_cuenta.tbl_tipo_cuenta_id INNER JOIN tbl_usuario ON tbl_cuenta.id = tbl_usuario.tbl_cuenta_id WHERE tbl_usuario.id =".$_POST['idUsuario'];
				$resultado=$con->ejecutarSql($sql);
				if($con->cantidadRegistros($resultado)==1){
					$registro=$con->obtenerFila($resultado);
					$salida="$(\"#".$registro['tipoCuenta']."\").addClass(\"planSeleccionado\");";
					$salida=$salida."$(\"#".$registro['tipoCuenta']." .card-header\").addClass(\"cardSeleccionado-header\");";
					$salida=$salida."$(\"#".$registro['tipoCuenta']." .card-footer\").addClass(\"cardSeleccionado-footer\");";
					$salida=$salida."tpid='".$registro['tipoCuenta']."';";
					echo($salida);


					$sql="SELECT * FROM tbl_usuario WHERE tbl_usuario.tbl_cuenta_id=".$idCuenta;
					$resultado=$con->ejecutarSql($sql);

					if($con->cantidadRegistros($resultado)>=1){

						$salida="$(\"#listaUsuarios\").empty();";
						$salida=$salida."$(\"#listaUsuarios\").append(\"<tr>";
						for($i=0; $i<$con->cantidadRegistros($resultado);$i++){
							$registro=$con->obtenerFila($resultado);
							$salida=$salida."<td><INPUT type='text' class='form-control usr_bloqueable' value='".$registro['nombre_usuario']."' disabled id='nombre-usr-".$registro['id']."'></td>";
							if(strcmp($registro['administrador'], '1')==0){
								$salida=$salida."<td class='text-center'><INPUT type='checkbox' class='form-control usr_bloqueable checkAdmin' checked disabled id='administrador-usr-".$registro['id']."'></td><td><span class='input-group-btn'>";
								//echo("alert(\"".$salida."\");");
							}
							else{
								$salida=$salida."<td class='text-center'><INPUT type='checkbox' class='form-control usr_bloqueable checkAdmin' disabled id='administrador-usr-".$registro['id']."'></td><td><span class='input-group-btn'>";
							}
							$salida=$salida."<button class='btn btn-danger form-control usr_bloqueable btn_eliminar_usr' id='eliminar-usr-".$registro['id']."' type='button' name='eliminar_usuario' disabled><i class='fa fa-trash-o mr-2' aria-hidden='true'></i>Eliminar</button>";
							$salida=$salida."</span></td></tr>";
						}
						$salida=$salida."<tr><td colspan='3'><BUTTON class='form-control btn-info usr_bloqueable' id='btn_agregarUsuario' disabled>+ Agregar Usuario</BUTTON></td></tr>\");";
						echo($salida);


						
					}
					else{
						echo ("alert(\"Error al obtener los usuarios\");");
					}
				}
				else{
					echo("alert(\"Error obteniendo el plan\");");
				}
			}
			else{
				echo("alert(\"Error obteniendo el correo del usuario\");");
			}
		}
		else{
			echo("alert(\"Error en la consulta\");");
		}
	}
	else{
		echo("alert(\"Error de envio de datos\")");
	}
?>

