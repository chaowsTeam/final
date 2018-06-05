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
		$usr = strtoupper($this->input->post('usr'));
		$psw = strtoupper($this->input->post('psw'));

		if (($usr == 'SUPERUSER') && ($psw == '12345')) {
			$this->load->view('Vadministrador');
		}else{
			$psw2 = $this->modelos->verifyPsw($usr); //Obtener la contraseña del usuario ingresado
			$psw2 = $psw2['contraseña'];
			if($psw2 == NULL){ //No se econtro contraseña, ese usuario NO existe
				$this->load->view('Vlogin');
			}elseif ($psw2 != $psw) { //Se encontro una contraseña, PERO NO COINCIDEN
				$this->load->view('Vlogin');
			}else{ //Se Encontro contraseña y SI COINCIDEN
				//ENTRAR
				//Se asignan las variables de SESSION (Variables 'superglobales', el NOMBRE de USUARIO), para poder ser utilizadas a lo largo de todo el proyecto
				$_SESSION["S_usr"]=$usr;
				$this->load->view('Vadministrador');
			}
		}
	}

	public function CargaVAgregar(){ //Funcion para cargar la ista de agregar al catalogo
		$this->load->view('VAgregarCat');
	}

	public function fEditEditoriales(){ //Funcion para cargar la vista que mostrará todos los CATALOGOS
		//OJO aquí, por la manera en la que se desplegaran los catalogos, primero hay que obtenerlos (planes, carreras, alumnos etc.) para que en la vista a través de un SELECT se deplieguen los que se requieren y eviytar estar haciendo uno por uno
		//Obtener todos los catalogos de la base de datos

		//Obtener TODAS los EDITORIALES = 0, uno en especifico, entra su id
		$this->editorialesOrig = $this->modelos->obtenEditoriales(0);
		$this->lastIdEdit = $this->modelos->obtenLastId();

		//Ya se tiene TODAS las editoriales, solo queda enviarsela a una vista que despliegue los que el usuario quiera en ese momoento
	
		$this->load->view('VEditEditorial3', $this->editorialesOrig, $this->lastIdEdit);
	}

	public function fdoEditorial(){ //Funcion para agregar n editoriales
		$this->nomEditoriales = $this->input->post('nom');
		$this->idEditoriales = $this->input->post('id');
		//Juntar la información en un solo vector (id, nombre)
		for ($i=0; $i < count($this->nomEditoriales); $i++) { 
			$j = 0;
			$this->infoNewEdit[$i][$j] = $this->nomEditoriales[$i];
			$j = $j+1;
			$this->infoNewEdit[$i][$j] = $this->idEditoriales[$i];
		}
		//Hacer UPDATE  de los cambios en los editoriales
		$this->modelos->updateEditoriales($_SESSION["editOrig"], $this->infoNewEdit);
		$this->load->view('vDone');
	}

	public function fdecideAgregar(){ //Funcion que decide que es lo que se va a agregar, LEE EL SELECT Y DEPENDIENDO DE LO QUE SEA EL select, OBTIENE LA INFORMACION y la afrega a la base
		$opcion = $this->input	>post('select'); //LEE la opcion del SELEC
		//Dependiendo de cual sea, se leera la info.
		if($opcion == 'Empleado'){
			$this->name = $this->input->post('nom');
			$this->psw = $this->input->post('psw');
			//Aregar a la base los datos leidos
		}elseif($opcion == 'Usuario') {
			$this->name = $this->input->post('nom');
			//Agregar a la base de datos
		}
	}


}
