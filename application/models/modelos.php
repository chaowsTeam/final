<?php

	class modelos extends CI_Model{

		public function __construct(){
			$this->load->database();
		}

		public function obtenTitulos($id_libro, $indi){ //Funcion para obtener TODOS los titulos
			if($indi == 0){ //Obtiene el titulo de todos los libros
				$query = "SELECT titulo FROM libro LIMIT 0, 100";
				$respuesta = $this->db->query($query);
				return($respuesta->result_array());
			}else{ //Ontiene el titulo de un libro en especifico
				$query = "SELECT titulo FROM libro WHERE id_libro = '".$id_libro."' LIMIT 0,50";
				$resultado = $this->db->query($query);
				$resultado = $resultado->row_array();
				$resultado = $resultado['titulo'];
				return($resultado);
			}
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
				$query = "SELECT * FROM libro LIMIT 0,100" ;
				$resultado = $this->db->query($query);
				return $resultado->result_array();
			}elseif ($indi == 1) {
				$query = "SELECT DISTINCT titulo FROM libro, libro_biblioteca, biblioteca WHERE libro."."id_libro = libro_biblioteca."."id_libro AND libro_biblioteca."."id_biblioteca = biblioteca."."id_biblioteca AND biblioteca."."id_biblioteca = '".$idBiblio."' LIMIT 0,100";
				$resultado = $this->db->query($query);
				$resultado = $resultado->result_array();
				return($resultado);
			}
		}


		public function obtenLibros2(){
			$query = "SELECT * from libro LIMIT 0,50";
			$resultado = $this->db->query($query);
			return $resultado->result_array();

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

		public function obtenInfoPrestamosBiblioteca($idBiblio, $D_ini, $D_fin){ //Obtiene toda la info de TODOS los prestamos de una bibliteca en especifico
			$query = "SELECT empleado."."nom_empleado, usuario."."nom_usuario, libro."."titulo, prestamo."."fecha_prest, prestamo."."fecha_dev FROM empleado, usuario, prestamo, libro_biblioteca, biblioteca, libro WHERE usuario."."id_usuario = prestamo."."id_usuario AND prestamo."."num_inve = libro_biblioteca."."num_inv AND libro_biblioteca."."id_libro = libro."."id_libro AND prestamo."."id_empleado = empleado."."id_empleado AND biblioteca."."id_biblioteca = libro_biblioteca."."id_biblioteca  AND biblioteca."."id_biblioteca = ".$idBiblio." AND prestamo."."fecha_prest BETWEEN '".$D_ini."' AND '".$D_fin."' LIMIT 0,100";
			$respuesta = $this->db->query($query);
			return ($respuesta->result_array());

		}


		public function cuentaPrestamos($nomBiblio, $mes){ //Cuenta los prestamos de una biblioteca en un mes especifico
			$query = "SELECT COUNT(id_prestamo) as cant_prestamos FROM prestamo, libro_biblioteca, biblioteca WHERE biblioteca."."id_biblioteca = libro_biblioteca."."id_biblioteca AND libro_biblioteca."."num_inv = prestamo."."num_inve AND biblioteca."."nom_biblioteca='".$nomBiblio."' AND MONTH(fecha_prest) ='".$mes."' LIMIT 0,50";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$resultado = $resultado['cant_prestamos'];
			return($resultado);
		}
		public function agregaRand($i, $id_autor){
			$query = "INSERT INTO autor_libro (id_libro, id_autor) VALUES ('".$i."', '".$id_autor."')";
			$resultado = $this->db->query($query);

		}
		public function cuentaPrestamosUsuario($nomUsr){ //Funcion para contar los prestamos de UN SOLO USUARIO
			$query = "SELECT COUNT(id_prestamo) as cant_prestamos FROM prestamo WHERE id_usuario = '".$nomUsr."' LIMIT 0,100";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$resultado = $resultado['cant_prestamos'];
			return($resultado);
		}

		public function cuentaPrestamosUsuarioWithDate($idUsr, $D_ini, $D_fin){//Cuenta los prestamos de cada usuario en un intervalo de tiempo, usando el id del usuario
			$query = "SELECT COUNT(id_prestamo) as cant_prestamos FROM prestamo, usuario WHERE prestamo."."id_usuario = usuario."."id_usuario AND usuario."."id_usuario = '".$idUsr."' AND prestamo."."fecha_prest BETWEEN '".$D_ini."' AND '".$D_fin."' LIMIT 0,100";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$resultado = $resultado['cant_prestamos'];
			return($resultado);
		}

		public function obtenBiblioPrestamo($idPrestamo){//Obtiene la biblioteca de donde se efectuo un prestamo (usando el id del prestamo)
			$query = "SELECT nom_biblioteca FROM prestamo, libro_biblioteca, biblioteca WHERE prestamo."."num_inve = libro_biblioteca."."num_inv AND libro_biblioteca."."id_biblioteca = biblioteca."."id_biblioteca AND prestamo."."id_prestamo = ".$idPrestamo." LIMIT 0,100";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$resultado = $resultado['nom_biblioteca'];
			return $resultado;
		}

		public function obtenTituloPrestamos($idPrestamo){ //Obtiene los titulos del libro en un prestamo 
			$query = "SELECT titulo FROM prestamo, libro_biblioteca, libro WHERE prestamo."."num_inve = libro_biblioteca."."num_inv AND libro_biblioteca."."id_libro = libro."."id_libro AND prestamo."."id_prestamo = ".$idPrestamo."";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$resultado = $resultado['titulo'];
			return $resultado;
		}

		public function cuentaPrestamosWithDate($nomBiblio, $idL, $D_ini, $D_fin){ //Cuenta los prestamos en un intervalo de tiempo DE UN TITULO EN ESPECIFICO, EN UNA BIBLIOTECA ESPECIFICA
			$query = "SELECT COUNT(id_prestamo) as cant_prestamos FROM prestamo, libro_biblioteca, biblioteca, libro WHERE libro."."id_libro = libro_biblioteca."."id_libro AND biblioteca."."id_biblioteca = libro_biblioteca."."id_biblioteca AND libro_biblioteca."."num_inv = prestamo."."num_inve AND biblioteca."."nom_biblioteca='".$nomBiblio."' AND libro."."id_libro =".$idL." AND (prestamo."."fecha_prest BETWEEN '".$D_ini."' AND '".$D_fin."') LIMIT 0,100";
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
			if ($indi == 0) { //Obtiene todos los usuarios (Todos los datos de estos)
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
				$query = "SELECT id_libro FROM libro WHERE titulo = '".$nombre."' LIMIT 0,100 ";
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
			$query = "SELECT DISTINCT id_biblioteca FROM libro_biblioteca  WHERE id_libro = ".$id_libro." AND prestado = 0 LIMIT 0,10";
			$resultado = $this->db->query($query);
			return $resultado->result_array();
		}

		public function cuentaLibrosEnBiblio($idlibro, $idbiblio){ //Le importa si LOS LIRBOS ESTAN PRESTADOS a diferencia de la de abajo 
			$query = "SELECT COUNT(id_libro) as num_libros FROM libro_biblioteca WHERE id_libro = ".$idlibro." and prestado=0 and id_biblioteca = ".$idbiblio." LIMIT 0,100";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$numero = $resultado['num_libros'];
			return $numero;
		}

		public function cuentaLibrosEnBiblio2($idlibro, $idbiblio){ //La misma de la de arriba SIN IMPORTAR SI ESTAN RPESTADOS LOS LIBROS LOS CUENYTA, PARA REPORTES!!!
			$query = "SELECT COUNT(id_libro) as num_libros FROM libro_biblioteca WHERE id_libro = ".$idlibro."  and id_biblioteca = ".$idbiblio." LIMIT 0,100";
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
			
			$respuesta  = $this->db->query($query);
			return $respuesta;
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
		public function borraPrestamo($num_inve, $id_prestamo){
			$query = "DELETE FROM prestamo WHERE id_prestamo = '".$id_prestamo."' and num_inve = '".$num_inve."'";
			$respuesta = $this->db->query($query);
			return $respuesta->row_array();
		}

		public function borraPrestamo2($num_inve, $id_prestamo){
			$query = "DELETE FROM prestamo WHERE id_prestamo = '".$id_prestamo."' and num_inve = '".$num_inve."'";
			$respuesta = $this->db->query($query);
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

		public function obtenIdUser($usr){ //Obtiene el ID de un usuario
			$query = "SELECT id_usuario FROM usuario WHERE nom_usuario = '".$usr."'";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$resultado = $resultado['id_usuario'];
			return($resultado);
		}

		public function obtenIdEmpl($emp){
			$query = "SELECT id_empleado FROM empleado WHERE nom_empleado = '".$emp."'";
			$resultado = $this->db->query($query);
			$resultado = $resultado->row_array();
			$resultado = $resultado['id_empleado'];
			return($resultado);
		}

		public function obtenInfoPrestamosLibroUsr($idUsr, $idLibro, $indi){ //Función para obtener TODA la información de prestamos.sadhsd
			if ($indi == 0) { //Obtiene la informacion de TODOS LOS PRESTAMOS de UN SOLO USR
				$query = "SELECT prestamo."."id_prestamo, prestamo."."fecha_prest, prestamo."."fecha_dev FROM prestamo, libro_biblioteca, libro, usuario WHERE usuario."."id_usuario = prestamo."."id_usuario AND usuario."."id_usuario = '".$idUsr."' AND prestamo."."num_inve = libro_biblioteca."."num_inv AND libro_biblioteca."."id_libro = libro."."id_libro LIMIT 0,100";
				$respuesta = $this->db->query($query);
				return ($respuesta->result_array());
			}else{ //Obtiene la informacion de TODOS los prestamos de  de UN SOLO USUARIO de un LIBRO especifico
				$query = "SELECT prestamo."."id_prestamo, prestamo."."fecha_prest, prestamo."."fecha_dev FROM prestamo, libro_biblioteca, libro, usuario WHERE usuario."."id_usuario = prestamo."."id_usuario AND usuario."."id_usuario = '".$idUsr."' AND prestamo."."num_inve = libro_biblioteca."."num_inv AND libro_biblioteca."."id_libro = libro."."id_libro AND libro."."id_libro = ".$idLibro." LIMIT 0,100";
				$respuesta = $this->db->query($query);
				return ($respuesta->result_array());
			}

		}

		public function obtenInfoPrestamosBiblioLibroWithDate($idBiblio, $idLibro, $D_ini, $D_fin, $indi){ //Funcion para obtener la info de prestamo de una biblioteca de un libro en especifico
			if ($indi == 0) {
				$query = "SELECT empleado."."nom_empleado, usuario."."nom_usuario,  prestamo."."id_prestamo, prestamo."."fecha_prest, prestamo."."fecha_dev FROM prestamo, libro_biblioteca, libro, usuario, biblioteca, empleado WHERE usuario."."id_usuario = prestamo."."id_usuario AND prestamo."."num_inve = libro_biblioteca."."num_inv AND libro_biblioteca."."id_libro = libro."."id_libro AND prestamo."."id_empleado = empleado."."id_empleado AND biblioteca."."id_biblioteca = libro_biblioteca."."id_biblioteca  AND biblioteca."."id_biblioteca = ".$idBiblio." AND libro."."id_libro = ".$idLibro." AND prestamo."."fecha_prest BETWEEN '".$D_ini."' AND '".$D_fin."' LIMIT 0,100";
				$respuesta = $this->db->query($query);
				return ($respuesta->result_array());
			}
		}

		public function obtenInfoLibro($NumInve){ //Funcion para obtener la informacion de un libro, a través de su número de inventario (Nombre de Libro, En que biblioteca está, clasificacion, editorial, tema, autores) VA A SALIR UN MEGA QUERY!!
			$query = "SELECT autor."."nom_autor, clasi."."nom_clasi, editorial."."nom_editorial, tema."."nom_tema, libro."."titulo, biblioteca."."nom_biblioteca FROM autor, clasi, editorial, libro, autor_libro, tema_libro, tema, biblioteca, libro_biblioteca WHERE autor."."id_autor = autor_libro."."id_autor AND clasi."."id_clasificacion = libro."."id_clasificacion AND libro."."id_libro = autor_libro."."id_libro AND tema."."id_tema = tema_libro."."id_tema AND editorial."."id_editorial = libro."."id_editorial AND libro."."id_libro = libro_biblioteca."."id_libro AND libro_biblioteca."."id_biblioteca = biblioteca."."id_biblioteca AND tema_libro."."id_libro = libro."."id_libro AND libro_biblioteca."."num_inv = ".$NumInve." AND libro_biblioteca."."prestado = 0 ";
			$respuesta = $this->db->query($query);
			return ($respuesta->row_array());
		}

		public function agregaPrestamo($idEmpleado, $idUsuario, $NumInventarios, $fechasPrest, $fechasDev){
			$query = "INSERT INTO prestamo (id_empleado, id_prestamo,  id_usuario, num_inve, fecha_prest, fecha_dev) VALUES ('".$idEmpleado."', NULL, '".$idUsuario."', '".$NumInventarios."', '".$fechasPrest."', '".$fechasDev."' )";
				$respuesta = $this->db->query($query);

		}


}

	
	
