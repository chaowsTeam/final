<?php

	class modelos extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function verifyPsw($usr){ //Funcion para obtener la contraseña del usuario ingresado
			$query = "SELECT (contraseña) FROM empleado WHERE nom_empleado = '".$usr."'";
			$resultado = $this->db->query($query);
			return $resultado->row_array();
		}
	
}
