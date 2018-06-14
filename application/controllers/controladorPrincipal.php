<?php
use Spipu\Html2Pdf\Html2Pdf;
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

	/*function Footer(){
		//Imagen de footer
		//Para WINDOWS:
		//$this->Image('C:\xampp\fpdf\footerUaemex.png',2,25,15,3);

		//Para UBUNTU:
		$this->Image('/opt/lampp/htdocs/fpdf/footerUaemex.jpeg',2,25,15,3);
	}

	function SetDash($black=false, $white=false){
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }*/

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
	public function CargaEditorial(){
		$this->load->view('editorial');
	}
	public function devol(){
		$this->load->view('VDevolucion');
	}
	public function fVCapturaLibros(){
		$this->load->view('VCaptura');
	}
	public function CargaVAgregar(){ //Funcion para cargar la ista de agregar al catalogo
		$this->load->view('VAgregarCat');
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
			}else{
				$this->load->view('Vlogin');
			}
		}
	}
	public function agregaNombreLibros(){
		$titulo = $this->input->post('nombreLibro');
		$isbn = $this->input->post('isbn');
		$tema = $this->input->post('tema');
		$edit = $this->input->post('edit');
		$respuesta = $this->modelos->agregaLibro($titulo, $isbn,$tema, $edit);

		echo json_encode($respuesta);
	}

	public function generaRepo1(){ //Funcion para obtener datos del REPORTE1
		$tituloLibro = $this->input->post('tituloLibro');
		$nomBiblio = $this->input->post('nomBiblio');
		$idBiblio = $this->modelos->obtenIdBiblio($nomBiblio, 1);
		
		if(($tituloLibro == 'vacio') and ($nomBiblio == 'vacio')){ //NO HAY NINGUN FILTRO
			$infoRepo['indicador'] = 0;
			echo json_encode($infoRepo);
		}elseif (($tituloLibro != 'vacio') and ($nomBiblio == 'vacio')) { //NO hay FILTRO BIBLIOTECA
			$id = $this->modelos->obtenIdLibro2($tituloLibro, 1);
			for ($i=0; $i < 1 ; $i++) {
				$idLibro[$i]['bibliotecas'] = NULL;
				$idLibro[$i]['bibliotecas'] = $this->modelos->obtenLibroBiblioteca($id);
				$bibliotecas[$i]['numero'] = $idLibro[$i]['bibliotecas'];
				for ($j=0; $j <count($bibliotecas[$i]['numero']) ; $j++) { 
					$numbibli = $bibliotecas[$i]['numero'][$j]['id_biblioteca'];
					$idLibro[$i]['bibliotecas'][$j]['noLibros'] = $this->modelos->cuentaLibrosEnBiblio($id,$numbibli);
					$idLibro[$i]['bibliotecas'][$j]['id_biblioteca'] = $this->modelos->obtenNombreBibli($numbibli); 
				}
			}
			$idLibro[0]['total'] = 0;
			for ($i=0; $i < count($idLibro[0]['bibliotecas']); $i++) { 
				$idLibro[0]['total'] = intval($idLibro[0]['bibliotecas'][$i]['noLibros']) + $idLibro[0]['total'];
			}
			$idLibro['titulo'] = $tituloLibro;
			//Obtener los autores del libro seleccionado
			$idLibro['autores'] = $this->modelos->obtenAutores($id, 1);
			$idLibro['indicador'] = 1;
			echo json_encode($idLibro);
		}elseif(($tituloLibro == 'vacio') and ($nomBiblio != 'vacio')){ //NO HAY FILTRO DE TITULO PERO SI DE BIBLIOTECA

			$infoRepo['indicador'] = 2;
			$infoRepo['totalGlobal'] = 0;
			$infoRepo['biblioteca'] = $nomBiblio;
			//Obtener TODOS los libros de esa biblioteca y autores de cada libro 
			$infoRepo['libros'] = $this->modelos->obtenLibros($idBiblio,1);
			for ($i=0; $i < count($infoRepo['libros']) ; $i++) { 
				$idLibro = $this->modelos->obtenIdLibro2($infoRepo['libros'][$i]['titulo'], 1);
				$totalLibro = $this->modelos->cuentaLibrosEnBiblio2($idLibro,$idBiblio);
				$infoRepo['libros'][$i]['cantidad'] = $totalLibro;
				$infoRepo['libros'][$i]['autores']= $this->modelos->obtenAutores($idLibro, 1);

				$infoRepo['totalGlobal'] = $infoRepo['totalGlobal'] + intval($totalLibro);
			}
			echo json_encode($infoRepo);			
		}elseif (($tituloLibro != 'vacio') and ($nomBiblio != 'vacio')) { //Hay AMBOS filtros
			$infoRepo['biblioteca'] = $nomBiblio;
			$infoRepo['nomLibro'] = $tituloLibro;
			//Obtener el autor de ese libro
			$id_libro = $this->modelos->obtenIdLibro2($tituloLibro, 1);
			$infoRepo['autores'] =$this->modelos->obtenAutores($id_libro, 1);
			//Obtener la cantidad de un libro especifico en una biblioteca especifica 
			$infoRepo['cantidad'] = $this->modelos->cuentaLibrosEnBiblio2($id_libro,$idBiblio);
			$infoRepo['indicador'] = 3;
			echo json_encode($infoRepo);
		}
	}

	public function fPDFRepo1(){ //Funcion para generar el PDF del reporte 1
		//Como hay varios filtros y opciones, el reporte se arma dependiendo cual sea la opcion
		/*require __DIR__.'/vendor/autoload.php';
		$html = $_REQUEST['valDiv'];

		$Html2Pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
		$Html2Pdf->writeHTML($html);
		$Html2Pdf->output('ahuevo.pdf');
		*/
		$opc = $this->input->post('opcionhidden');

		if($opc=='1'){ //Solo hay filtro de  TITULO
			//Obtener la informacion de la vista
			$header = $this->input->post('header');
			$header = explode(",", $header);
			$bibliotecas = $this->input->post('biblioteca');
			$cants = $this->input->post('cant');
			$total = $this->input->post('total');

			//Ya se tiene la informacion, se genera el reporte!
			$nombre = "Titulo: ".$header[0].", Autor(es): ".$header[1];
			$totalText = 'Total';

			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			
			$pdf->SetFont('Times','BU',14);
			$pdf->Cell(19,1,$nombre,0,0,'C');
			$pdf->Ln(1);
			$pdf->Ln(1);
			$pdf->SetFont('Times','B',14);
			$pdf->SetDrawColor(0,80,180);
			$pdf->SetFillColor(430,430,10);
			$pdf->SetLineWidth(0.08);
			$pdf->Cell(3, 1, "Biblioteca", 1, 0, 'C');
			$pdf->Cell(5, 1, "Unidades Disponibles", 1, 1, 'C');
			$pdf->Ln();
			$pdf->SetFont('Times','',12);

			for ($i=0; $i < count($bibliotecas); $i++) {
				$pdf->Cell(3, 1, $bibliotecas[$i], 1, 0, 'C');
				$pdf->Cell(5, 1, $cants[$i], 1, 1, 'C');
			}
			$pdf->Cell(3, 1, $totalText, 1, 0, 'C');
			$pdf->Cell(5, 1, $total, 1, 1, 'C');

			$pdf->Output();
			
		}elseif($opc=='2') { //Solo hay filtro de BIBLIOTECA
			$biblio = $this->input->post('bibliO');
			$total = $this->input->post('total');
			$libros = $this->input->post('libro');
			$autores = $this->input->post('autores');
			$cant = $this->input->post('unid');
			
			//Ya se tiene la informacion, se genera el reporte!
			$nombre = "Biblioteca: ".$biblio;
			$totalText = 'Total';

			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			
			$pdf->SetFont('Times','BU',14);
			$pdf->Cell(19,1,$nombre,0,0,'C');
			$pdf->Ln(1);
			$pdf->Ln(1);
			$pdf->SetFont('Times','B',14);
			$pdf->SetDrawColor(0,80,180);
			$pdf->SetFillColor(430,430,10);
			$pdf->SetLineWidth(0.08);
			$pdf->Cell(6, 1, "Libro", 1, 0, 'C');
			$pdf->Cell(5, 1, "Autor(es)", 1, 0, 'C');
			$pdf->Cell(5, 1, "Unidades Disponibles", 1, 1, 'C');
			$pdf->Ln();
			$pdf->SetFont('Times','',12);

			for ($i=0; $i < count($libros); $i++) {
				$pdf->Cell(6, 1, $libros[$i], 1, 0, 'C');
				$pdf->Cell(5, 1, $autores[$i], 1, 0, 'C');
				$pdf->Cell(5, 1, $cant[$i], 1, 1, 'C');
			}
			$pdf->Ln();
			$pdf->Cell(11, 1, $totalText, 1, 0, 'C');
			$pdf->Cell(5, 1, $total, 1, 1, 'C');

			$pdf->Output();
		}elseif ($opc=='3') {
			$cantidad = $this->input->post('cantidadL');
			$nomL = $this->input->post('nomL');
			$biblioteca = $this->input->post('biblioteca');

			//Ya se tiene la informacion, se genera el reporte!
			$nombre = "Hay: ".$cantidad." Ejemplar(es) de: ".$nomL;
			$nombre2 = "En la biblioteca: ".$biblioteca;

			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','B',18);
			$pdf->Cell(19,1,$nombre,0,0,'C');
			$pdf->ln();
			$pdf->Cell(19,1,$nombre2,0,1,'C');

			$pdf->Output();
		}
	}

	public function fPDFRepo6(){

		$opc = $this->input->post('opcionhidden');
		if($opc=='1'){ //Solo hay filtro de  DERECHO
		//Obtener la informacion de la vista
			$header = $this->input->post('header');
			$meses = $this->input->post('meses');
			$cants = $this->input->post('cantP');
			$total = $this->input->post('total');

			//Ya se tiene la informacion, se genera el reporte!
			$nombre = "Biblioteca: ".$header;
			$totalText = 'Total';

			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			
			$pdf->SetFont('Times','BU',14);
			$pdf->Cell(19,1,$nombre,0,0,'C');
			$pdf->Ln(1);
			$pdf->Ln(1);
			$pdf->SetFont('Times','B',14);
			$pdf->SetDrawColor(0,80,180);
			$pdf->SetFillColor(430,430,10);
			$pdf->SetLineWidth(0.08);
			$pdf->Cell(3, 1, "Mes", 1, 0, 'C');
			$pdf->Cell(5, 1, "Cant. Prestamos.", 1, 1, 'C');
			$pdf->Ln();
			$pdf->SetFont('Times','',12);

			for ($i=0; $i < count($meses); $i++) {
				$pdf->Cell(3, 1, $meses[$i], 1, 0, 'C');
				$pdf->Cell(5, 1, $cants[$i], 1, 1, 'C');
			}
			$pdf->Cell(3, 1, $totalText, 1, 0, 'C');
			$pdf->Cell(5, 1, $total, 1, 1, 'C');

			$pdf->Output();
			
		}elseif($opc=='2') { //Solo hay filtro de MES
			$mes = $this->input->post('month');
			$biblios = $this->input->post('biblios');
			$cantP = $this->input->post('cantP');
			$total = $this->input->post('total');
			
			//Ya se tiene la informacion, se genera el reporte!
			$nombre = "Reporte Prestamos, Mes: ".$mes;
			$totalText = 'Total';

			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			
			$pdf->SetFont('Times','BU',14);
			$pdf->Cell(19,1,$nombre,0,0,'C');
			$pdf->Ln(1);
			$pdf->Ln(1);
			$pdf->SetFont('Times','B',14);
			$pdf->SetDrawColor(0,80,180);
			$pdf->SetFillColor(430,430,10);
			$pdf->SetLineWidth(0.08);
			$pdf->Cell(6, 1, "Biblioteca", 1, 0, 'C');
			$pdf->Cell(5, 1, "Cant. Prestamos", 1, 1, 'C');
			$pdf->Ln();
			$pdf->SetFont('Times','',12);

			for ($i=0; $i < count($biblios); $i++) {
				$pdf->Cell(6, 1, $biblios[$i], 1, 0, 'C');
				$pdf->Cell(5, 1, $cantP[$i], 1, 1, 'C');
			}
			$pdf->Ln();
			$pdf->Cell(6, 1, $totalText, 1, 0, 'C');
			$pdf->Cell(5, 1, $total, 1, 1, 'C');

			$pdf->Output();
		}elseif ($opc=='3') {
			$noPrestamos = $this->input->post('noPrestamos');
			$mes = $this->input->post('mes');
			$biblioteca = $this->input->post('biblioteca');

			//Ya se tiene la informacion, se genera el reporte!
			$nombre = "Hay: ".$noPrestamos." Prestamos en el mes de: ".$mes;
			$nombre2 = "En la biblioteca: ".$biblioteca;
			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			$pdf->SetFont('Arial','B',18);
			$pdf->Cell(19,1,$nombre,0,0,'C');
			$pdf->ln();
			$pdf->Cell(19,1,$nombre2,0,1,'C');

			$pdf->Output();
		}
	}

	public function ObtenNomMes($mes){
		if($mes == 1){
			return 'Enero';
		}elseif ($mes == 2) {
			return 'Febrero';
		}elseif ($mes == 3) {
			return 'Marzo';
		}elseif ($mes == 4) {
			return 'Abril';
		}elseif ($mes == 5) {
			return 'Mayo';
		}elseif ($mes == 6) {
			return 'Junio';
		}elseif ($mes == 7) {
			return 'Julio';
		}elseif ($mes == 8) {
			return 'Agosto';
		}elseif ($mes == 9) {
			return 'Septiembre';
		}elseif ($mes == 10) {
			return 'Octubre';
		}elseif ($mes == 11) {
			return 'Noviembre';
		}elseif ($mes == 12) {
			return 'Diciembre';
		}
	}

	public function generaRepo5(){ //Funcion para obtener datos del REPORTE1
		$tituloLibro = $this->input->post('tituloLibro5');
		$usr = $this->input->post('usr');
		
		if(($tituloLibro == 'vacio') and ($usr == 'vacio')){ //NO HAY NINGUN FILTRO
			$infoRepo['indicador'] = 0;
			echo json_encode($infoRepo);
		}elseif (($tituloLibro != 'vacio') and ($usr == 'vacio')) { //NO hay FILTRO USUARIO
			//HACERLO para TODOS los usuarios. PRESTAMOS DE TODOS LOS USUARIOS de ese libro
			$idLibro = $this->modelos->obtenIdLibro2($tituloLibro, 1);
			$infoRepo['tituloLibro'] = $tituloLibro;
			//Obtener todos los usuarios
			$usuarios = $this->modelos->obtenUsuarios(0);
			//Obtener la informacion de los prestamos de estos usuarios de ESE LIBRO
			for ($i=0; $i < count($usuarios) ; $i++) {
				$infoRepo[$i]['nomUsr'] = $usuarios[$i]['nom_usuario'];
				$infoRepo[$i]['infoPrestamo'] = $this->modelos->obtenInfoPrestamosLibroUsr($usuarios[$i]['id_usuario'], $idLibro, 1);
				for ($j=0; $j < count($infoRepo[$i]['infoPrestamo']); $j++) { 
					$infoRepo[$i]['infoPrestamo'][$j]['biblioteca'] = $this->modelos->obtenBiblioPrestamo($infoRepo[$i]['infoPrestamo'][$j]['id_prestamo']);
				}
				$infoRepo[$i]['totalPrestam'] = count($infoRepo[$i]['infoPrestamo']);
			}
			$infoRepo['indicador'] = 1;
			$infoRepo['length'] = count($infoRepo) -2;
			echo json_encode($infoRepo);
		}elseif(($tituloLibro == 'vacio') and ($usr != 'vacio')){ //NO HAY FILTRO DE TITULO PERO SI DE USUARIO, buscar todos los prestamos de ese usuario, de TODOS LOS LIBROS
			//Obtener la informacion de los prestamos de estos usuarios de ESE LIBRO
			$infoRepo['nomUsr'] = $usr;
			$idUsr = $this->modelos->obtenIdUser($usr);
			$infoRepo['infoPrestamo'] = $this->modelos->obtenInfoPrestamosLibroUsr($idUsr, NULL, 0);
			for ($j=0; $j < count($infoRepo['infoPrestamo']); $j++) { 
				$infoRepo['infoPrestamo'][$j]['biblioteca'] = $this->modelos->obtenBiblioPrestamo($infoRepo['infoPrestamo'][$j]['id_prestamo']);
				$infoRepo['infoPrestamo'][$j]['tituloLibro'] = $this->modelos->obtenTituloPrestamos($infoRepo['infoPrestamo'][$j]['id_prestamo']);
			}
			$infoRepo['totalPrestam'] = count($infoRepo['infoPrestamo']);
	
			$infoRepo['indicador'] = 2;
			$infoRepo['length'] = count($infoRepo) -2;
			echo json_encode($infoRepo);	
		}elseif (($tituloLibro != 'vacio') and ($nomBiblio != 'vacio')) { //Hay AMBOS filtros
			$infoRepo['biblioteca'] = $nomBiblio;
			$infoRepo['nomLibro'] = $tituloLibro;
			//Obtener el autor de ese libro
			$id_libro = $this->modelos->obtenIdLibro2($tituloLibro, 1);
			$infoRepo['autores'] =$this->modelos->obtenAutores($id_libro, 1);
			//Obtener la cantidad de un libro especifico en una biblioteca especifica 
			$infoRepo['cantidad'] = $this->modelos->cuentaLibrosEnBiblio2($id_libro,$idBiblio);
			$infoRepo['indicador'] = 3;
			echo json_encode($infoRepo);
		}
	}

	public function generaRepo6(){
		$nomBiblio = $this->input->post('nomBiblio6');
		$mes = $this->input->post('mes');

		if(($mes == 'vacio') and ($nomBiblio == 'vacio')){ //NO HAY NINGUN FILTRO
			$infoRepo['indicador'] = 0;
			echo json_encode($infoRepo);
		}elseif (($mes != 'vacio') and ($nomBiblio == 'vacio')) { //NO hay FILTRO BIBLIOTECA SOLO MES
			//Como NO hay filtro de biblioteca, contar para TODAS las bibliotecas :C
			//22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222
			$idAllbiblios = $this->modelos->obtenIdBiblio('Null', 0); //Obtiene TODAS las biblios
			$infoRepo['TotalP'] = 0;
			for ($i=0; $i <count($idAllbiblios) ; $i++) {
				$infoRepo[$i]['biblioteca'] = $idAllbiblios[$i]['nom_biblioteca'];
				$infoRepo[$i]['cantPrestam'] = $this->modelos->cuentaPrestamos($idAllbiblios[$i]['nom_biblioteca'], $mes);
				$infoRepo['TotalP'] = $infoRepo['TotalP'] + intval($infoRepo[$i]['cantPrestam']);
			}
			$infoRepo['indicador'] = 2;
			$infoRepo['length'] = count($infoRepo) -3;
			$infoRepo['mes'] = $this->ObtenNomMes(intval($mes));
			echo json_encode($infoRepo);
		}elseif(($mes == 'vacio') and ($nomBiblio != 'vacio')){ //SOLO HAY FILTRO DE biblioteca NO de mes
			// 111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111
			$infoRepo['indicador'] = 1;
			$infoRepo['biblioteca'] = $nomBiblio;
			$infoRepo['TotalP'] = 0;
			//Obtener TODOS los Prestamos de esa biblioteca en TODOS los meses
			for ($i=1; $i < 13 ; $i++) { 
				$infoRepo[$i]['mes'] = $this->ObtenNomMes(intval($i));
				$infoRepo[$i]['cantPrestam'] = $this->modelos->cuentaPrestamos($nomBiblio, $i);
				$infoRepo['TotalP'] = $infoRepo['TotalP'] + intval($infoRepo[$i]['cantPrestam']);
			}
			echo json_encode($infoRepo);		
		}elseif (($mes != 'vacio') and ($nomBiblio != 'vacio')) { //Hay AMBOS filtros
			//333333333333333333333333333333333333333333333333333333333333333333333333333333333333333333
			$infoRepo['noPrestamos'] = $this->modelos->cuentaPrestamos($nomBiblio, $mes);
			$infoRepo['biblioteca'] = $nomBiblio;
			$infoRepo['mes'] = $this->ObtenNomMes(intval($mes));;
			$infoRepo['indicador'] = 3;
			echo json_encode($infoRepo);
		}
	}

	public function generaRepo2(){
		$tituloLibro = $this->input->post('tituloLibro2');
		$nomBiblio = $this->input->post('nomBiblio2');
		$D_ini = $this->input->post('D_ini');
		$D_fin = $this->input->post('D_fin');

		if((($tituloLibro == 'vacio') and ($nomBiblio == 'vacio')) or $D_ini == ' ' or $D_fin == '' ){ //NO HAY FILTRO
			$infoRepo['indicador'] = 0;
			echo json_encode($infoRepo);
		}elseif (($tituloLibro != 'vacio') and ($nomBiblio == 'vacio')) { //NO hay FILTRO BIBLIOTECA
			//O SEA, PRESTAMOS DE ESE TITULO EN TODAS LAS BIBLIOTECAS, TOTAL PRESTAMOS AL FINAL 
			$idL = $this->modelos->obtenIdLibro2($tituloLibro, 1);
			$infoAllBiblios = $this->modelos->obtenIdBiblio('Null', 0); //la informacion de TODAS las biblios
			$infoRepo['TotalP'] = 0;
			for ($i=0; $i < count($infoAllBiblios) ; $i++) {
				$infoRepo[$i]['biblioteca'] = $infoAllBiblios[$i]['nom_biblioteca'];
				$infoRepo[$i]['cantPrestam'] = $this->modelos->cuentaPrestamosWithDate($infoRepo[$i]['biblioteca'], $idL, $D_ini, $D_fin);
				$infoRepo['TotalP'] =  $infoRepo['TotalP'] + intval($infoRepo[$i]['cantPrestam']);
			}

			//Obtener los autores del libro seleccionado
			$infoRepo['titulo'] = $tituloLibro;
			$infoRepo['D_ini'] = $D_ini;
			$infoRepo['D_fin'] = $D_fin;
			$infoRepo['cantB'] = count($infoAllBiblios);
			$infoRepo['indicador'] = 1;
			echo json_encode($infoRepo);
		}elseif(($tituloLibro == 'vacio') and ($nomBiblio != 'vacio')){ //NO HAY FILTRO DE TITULO PERO SI DE BIBLIOTECA Mostrar todos los libros (?) !!!!!!!!!!! y sus prestamos
			$infoRepo['indicador'] = 2;
			$infoRepo['totalGlobal'] = 0;
			$infoRepo['biblioteca'] = $nomBiblio;
			$idBiblio = $this->modelos->obtenIdBiblio($nomBiblio, 1);
			//Obtener TODOS los libros de esa biblioteca
			$infoRepo['libros'] = $this->modelos->obtenLibros($idBiblio,1);
			//Obtener los PRESTAMOS  de cada titulo en ESA BIBLIOTECA
			for ($i=0; $i < count($infoRepo['libros']) ; $i++) { 
				$idLibro = $this->modelos->obtenIdLibro2($infoRepo['libros'][$i]['titulo'], 1);
				$infoRepo['libros'][$i]['cantPrestam'] = $this->modelos->cuentaPrestamosWithDate($nomBiblio, $idLibro, $D_ini, $D_fin);
				$infoRepo['totalGlobal'] = $infoRepo['totalGlobal'] + intval($infoRepo['libros'][$i]['cantPrestam']);
			}
			echo json_encode($infoRepo);			
		}elseif (($tituloLibro != 'vacio') and ($nomBiblio != 'vacio')) { //Hay AMBOS filtros
			//OBTENER LOS PRESTAMOS DE ESE LIBRO EN ESA BIBLIOTECA EN ESE LAPSO DE TIEMPO
			$infoRepo['biblioteca'] = $nomBiblio;
			$infoRepo['nomLibro'] = $tituloLibro;
			$idLibro = $this->modelos->obtenIdLibro2($tituloLibro, 1);
			$infoRepo['cantPrestam'] = $this->modelos->cuentaPrestamosWithDate($nomBiblio, $idLibro, $D_ini, $D_fin);
			$infoRepo['D_ini'] = $D_ini;
			$infoRepo['D_fin'] = $D_fin;
			$infoRepo['indicador'] = 3;
			echo json_encode($infoRepo);
		}
	}

	public function fPDFRepo2(){
		$opc = $this->input->post('opcionhidden');
		if($opc=='1'){ //Solo hay filtro de  TITULO
		//Obtener la informacion de la vista
			$tituloL = $this->input->post('titulo');
			$D_ini = $this->input->post('D_ini');
			$D_fin = $this->input->post('D_fin');
			$biblios = $this->input->post('biblioteca');
			$cant = $this->input->post('cant');
			$total = $this->input->post('total');

			//Ya se tiene la informacion, se genera el reporte!
			$header = "Titulo del libro:    ".$tituloL;
			$header2 = "Prestamos del:   ".$D_ini."     al:  ".$D_ini." .";
			$totalText = 'Total';

			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(19,1,$header,0,0,'C');
			$pdf->Ln(1);
			$pdf->Cell(19,1,$header2,0,0,'C');
			$pdf->Ln(1);
			$pdf->Ln(1);
			$pdf->SetFont('Times','B',14);
			$pdf->SetDrawColor(0,80,180);
			$pdf->SetFillColor(430,430,10);
			$pdf->SetLineWidth(0.08);
			$pdf->Cell(3, 1, "Biblioteca", 1, 0, 'C');
			$pdf->Cell(5, 1, "Cant. Prestamos.", 1, 1, 'C');
			$pdf->Ln();
			$pdf->SetFont('Times','',12);

			for ($i=0; $i < count($biblios); $i++) {
				$pdf->Cell(3, 1, $biblios[$i], 1, 0, 'C');
				$pdf->Cell(5, 1, $cant[$i], 1, 1, 'C');
			}
			$pdf->Cell(3, 1, $totalText, 1, 0, 'C');
			$pdf->Cell(5, 1, $total, 1, 1, 'C');

			$pdf->Output();
			
		}elseif($opc=='2') { //Solo hay filtro de MES
			$biblio = $this->input->post('bibliO');
			$libros = $this->input->post('libros');
			$cantP = $this->input->post('cantP');
			$total = $this->input->post('total');
			
			//Ya se tiene la informacion, se genera el reporte!
			$header = "Reporte Prestamos de la biblioteca:    ".$biblio;
			$totalText = 'Total';

			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(19,1,$header,0,0,'C');
			$pdf->Ln(1);
			$pdf->Ln(1);
			$pdf->SetFont('Times','B',14);
			$pdf->SetDrawColor(0,80,180);
			$pdf->SetFillColor(430,430,10);
			$pdf->SetLineWidth(0.08);
			$pdf->Cell(6, 1, "Libro", 1, 0, 'C');
			$pdf->Cell(5, 1, "Cant. Prestamos", 1, 1, 'C');
			$pdf->Ln();
			$pdf->SetFont('Times','',12);

			for ($i=0; $i < count($libros); $i++) {
				$pdf->Cell(6, 1, $libros[$i], 1, 0, 'C');
				$pdf->Cell(5, 1, $cantP[$i], 1, 1, 'C');
			}
			$pdf->Ln();
			$pdf->Cell(6, 1, $totalText, 1, 0, 'C');
			$pdf->Cell(5, 1, $total, 1, 1, 'C');

			$pdf->Output();
		}elseif ($opc=='3') {
			$cantPrestam = $this->input->post('cantPrestam');
			if ($cantPrestam == NULL) {
				$cantPrestam = '0';
			}
			$nomL = $this->input->post('nomL');
			$biblioteca = $this->input->post('biblioteca');
			$D_ini = $this->input->post('D_i');
			$D_fin = $this->input->post('D_fin');

			//Ya se tiene la informacion, se genera el reporte!
			$header = "Hay:   ".$cantPrestam."    Prestamos de:   ".$nomL;
			$header1_5 = "En la biblioteca:   ".$biblioteca;
			$header2 = "Del:   ".$D_ini."   al:   ".$D_fin;
			$pdf = new PDF('P', 'cm', 'a4');
			$pdf->AddPage();
			
			$pdf->SetFont('Arial','B',18);
			$pdf->Cell(19,1,$header,0,0,'I');
			$pdf->ln();
			$pdf->Cell(19,1,$header1_5,0,0,'I');
			$pdf->ln();
			$pdf->Cell(19,1,$header2,0,1,'I');

			$pdf->Output();
		}
	}

	public function checaN(){
		$tituloLibro = $this->input->post('tituloLibro5');
		$usr = $this->input->post('usr');
		
		if(($tituloLibro == 'vacio') and ($usr == 'vacio')){ //NO HAY NINGUN FILTRO
			$infoRepo['indicador'] = 0;
			echo json_encode($infoRepo);
		}elseif (($tituloLibro != 'vacio') and ($usr == 'vacio')) { //NO hay FILTRO USUARIO
			//HACERLO para TODOS los usuarios. PRESTAMOS DE TODOS LOS USUARIOS de ese libro
			$idLibro = $this->modelos->obtenIdLibro2($tituloLibro, 1);
			$infoRepo['tituloLibro'] = $tituloLibro;
			//Obtener todos los usuarios
			$usuarios = $this->modelos->obtenUsuarios(0);
			//Obtener la informacion de los prestamos de estos usuarios de ESE LIBRO
			for ($i=0; $i < count($usuarios) ; $i++) {
				$infoRepo[$i]['nomUsr'] = $usuarios[$i]['nom_usuario'];
				$infoRepo[$i]['infoPrestamo'] = $this->modelos->obtenInfoPrestamosLibroUsr($usuarios[$i]['id_usuario'], $idLibro, 1);
				for ($j=0; $j < count($infoRepo[$i]['infoPrestamo']); $j++) { 
					$infoRepo[$i]['infoPrestamo'][$j]['biblioteca'] = $this->modelos->obtenBiblioPrestamo($infoRepo[$i]['infoPrestamo'][$j]['id_prestamo']);
				}
				$infoRepo[$i]['totalPrestam'] = count($infoRepo[$i]['infoPrestamo']);
			}
			$infoRepo['indicador'] = 1;
			$infoRepo['length'] = count($infoRepo) -2;
			echo json_encode($infoRepo);
		}elseif(($tituloLibro == 'vacio') and ($usr != 'vacio')){ //NO HAY FILTRO DE TITULO PERO SI DE USUARIO, buscar todos los prestamos de ese usuario, de TODOS LOS LIBROS
			//Obtener la informacion de los prestamos de estos usuarios de ESE LIBRO
			$infoRepo['nomUsr'] = $usr;
			$idUsr = $this->modelos->obtenIdUser($usr);
			$infoRepo['infoPrestamo'] = $this->modelos->obtenInfoPrestamosLibroUsr($idUsr, NULL, 0);
			for ($j=0; $j < count($infoRepo['infoPrestamo']); $j++) { 
				$infoRepo['infoPrestamo'][$j]['biblioteca'] = $this->modelos->obtenBiblioPrestamo($infoRepo['infoPrestamo'][$j]['id_prestamo']);
				$infoRepo['infoPrestamo'][$j]['tituloLibro'] = $this->modelos->obtenTituloPrestamos($infoRepo['infoPrestamo'][$j]['id_prestamo']);
			}
			$infoRepo['totalPrestam'] = count($infoRepo['infoPrestamo']);
	
			$infoRepo['indicador'] = 1;
			$infoRepo['length'] = count($infoRepo) -2;
			echo json_encode($infoRepo);	
		}elseif (($tituloLibro != 'vacio') and ($nomBiblio != 'vacio')) { //Hay AMBOS filtros
			$infoRepo['biblioteca'] = $nomBiblio;
			$infoRepo['nomLibro'] = $tituloLibro;
			//Obtener el autor de ese libro
			$id_libro = $this->modelos->obtenIdLibro2($tituloLibro, 1);
			$infoRepo['autores'] =$this->modelos->obtenAutores($id_libro, 1);
			//Obtener la cantidad de un libro especifico en una biblioteca especifica 
			$infoRepo['cantidad'] = $this->modelos->cuentaLibrosEnBiblio2($id_libro,$idBiblio);
			$infoRepo['indicador'] = 3;
			echo json_encode($infoRepo);
		}
	}

	public function obtenLibro(){
		$nombre = $this->input->post('nombreLibro');
		$idLibro = $this->modelos->obtenIdLibro($nombre);
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
					$idLibro[$i]['bibliotecas'][$j]['id_biblioteca'] = $this->modelos->obtenNombreBibli($numbibli); 
				}

			}
			echo json_encode($idLibro);			
		}
	}

	function mostrar(){
		if ($this->input->is_ajax_request()){
			$buscar = $this->input->post('buscar');
			$datos = $this->modelos->mostrar($buscar);
			echo json_encode($datos);

		}

	}
	public function registroLibrosAleatorios(){
		//set_time_limit(14000);
				$conect = array("La","El", "Los", "Con", "En");
				$verbos = array("Abandonar","Abochornar","Abrazar","Abrir","Acabar","Aceptar","Acompañar","Acordar","Acosar","Acostumbrar","Actuar","Adjetivar","Administrar","Admitir","Adquirir","Advertir","Afectar","Afirmar","Agarrar","Ahogar","Amar","Amasar","Amedrentar","Amotinar","Animar","Aniquilar","Añorar","Apabullar","Apachurrar","Aplanar","Aportar","Aprender","Apretar","Bailar","Bajar","Beber","Besar","Brincar","Buscar","Caminar");

				$adjetivos = array("a muerte","a primera sangre","abierta","abiertas","abierto","abiertos","abrumador","abrumadoras","abrumadores","abrupta","abruptas","abrupto","abruptos","absoluta","absolutas","absoluto","absolutos","abstracta","abstractas","abstracto" ,"abstractos" ,"absurda" ,"absurdas" ,"absurdo" ,"absurdos" ,"abundante" ,"abundantes" ,"abundosa" ,"abundosas" ,"abundoso" ,"abundosos" ,"académica" ,"Académicas" ,"académico" ,"académicos" ,"aceptable" ,"aceptables" ,"acertada" ,"acertadas" ,"acertado" ,"acertados" ,"ácida" ,"ácidas" ,"ácido" ,"ácidos" ,"activa" ,"activas" ,"activo" ,"activos" ,"actual" ,"actuales" ,"acuosa" ,"acuosas" ,"acuoso" ,"acuosos" ,"adecuada","adecuadas" ,"adecuado" ,"adecuados" ,"adicional" ,"adicionales" ,"administrativa" ,"administrativas" ,"administrativo","administrativos","amarilla","amarillas","amarillo","amarillos","ambiciosa","ambiciosas","ambicioso","ambiciosos","ambiental","ambientales","ambigua","ambiguas","amiguo","ambiguos");
				for ($i=0; $i <100000 ; $i++) { 
			  		# code...
			  	
				  	$indexConector = rand(0,4);
				  	$isbn = rand(10,99).rand(10,99).rand(10,99).rand(10,99);
				  	$id_clasificacion = rand(1,5);
				  	$id_editorial = rand(1,7);
				  	$indexVerbo = rand(0,39);
				  	$indexAdjetivos = rand(0,78);
				  	$titulo = $verbos[$indexVerbo]." ".$conect[$indexConector]." ".$adjetivos[$indexAdjetivos];
				  	$this->modelos->agregaLibro($titulo, $isbn, $id_clasificacion, $id_editorial);	
			  	}

	}
	public function agregaLibroBiblioteca(){
		//set_time_limit(14000);
		for ($i=0; $i <50000 ; $i++) { 
			# code...
		
			$id_libro= rand(1,100229);
			$id_biblioteca = rand(1,5);
			$prestado = rand(0,1);
			$this->modelos->agregaLibroBiblioteca($id_libro,$id_biblioteca,$prestado);
	}	
}

	public function agregaPrestamos(){
		//set_time_limit(14000);
		for ($i=0; $i <50000 ; $i++) { 
			# code...
		
		$id_empleado = rand(1,2);
		$id_usuario = rand(1,2);
		//$num_inve= rand(1,50052);
		$fecha_prest = "2018-".rand(1,12)."-".rand(1,30);
		$id_biblioteca = rand(1,5);
		$num_inve = $this->modelos->buscaNumInv($id_biblioteca);

		 $this->modelos->agregarPrestamos($id_empleado,$id_usuario,$num_inve,$fecha_prest);
		}


	}






/*
	public function generaRegistros(){
		set_time_limit(8640);
	  	$nombre = array("Diego","Diana","Marcos","Maria","Luis","Fernanda","Irvin","Mario","Katia","Mariana","Jonathan","Juan","Angelo","Francisco","Sara","Ana","Alberto","Jose","Laura","Samantha","Valeria","Giovanny","Guillermo","Uriel","Ramon","Isabel","Hugo","Carla","Martha","Edgar","Marcela","Joshua","Ignacio","Monserrat","Daniel","Paola","Josue","Eva","Elena","Sergio","Lucia","Isai","David","Lourdes","Adrian","Ivanna","Miguel","Abel","Julia","Brenda"); 

	  	$a_paterno = array("Acevedo","Garcia","Morales","Jimenez","Contreras","Aguirre","Soteno","Gutierrez","Alcantara","Escorza","Flores","Rodriguez","Anaya","Lopez","Arellano","Ramirez","Barrera","Gonzalez","Colin","Campos","Chavez","Echeverria","Cuevas","Duarte","Espinosa","Fernandez","Gomez","Granados","Heras","Linares","Mendoza","Aguilar","Ortega","Estevez","Zuñiga","Sierra","Sanchez","Torres","Uribe","Diaz","Trujillo","Zamora","Toledo","Patiño","Quintana","Salazar","Luna","Medrano","Ochoa","Navarro");
	  	$a_materno = array("Acevedo","Garcia","Morales","Jimenez","Contreras","Aguirre","Soteno","Gutierrez","Alcantara","Escorza","Flores","Rodriguez","Anaya","Lopez","Arellano","Ramirez","Barrera","Gonzalez","Colin","Campos","Chavez","Echeverria","Cuevas","Duarte","Espinosa","Fernandez","Gomez","Granados","Heras","Linares","Mendoza","Aguilar","Ortega","Estevez","Zuñiga","Sierra","Sanchez","Torres","Uribe","Diaz","Trujillo","Zamora","Toledo","Patiño","Quintana","Salazar","Luna","Medrano","Ochoa","Navarro");
	  	$direccion = array("CALLE AGUSTIN LARA NO. 69-B","AV. INDEPENDENCIA NO. 241","AV. 20 DE NOVIEMBRE NO.1024","CARRETERA A LOMA ALTA S/N.","AV. 20 DE NOVIEMBRE NO. 1060","CALLE ZARAGOZA NO. 1010","CALLE MATAMOROS NO. 310","AV. 20 DE NOVIEMBRE NO.859-B","AV. 20 DE NOVIEMBRE NO 1053","BLVD. BENITO JUAREZ NO. 1466-A");
	  	$t_empleado =array("supervisor","trabajador");
	  	
	  	for ($i=389691; $i < 500000; $i++) {
	  		if ($i==1234){
	  			$i = 500000+1;
	  		}
	  		$numeroNombre = rand(0,49);
	  		$numeroApellidoP = rand(0,49);
	  		$numeroApellidoM = rand(0,49);
	  		$numeroDirecciones = rand(0,8);
	  		$numeroTipoEmpleado = rand(0,1);
	  		$numeroClaveJefe = rand(1,5);

	  		$nombregeneral = $nombre[$numeroNombre]+$a_paterno[$numeroApellidoP]+$a_materno[$numeroApellidoM];

	  		$resultado = $this->Usuarios_model->ingresar_usuario($i,$nombre[$numeroNombre],$a_paterno[$numeroApellidoP],$a_materno[$numeroApellidoM],$direccion[$numeroDirecciones],"2017-12-08","",$t_empleado[$numeroTipoEmpleado],$numeroTipoEmpleado,$numeroClaveJefe,"");
	  		}
			
	  	
	  	
	  }*/
	public function fEditEditoriales(){ 
		//Obtener TODAS los EDITORIALES = 0, uno en especifico, entra su id
		$this->editorialesOrig = $this->modelos->obtenEditoriales(0);
		$_SESSION["editOrig"] = $this->editorialesOrig;
		$this->lastIdEdit = $this->modelos->obtenLastId();

		//Ya se tiene TODAS las editoriales, solo queda enviarsela a una vista que despliegue los que el usuario quiera en ese momoento
	
		$this->load->view('VEditEditorial3', $this->editorialesOrig, $this->lastIdEdit);
	}

	public function agregaAutor(){
		$this->autoresOrig = $this->modelos->obtenAutores(0,0);
		$_SESSION["autorOrig"] = $this->autoresOrig;
		$this->lastIdAutor = $this->modelos->obtenLastIdAutor();

		//Ya se tiene TODAS las editoriales, solo queda enviarsela a una vista que despliegue los que el usuario quiera en ese momoento
	
		$this->load->view('VADDautor', $this->autoresOrig, $this->lastIdAutor);
	}

	public function agregaTemas(){
		$this->temasOrig = $this->modelos->obtenTemas(0);
		$_SESSION["temasOrig"] = $this->temasOrig;
		$this->lastIdTemas = $this->modelos->obtenLastIdTemas();

		//Ya se tiene TODAS las editoriales, solo queda enviarsela a una vista que despliegue los que el usuario quiera en ese momoento
	
		$this->load->view('VADDtemas', $this->temasOrig, $this->lastIdTemas);
	}

	public function agregarLibros(){
		$this->temas = $this->modelos->obtenTemas(0);
		$this->editoriales = $this->modelos->obtenEditoriales(0);
		$this->load->view('VADDLibros',$this->temas,$this->editoriales);
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
	public function fdoAutor(){
		$this->nomAutor = $this->input->post('nom');
		$this->idAutor = $this->input->post('id');
		//Juntar la información en un solo vector (id, nombre)
		for ($i=0; $i < count($this->nomAutor); $i++) { 
			$j = 0;
			$this->infoNewEdit2[$i][$j] = $this->nomAutor[$i];
			$j = $j+1;
			$this->infoNewEdit2[$i][$j] = $this->idAutor[$i];
		}
		//Hacer UPDATE  de los cambios en los editoriales
		$this->modelos->updateAutores($_SESSION["editOrig"], $this->infoNewEdit2);
		$this->load->view('vDone2downLevel');
	}
	public function fdoTema(){
		$this->nomTema = $this->input->post('nom');
		$this->idTema = $this->input->post('id');
		//Juntar la información en un solo vector (id, nombre)
		for ($i=0; $i < count($this->nomTema); $i++) { 
			$j = 0;
			$this->infoNewEdit2[$i][$j] = $this->nomTema[$i];
			$j = $j+1;
			$this->infoNewEdit2[$i][$j] = $this->idTema[$i];
		}
		//Hacer UPDATE  de los cambios en los editoriales
		$this->modelos->updateTemas($_SESSION["editOrig"], $this->infoNewEdit2);
		$this->load->view('vDone2downLevel');

	}




	public function fcargaVRepo(){ //Funcion para cargar la vista de los reportes
		$this->titulos = $this->modelos->obtenTitulos(NULL,0);
		$this->biblios = $this->modelos->obtenBiblios(0);
		$this->usrs = $this->modelos->obtenUsuarios(0);
		$this->load->view('vReportes', $this->titulos, $this->biblios, $this->usrs);
	}


}