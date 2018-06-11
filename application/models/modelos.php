<?php

	class modelos extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function obtenTitulos(){ //Funcion para obtener TODOS los titulos
			$query = "SELECT titulo FROM libro ";
			$respuesta = $this->db->query($query);
			return($respuesta->result_array());
		}


		public function obtenUsrXName($usr){ //Funcion para obtener la contraseña del usuario ingresado
			$query = "SELECT * FROM empleado WHERE nom_empleado = '".$usr."'";
			$resultado = $this->db->query($query);
			return $resultado->row_array();
		}

		public function obtenAutores($idLibro, $indi){ //Funcion para obtener los AUTORES
			if ($indi == 0) { //TODOS los autores
				$query = "SELECT * FROM autor";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}else{ //De un libro en especifico
				$query = "SELECT nom_autor FROM autor, autor_libro WHERE autor."."id_autor = autor_libro."."id_autor AND autor_libro."."id_libro = '".$idLibro."' ";
				$resultado = ($this->db->query($query))->result_array();
				$autores = " ";
				for ($i=0; $i < count($resultado) ; $i++) { 
					$autores = $resultado[$i]['nom_autor'].",  ".$autores;
				}
				return $autores;
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

		public function obtenLibros($idBiblio,$indi){ //0 TODOS los libros, 1 de una BIBLIOTECA 
			if ($indi == 0) {
				$query = "SELECT * FROM libro";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}elseif ($indi == 1) {
				$query = "SELECT DISTINCT titulo FROM libro, libro_biblioteca, biblioteca WHERE libro."."id_libro = libro_biblioteca."."id_libro AND libro_biblioteca."."id_biblioteca = biblioteca."."id_biblioteca AND biblioteca."."id_biblioteca = '".$idBiblio."'";
				$resultado = $this->db->query($query);
				$resultado = $resultado->result_array();
				return($resultado);
			}
		}

		public function obtenIdBiblio($nomBiblio, $indi){ //Funcion para obtener el id de una biblioteca
			if ($indi == 1) {
				$query = "SELECT id_biblioteca FROM biblioteca WHERE nom_biblioteca = '".$nomBiblio."'";
				$resultado = $this->db->query($query);
				$resultado = $resultado->row_array();
				$resultado = $resultado['id_biblioteca'];
				return($resultado);
			} else { //Obtiene el id de TODAS las bibliotecas
				$query = "SELECT id_biblioteca, nom_biblioteca FROM biblioteca";
				$resultado = $this->db->query($query);
				$resultado = $resultado->result_array();
				return($resultado);
			}
		}

		public function cuentaPrestamos($nomBiblio, $mes){ //Cuenta los prestamos de una biblioteca en un mes especifico
			$query = "SELECT COUNT(id_prestamo) as cant_prestamos FROM prestamo, libro_biblioteca, biblioteca WHERE biblioteca."."id_biblioteca = libro_biblioteca."."id_biblioteca AND libro_biblioteca."."num_inv = prestamo."."num_inve AND biblioteca."."nom_biblioteca='".$nomBiblio."' AND MONTH(fecha_prest) ='".$mes."'";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$resultado = $resultado['cant_prestamos'];
			return($resultado);
		}

		public function obtenTemas($indi){
			if ($indi == 0) {
				$query = "SELECT * FROM tema";
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}
		}
		public function obtenLastIdTemas(){
			$query = "SELECT MAX(id_tema) as maxid FROM tema";
			$respuesta = $this->db->query($query);
			$respuesta= $respuesta->row_array();
			$respuesta = intval($respuesta['maxid']);
			return($respuesta);
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

		public function obtenIdLibro2($nombre, $indi){
			if ($indi == 0) { //Obtener el ID de TODOS los libros
				# code...
			} else { //Obtener el ID  de UN SOLO LIBRO
				$query = "SELECT id_libro FROM libro WHERE titulo = '".$nombre."' ";
				$resultado = $this->db->query($query);
				$resultado = $resultado->row_array();
				$resultado = $resultado['id_libro'];
				return($resultado);
			}
			
		}

		public function obtenIdLibro($nombre){
			$query = "SELECT id_libro, titulo FROM libro WHERE titulo LIKE '%".$nombre."%' limit 1,30";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function obtenLibroBiblioteca($id_libro){
			$query = "SELECT DISTINCT id_biblioteca FROM libro_biblioteca  WHERE id_libro = '".$id_libro."' AND prestado = 0";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function cuentaLibrosEnBiblio($idlibro, $idbiblio){ //Le importa si LOS LIRBOS ESTAN PRESTADOS a diferencia de la de abajo 
			$query = "SELECT COUNT(id_libro) as num_libros FROM libro_biblioteca WHERE id_libro = ".$idlibro." and prestado=0 and id_biblioteca = ".$idbiblio;
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$numero = $resultado['num_libros'];
			return $numero;
		}

		public function cuentaLibrosEnBiblio2($idlibro, $idbiblio){ //La misma de la de arriba SIN IMPORTAR SI ESTAN RPESTADOS LOS LIBROS LOS CUENYTA, PARA REPORTES!!!
			$query = "SELECT COUNT(id_libro) as num_libros FROM libro_biblioteca WHERE id_libro = ".$idlibro."  and id_biblioteca = ".$idbiblio;
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$numero = $resultado['num_libros'];
			return $numero;
		}

		public function mostrar($nombre){
			$query = "SELECT nom_editorial FROM editorial WHERE nom_editorial LIKE '%".$nombre."%' ";
			$resultado = $this->db->query($query);
			return $resultado->result();
		}

		public function obtenNombreBibli($id){
			$query = "SELECT nom_biblioteca FROM biblioteca WHERE id_biblioteca = ".$id;
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$nombre = $resultado['nom_biblioteca'];
			return $nombre;	
		}	

		public function agregaLibro($titulo, $isbn, $id_clasificacion, $id_editorial){
			$query = "INSERT INTO libro (id_libro, titulo, ISBN, id_clasificacion, id_editorial) VALUES (NULL,'".$titulo."', '".$isbn."', '".$id_clasificacion."', '".$id_editorial."')";
			$respuesta = $this->db->query($query);
			return $respuesta;

		}
		public function agregaLibroBiblioteca($idlibro,$idbiblio,$prestamo){
			$query = "INSERT INTO libro_biblioteca (num_inv, id_libro, id_biblioteca, prestado) VALUES (NULL, '".$idlibro."', '".$idbiblio."', '".$prestamo."')";
			
			$this->db->query($query);
		}
		public function agregarPrestamos($id_empleado,$id_usuario,$num_inve,$fecha_prest){
			$query = "INSERT INTO prestamo (id_empleado, id_prestamo, id_usuario, num_inve, fecha_prest, fecha_dev) VALUES ('".$id_empleado."', NULL, '".$id_usuario."', '".$num_inve."', '".$fecha_prest."', '".$fecha_prest."')";
			$this->db->query($query);
		}

		public function buscaNumInv($id_biblioteca){
			$query = "SELECT num_inv from libro_biblioteca WHERE id_biblioteca='".$id_biblioteca."'";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$res = $resultado['num_inv'];
			return $res;
			
		}
		
		public function obtenLastIdAutor(){
			$query = "SELECT MAX(id_autor) as maxid FROM autor";
			$respuesta = $this->db->query($query);
			$respuesta= $respuesta->row_array();
			$respuesta = intval($respuesta['maxid']);
			return($respuesta);

		}
		public function updateAutores($originales, $actualizados){ //Funcion para hacer update a los obtenEditoriales
			for ($i=0; $i < count($originales); $i++) { 
				$query = "UPDATE autor SET vigencia = 0";
				$this->db->query($query);
			}

			for ($i=0; $i < count($actualizados); $i++) { 
				$query = "INSERT INTO autor (id_autor, nom_autor, vigencia) VALUES ('".$actualizados[$i][1]."','".$actualizados[$i][0]."', 1) ON DUPLICATE KEY UPDATE nom_autor = '".$actualizados[$i][0]."', vigencia = 1 ";
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
		public function updateTemas($originales, $actualizados){ //Funcion para hacer update a los obtenEditoriales
			for ($i=0; $i < count($originales); $i++) { 
				$query = "UPDATE tema SET vigencia = 0";
				$this->db->query($query);
			}

			for ($i=0; $i < count($actualizados); $i++) { 
				$query = "INSERT INTO tema (id_tema, nom_tema, vigencia) VALUES ('".$actualizados[$i][1]."','".$actualizados[$i][0]."', 1) ON DUPLICATE KEY UPDATE nom_tema = '".$actualizados[$i][0]."', vigencia = 1 ";
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

	
	
