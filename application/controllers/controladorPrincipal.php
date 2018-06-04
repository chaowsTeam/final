<?php
session_start(); //Se inicia una session, para poder usar el tipo de usuario y nombre a lo largo del proyecto
defined('BASEPATH') OR exit('No direct script access allowed');

//WINDOWS:
 require('C:\xampp\fpdf\fpdf.php'); //Libreria para la creación de PDF´s
//UBUNTU: require('/opt/lampp/htdocs/fpdf/fpdf.php');

class PDF extends FPDF{ //Clase que extiende de FPDF,

	function Header(){
		$date = date('F d, o');
		$this->SetFont('Times','I',12);
		$this->Cell(35,1,$date,0,1,'C');
	}

	/**function Footer(){
		//Imagen de footer
		//Para WINDOWS:
		//$this->Image('C:\xampp\fpdf\footerUaemex.png',2,25,15,3);

		//Para UBUNTU:
		$this->Image('/opt/lampp/htdocs/fpdf/footerUaemex.jpeg',2,25,15,3);
	}*/
	function SetDash($black=false, $white=false)
    {
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }

}
class ControladorPrincipal extends CI_Controller { //Definición principal

	public function __construct(){ //Definición del modelo
		parent:: __construct();
		$this->load->model('modelos');
	}

	public function login(){
		$this->load->view('Vlogin');
	}

	public function pPrincipal(){ //Carga la vista Principal (Para los botones de Regresar)
		$this->load->view('Vadministrador');
	}

	public function fUserTipe(){ //Funcion para verificar si existe el Usuario
		//Obtener el usuario y la contraseña del login
		$usr = $this->input->post('usr');
		$psw = $this->input->post('psw');
		$datosUsr= $this->modelos->obtenUsrXName($usr);
		if(!isset($datosUsr)){
			$this->load->view('Vlogin');
		}else{
			if ($datosUsr['id_empleado'] == $psw) {
				$_SESSION["S_usr"]=$usr;
				$this->load->view('Vadministrador');
			}
		}
	}
	public function CargaVAgregar(){ //Funcion para cargar la ista de agregar al catalogo
		$this->load->view('VAgregarCat');
	}
	public function obtenLibro(){
		$nombre = $this->input->post('nombreLibro');
		$idLibro = $this->modelos->obtenIdLibro($nombre);
		//echo json_encode($nombre);
		
		if ($idLibro!=NULL) {

			//agregando nuevo indice al array y añadimos las bibliotecas
			for ($i=0; $i <count($idLibro) ; $i++) {

				$id = $idLibro[$i]['id_libro'];
				$idLibro[$i]['bibliotecas'] = NULL;
				$idLibro[$i]['bibliotecas'] = $this->modelos->obtenLibroBiblioteca($id);
				$bibliotecas[$i]['numero'] = $idLibro[$i]['bibliotecas'];
				
				//$prueba = $this->modelos->cuentaLibrosEnBiblio($id,$numbibli);
				for ($j=0; $j <count($bibliotecas[$i]['numero']) ; $j++) { 
					$numbibli = $bibliotecas[$i]['numero'][$j]['id_biblioteca'];
					$idLibro[$i]['bibliotecas'][$j]['noLibros'] = $this->modelos->cuentaLibrosEnBiblio($id,$numbibli);
				}

			}
			echo json_encode(var_dump($idLibro));
			//echo "asdasd";
			//echo json_encode($prueba);
			
		}else{
			echo"No se encontro el libro";
		}
	}


}
