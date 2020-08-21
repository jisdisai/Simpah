<?php
	class timeStampDiff{
		private $fechaReferencia;
		private $fechaActual;
		private $futuro;
		
		public function __construct(){
			$this->fechaReferencia = date_create("2017-01-01");
			$this->fechaActual=date_create(date("y-m-d"));
			$this->futuro = date_create(date("y-m-d"));
		}

		public function sumar ($cantidad, $intervalo){
			$respuesta="";
			if(strcmp($intervalo, "week")==0){
				date_add($this->futuro, date_interval_create_from_date_string($cantidad.' weeks'));
				$diferencia=date_diff($this->fechaReferencia, $this->futuro);
				$respuesta=intval(intval($diferencia->format("%R%a"))/7);
				
			}
			elseif (strcmp($intervalo, "month")==0) {
				date_add($this->futuro, date_interval_create_from_date_string($cantidad.' months'));
				$diferencia=$this->fechaReferencia->diff($this->futuro);
				$respuesta= intval($diferencia->format("%m")) + (intval($diferencia->format("%Y"))*12);
			}
			elseif (strcmp($intervalo, "quarter")==0) {
				date_add($this->futuro, date_interval_create_from_date_string((intval($cantidad)*3).' months'));
				$diferencia=$this->fechaReferencia->diff($this->futuro);
				$respuesta=intval(( (floatval($diferencia->format("%M"))) + (floatval($diferencia->format("%Y"))*12) )/3);
			}
			elseif (strcmp($intervalo, "year")==0) {
				date_add($this->futuro, date_interval_create_from_date_string($cantidad.' years'));
				$diferencia=$this->fechaReferencia->diff($this->futuro);
				$respuesta=$diferencia->format("%Y");
				$respuesta=$respuesta;
			}
			return $respuesta;
		}

		public function obtenerMes(){
			$respuesta="";
			if(strcmp($this->futuro->format("m"),"01")==0){
				$respuesta="Ene";
			}
			elseif (strcmp($this->futuro->format("m"),"02")==0) {
				$respuesta="Feb";
			}
			elseif (strcmp($this->futuro->format("m"),"03")==0) {
				$respuesta="Mar";
			}
			elseif (strcmp($this->futuro->format("m"),"04")==0) {
				$respuesta="Abr";
			}
			elseif (strcmp($this->futuro->format("m"),"05")==0) {
				$respuesta="May";
			}
			elseif (strcmp($this->futuro->format("m"),"06")==0) {
				$respuesta="Jun";
			}
			elseif (strcmp($this->futuro->format("m"),"07")==0) {
				$respuesta="Jul";
			}
			elseif (strcmp($this->futuro->format("m"),"08")==0) {
				$respuesta="Ago";
			}
			elseif (strcmp($this->futuro->format("m"),"09")==0) {
				$respuesta="Sep";
			}
			elseif (strcmp($this->futuro->format("m"),"10")==0) {
				$respuesta="Oct";
			}
			elseif (strcmp($this->futuro->format("m"),"11")==0) {
				$respuesta="Nov";
			}
			elseif (strcmp($this->futuro->format("m"),"12")==0) {
				$respuesta="Dic";
			}
			return $respuesta;
		}
		public function obtenerDia(){
			return $this->futuro->format("d");
		}
		public function obtenerAnio(){
			return $this->futuro->format("Y");
		}

		public function obtenerFecha(){
			return $this->obtenerDia()."-".$this->obtenerMes()."-".$this->obtenerAnio();
		}
	}
	
?>
