<?php

	class modelos extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function obtenUsrXName($usr){ //Funcion para obtener la contraseña del usuario ingresado
			$query = "SELECT * FROM empleado WHERE nom_empleado = '".$usr."'";
			$resultado = $this->db->query($query);
			return $resultado->row_array();
		}

		public function obtenIdLibro($nombre){
			$query = "SELECT id_libro FROM libro WHERE titulo LIKE '%".$nombre."%' ";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function obtenLibroBiblioteca($id_libro){
			$query = "SELECT DISTINCT id_biblioteca FROM libro_biblioteca  WHERE id_libro = '".$id_libro."' AND prestado = 0";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}
		public function cuentaLibrosEnBiblio($idlibro, $idbiblio){
			$query = "SELECT COUNT(id_libro) as num_libros FROM libro_biblioteca WHERE id_libro = ".$idlibro." and prestado=0 and id_biblioteca = ".$idbiblio;
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$numero = $resultado['num_libros'];
			return $numero;
		}
	
}
