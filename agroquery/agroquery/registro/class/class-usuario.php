<?php

	class Usuario{

		private $id_persona_usuario;
		private $nombre_usuario;
		private $clave_usuario;

		public function __construct($id_persona_usuario=null,
					$nombre_usuario=null,
					$clave_usuario=null){
			$this->id_persona_usuario = $id_persona_usuario;
			$this->nombre_usuario = $nombre_usuario;
			$this->clave_usuario = $clave_usuario;
		}
		public function getId_persona_usuario(){
			return $this->id_persona_usuario;
		}
		public function setId_persona_usuario($id_persona_usuario){
			$this->id_persona_usuario = $id_persona_usuario;
		}
		public function getNombre_usuario(){
			return $this->nombre_usuario;
		}
		public function setNombre_usuario($nombre_usuario){
			$this->nombre_usuario = $nombre_usuario;
		}
		public function getClave_usuario(){
			return $this->clave_usuario;
		}
		public function setClave_usuario($clave_usuario){
			$this->clave_usuario = $clave_usuario;

		}
		public function __toString(){
			return "Id_Persona_usuario: " . $this->id_persona_usuario . 
				" Nombre_usuario: " . $this->nombre_usuario . 
				" Clave_usuario: " . $this->clave_usuario;
		}

		


		public static function verificarUsuario($conexion,$nombre_usuario,$password){
			#consulta

			$sql="SELECT id , user FROM user WHERE user = '$nombre_usuario' and pass = '$password'";
			
			#resultado de la consulta				
			$resultado=$conexion->ejecutarConsulta($sql);
			$cantidadRegistros=$conexion->cantidadRegistros($resultado);
			
			if ($cantidadRegistros!=0)  {
				$fila = $conexion->obtenerFila($resultado);
				session_start();
				$_SESSION['status']=true;
				$_SESSION['id']=$fila['id'];
				$_SESSION['nombre']=$fila['user'];
				$respuesta['loggedin'] = 1;
				
			}
			else {
				//echo'correo o contrasenia invalidos';	
				session_start();
				$_SESSION['status']=false;
				$respuesta['loggedin'] = 0;
				$respuesta["mensaje"]="Usuario o Contraseña invalidos";
			}	  
			echo json_encode($respuesta);
		 }


	}
?>