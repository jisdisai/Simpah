<?php 

	include ("../class/class-conexion.php");
	include ("../class/class-usuario.php");	
		
	if (isset($_POST['accion'])) {
		$conexion=new Conexion();
		switch ($_POST["accion"]) {
			case 'iniciar-sesion':
				$nombre_usuario=$_POST["txt-Usuario"];
				$password=$_POST["txt-Password"];
	
				//$password = hash('sha512',$password); 		
				$respuesta = Usuario::verificarUsuario($conexion,$nombre_usuario,$password);
				echo $respuesta;
				
				break;
			
			default:
				# code...
				break;
		}
    $conexion->cerrar();
	$conexion = null;
	
  }


?>