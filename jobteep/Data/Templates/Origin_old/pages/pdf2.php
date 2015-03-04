<?php 
require_once 'Libraries/PDF/Pdf.class.php';

$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();


/*$pdf->Image($program->getDir()."img/bg_pdf.jpg", 0, 0, 220, 300);*/


//Cabecera
$pdf->Image($program->getDir()."img/bg.png", 0, 0, 220, 80);

//TARJETA INFO BÁSICA

//Fondo
$pdf->SetFillColor(255,255,255);

//Imagen de perfil
$pdf->Image("Data/Users/".$info['user']."/".$info['img'], 15, 95, 60, 60);

//Nombre
$pdf->SetXY(15, 160);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(60, 6, utf8_decode($info['name']. ' '.$info['surname']));

//Profesión
$pdf->SetY(15, $pdf->GetY()+7);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(60, 6, utf8_decode($info['profession']));

//Dirección
$pdf->SetXY(15, 182);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(60, 6, utf8_decode($info['address']));

//Ciudad, país
$pdf->SetXY(15, 196);
$pdf->Cell(60, 6, utf8_decode($info['city']. ', '.$info['country']), 0, 0, 'L');

//Email
$pdf->SetXY(15, 203);
$pdf->MultiCell(60, 6, utf8_decode($info['email']));

//Web
$pdf->SetXY(15, 217);
$pdf->Cell(60, 6, utf8_decode($info['web']), 0, 0, 'L');



//TARJETA TRABAJOS

//Trabajos
$controller->setEnum('experience');
$order = 'start_date DESC';
$experience = $controller->selectAllElements($UID, $order);
/*$rect_h = ($experience->num_rows * 6 * 2) + 35;*/

//Fondo
/*$pdf->SetFillColor(255,255,255);
$pdf->Rect(85, 90, 115, $rect_h, 'F');*/

//Icono
$pdf->SetXY(90, 95);
$pdf->Image($program->getDir()."img/works.png", null, null, 10, 10);

//Titulo
$pdf->SetXY(103, 98);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(46, 41, 100);
$pdf->Cell(47.5, 5, "Trabajos", 0, 0, 'L');

$pdf->SetFont('Arial','',10);
$pdf->SetXY(90, 110);
for ($i = 0; $i < $experience->num_rows; $i++) {
	$experience->data_seek($i);
	$row = $experience->fetch_assoc();
	//FORMATO FECHA
	$start_date = $controller->getDateElement($row['start_date']);
	$end_date = $controller->getDateElement($row['end_date']);
	if ($start_date != '' && $end_date == '')
		$end_date = 'Actualidad';
	$text = $start_date.' - '.$end_date.' -> '.utf8_decode($row['position']).' en '.utf8_decode($row['company']);
	
	$pdf->SetXY(90, $pdf->GetY()+2);
	$pdf->MultiCell(105, 6, $text);
}
$text = '';
unset($row);



//TARJETA ESTUDIOS
$pdf->SetXY(90, $pdf->GetY()+30);

//ESTUDIOS
$controller->setEnum('education');
$order = 'start_date DESC';
$obj = $controller->selectAllElements($UID, $order);
/*$rect_h = ($obj->num_rows * 6 * 2) + 35;*/

//Fondo
/*$pdf->SetFillColor(255,255,255);
$pdf->Rect(85, $pdf->GetY(), 115, $rect_h, 'F');*/

//Icono
$pdf->SetXY(90, $pdf->GetY()+5);
$pdf->Image($program->getDir()."img/education.png", null, null, 10, 10);

//Titulo
$pdf->SetXY(103, $pdf->GetY()-7);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(241,72,69);
$pdf->Cell(47.5, 5, "Estudios", 0, 0, 'L');

$pdf->SetFont('Arial','',10);
$pdf->SetXY(90, $pdf->GetY()+12);
for ($i = 0; $i < $obj->num_rows; $i++) {
	$obj->data_seek($i);
	$row = $obj->fetch_assoc();
	//FORMATO FECHA
	$start_date = $controller->getDateElement($row['start_date']);
	$end_date = $controller->getDateElement($row['end_date']);
	if ($start_date != '&nbsp' && $end_date == '&nbsp')
		$end_date = 'Actualidad';
	$text = $start_date.' - '.$end_date.' -> '.utf8_decode($row['titulation']).' en '.utf8_decode($row['nameCenter']);

	$pdf->SetXY(90, $pdf->GetY()+2);
	$pdf->MultiCell(105, 6, $text);
}

$text = '';
unset($obj);
unset($row);



//TARJETA IDIOMAS
$pdf->SetXY(90, $pdf->GetY()+25);

$controller->setEnum('language');
$order = 'name ASC';
$obj = $controller->selectAllElements($UID, $order);
/*$rect_h = ($obj->num_rows * 6) + 35;

//Fondo
$pdf->SetFillColor(255,255,255);
$pdf->Rect(85, $pdf->GetY(), 115, $rect_h, 'F');*/

//Icono
$pdf->SetXY(90, $pdf->GetY()+5);
$pdf->Image($program->getDir()."img/languages.png", null, null, 10, 10);

//Titulo
$pdf->SetXY(103, $pdf->GetY()-7);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(50,75,94);
$pdf->Cell(47.5, 5, "Idiomas", 0, 0, 'L');

$pdf->SetFont('Arial','',10);
$pdf->SetXY(90, $pdf->GetY()+12);
$img_language = array("dots20.png", "dots40.png", "dots60.png", "dots80.png", "dots100.png");
for ($i = 0; $i < $obj->num_rows; $i++) {
	$obj->data_seek($i);
	$row = $obj->fetch_assoc();
	$text = utf8_decode($row['name']);
	$pdf->SetXY(90, $pdf->GetY()+2);
	$pdf->MultiCell(105, 6, $text);
	$pdf->SetXY(120, $pdf->GetY()-7);
	$pdf->Image($program->getDir()."img/".$img_language[$row['level']], null, null, 65, 7);
}

$text = '';
unset($obj);
unset($row);

$pdf->Output();
?>