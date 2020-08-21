<?php
	class Conexion{
		private $host="localhost";
		private $usuario="root";
		private $password="";
		private $baseDatos="simpah";
		private $link;

		public function __construct(){
			$this->link=mysqli_connect(
				$this->host,
				$this->usuario,
				$this->password,
				$this->baseDatos
			);
		}

		public function ejecutarSql($sql){
			$sql=utf8_decode($sql);
			return mysqli_query($this->link,$sql);
		}

		public function hayError($resultado){
			$error=mysqli_error($this->link);
			if (strcmp ($error , "" ) == 0){
				return false;
			}
			else{
				return true;
			}
		}

		public function mostrarError($resultado){
			return mysqli_error($this->link);
		}

		public function cantidadRegistros($resultado){
			return mysqli_num_rows($resultado);
		}

		public function obtenerFila($resultado){
			return mysqli_fetch_array($resultado);
		}
		public function cerrarConexion(){
			mysqli_close($this->link);
		}
	}
?>