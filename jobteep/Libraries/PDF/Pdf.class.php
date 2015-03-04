<?php
require_once 'Libraries/PDF/fpdf17/fpdf.php';

class PDF extends FPDF {
	
	//Cabecera de página
	function Header() {
		// Arial bold 15
		$this->SetFont('Arial','B',15);
		//Contenido
		
		// Salto de línea
		$this->Ln(20);
	}
	
	//Pie de página
	function Footer() {
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}
}
?>