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

		public function obtenAutores($indi){ //Funcion para obtener los AUTORES
			if ($indi == 0) {
				$query = "SELECT * FROM autor";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}

		public function obtenBiblios($indi){
			if ($indi == 0) {
				$query = "SELECT * FROM biblioteca";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}

		public function obtenEditoriales($indi){ 
			if ($indi == 0) {
				$query = "SELECT * FROM editorial";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}

		public function obtenEmpleados($indi){
			if ($indi == 0) {
				$query = "SELECT * FROM empleado";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}

		public function obtenLibros($indi){
			if ($indi == 0) {
				$query = "SELECT * FROM libro";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}

		public function obtenTemas($indi){
			if ($indi == 0) {
				$query = "SELECT * FROM tema";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}

		public function obtenUsuarios($indi){
			if ($indi == 0) {
				$query = "SELECT * FROM usuario";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}

		public function obtenClasif($indi){
			if ($indi == 0) {
				$query = "SELECT * FROM clasi";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}

		public function agregaEditorial($editoriales){ //Funcion para agregar n editoriales
			for ($i=0; $i < count($editoriales) ; $i++){ 
				$query = "INSERT INTO editorial (nom_editorial) VALUES ('".$editoriales[$i]."')";
				$respuesta = $this->db->query($query);
			}
		}

		public function obtenLastId(){ //Funcion para obtenr el ultimo ID 
			$query = "SELECT MAX(id_editorial) as maxid FROM editorial";
			$respuesta = $this->db->query($query);
			$respuesta= $respuesta->row_array();
			$respuesta = intval($respuesta['maxid']);
			return($respuesta);
		}

		public function updateEditoriales($originales, $actualizados){ //Funcion para hacer update a los obtenEditoriales

			for ($i=0; $i < count($originales); $i++) { 
				$query = "UPDATE editorial SET vigencia = 0";
				$this->db->query($query);
			}

			for ($i=0; $i < count($actualizados); $i++) { 
				$query = "INSERT INTO editorial (id_editorial, nom_editorial, vigencia) VALUES ('".$actualizados[$i][1]."','".$actualizados[$i][0]."', 1) ON DUPLICATE KEY UPDATE nom_editorial = '".$actualizados[$i][0]."', vigencia = 1 ";
				$this->db->query($query);	
			}

			/*
			//Por cuestiones de logica, borrar LOGICAMENTE todos los editoriales (un 0 en el campo de vigencia)
			for ($i=0; $i < count($originales); $i++) { 
				$query = "UPDATE editorial SET vigencia = 0";
				$this->db->query($query);
			}
			//UN vez con los datos borrados logicamente, hacer la actualizacion de todos los demas datos
			for ($i=0; $i < count($actualizados); $i++) { 
				$query = "UPDATE editorial SET nom_editorial = '".$actualizados[$i][0]."', vigencia = 1 WHERE id_editorial = '".$actualizados[$i][1]."'";
				$this->db->query($query);

				$query = "INSERT editorial"
			}
			*/
	
		}
	}
