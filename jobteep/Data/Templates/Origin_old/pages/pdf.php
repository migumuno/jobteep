<?php
require_once 'Libraries/PDF/Pdf.class.php';

$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();

//CABECERA
/*$pdf->Image($program->getDir()."img/bg.png", 0, 0, 220, 80);*/

//TARJETA INFO BÁSICA
$pdf->Image("Data/Users/".$info['user']."/".$info['img'], 10, 10, 60, 60);

//Nombre
$pdf->SetY(75);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(60, 6, utf8_decode($info['name']. ' '.$info['surname']));

//Profesión
$pdf->SetFont('Arial','B',12);
if (isset($info['profession']) && $info['profession'] != '')
	$pdf->MultiCell(60, 6, utf8_decode($info['profession']));

//Dirección
$pdf->SetY($pdf->GetY()+6);
$pdf->SetFont('Arial','',12);
if (isset($info['address']) && $info['address'] != '')
	$pdf->MultiCell(60, 6, utf8_decode($info['address']));

//Ciudad, país
$pdf->MultiCell(60, 6, utf8_decode($info['city']. ', '.$info['country']));

//Email
if (isset($info['email']) && $info['email'] != '')
	$pdf->MultiCell(60, 6, utf8_decode($info['email']));

//Web
if (isset($info['web']) && $info['web'] != '')
	$pdf->MultiCell(60, 6, utf8_decode($info['web']));


//SOBRE MI
/*$pdf->SetY($pdf->GetY()+12);
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(47.5, 6, "Sobre mi");
$pdf->SetX(10);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(60, 6, html_entity_decode(utf8_decode($info['description'])));*/



//TRABAJOS
$controller->setEnum('experience');
$order = 'start_date DESC';
$obj = $controller->selectAllElements($UID, $order);

//Icono
$pdf->SetXY(90, 10);
$pdf->Image($program->getDir()."img/works.png", null, null, 10, 10);

//Título
$pdf->SetXY(103, 13);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(46, 41, 100);
$pdf->Cell(47.5, 5, "Trabajos", 0, 0, 'L');

//Trabajos
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
	else if($start_date == '&nbsp' && $end_date == '&nbsp') {
		$start_date = '';
		$end_date = '';
	} else if ($start_date == '&nbsp')
		$start_date = '';
	
	$text = $start_date.' - '.$end_date.' -> '.utf8_decode($row['position']).' en '.utf8_decode($row['company']);

	$pdf->SetXY(90, $pdf->GetY()+2);
	$pdf->MultiCell(105, 6, $text);
}

//ESTUDIOS
$controller->setEnum('education');
$order = 'start_date DESC';
$obj = $controller->selectAllElements($UID, $order);

//Icono
$pdf->SetXY(90, $pdf->GetY()+15);
$pdf->Image($program->getDir()."img/education.png", null, null, 10, 10);

//Título
$pdf->SetXY(103, $pdf->GetY()-7);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(241,72,69);
$pdf->Cell(47.5, 5, "Estudios", 0, 0, 'L');

//Estudios
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
	else if($start_date == '&nbsp' && $end_date == '&nbsp') {
		$start_date = '';
		$end_date = '';
	} else if ($start_date == '&nbsp')
		$start_date = '';

	$text = $start_date.' - '.$end_date.' -> '.utf8_decode($row['titulation']).' en '.utf8_decode($row['nameCenter']);

	$pdf->SetXY(90, $pdf->GetY()+2);
	$pdf->MultiCell(105, 6, $text);
}


//IDIOMAS
$controller->setEnum('language');
$order = 'name ASC';
$obj = $controller->selectAllElements($UID, $order);

//Icono
$pdf->SetXY(90, $pdf->GetY()+15);
$pdf->Image($program->getDir()."img/languages.png", null, null, 10, 10);

//Título
$pdf->SetXY(103, $pdf->GetY()-7);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(50,75,94);
$pdf->Cell(47.5, 5, "Idiomas", 0, 0, 'L');

//Idiomas
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
	$pdf->Image($program->getDir()."img/".$img_language[$row['level']], null, null, 60, 7);
}


//HABILIDADES
$controller->setEnum('skill');
$order = 'name ASC';
$obj = $controller->selectAllElements($UID, $order);

//Icono
$pdf->SetXY(90, $pdf->GetY()+15);
$pdf->Image($program->getDir()."img/skills.png", null, null, 10, 10);

//Título
$pdf->SetXY(103, $pdf->GetY()-7);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(252,156,61);
$pdf->Cell(47.5, 5, "Habilidades", 0, 0, 'L');

//Habilidades
$pdf->SetFont('Arial','',10);
$pdf->SetXY(90, $pdf->GetY()+12);
$img_skill = array("20.png", "40.png", "60.png", "80.png", "100.png");
for ($i = 0; $i < $obj->num_rows; $i++) {
	$obj->data_seek($i);
	$row = $obj->fetch_assoc();

	$text = utf8_decode($row['name']);
	$pdf->SetXY(90, $pdf->GetY()+2);
	$pdf->MultiCell(105, 6, $text);
	$pdf->SetXY(120, $pdf->GetY()-7);
	$pdf->Image($program->getDir()."img/".$img_skill[$row['level']], null, null, 60, 7);
}



//PROYECTOS
$controller->setEnum('proyect');
$order = 'start_date DESC';
$obj = $controller->selectAllElements($UID, $order);

//Icono
$pdf->SetXY(90, $pdf->GetY()+15);
$pdf->Image($program->getDir()."img/proyects.png", null, null, 10, 10);

//Título
$pdf->SetXY(103, $pdf->GetY()-7);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(5,149,205);
$pdf->Cell(47.5, 5, "Proyectos", 0, 0, 'L');

//Proyectos
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
	else if($start_date == '&nbsp' && $end_date == '&nbsp') {
		$start_date = '';
		$end_date = '';
	} else if ($start_date == '&nbsp')
		$start_date = '';

	$text = $start_date.' - '.$end_date.' -> '.utf8_decode($row['title']);

	$pdf->SetXY(90, $pdf->GetY()+2);
	$pdf->MultiCell(105, 6, $text);
}



//ACTIVIDADES
$controller->setEnum('activity');
$order = 'start_date DESC';
$obj = $controller->selectAllElements($UID, $order);

//Icono
$pdf->SetXY(90, $pdf->GetY()+15);
$pdf->Image($program->getDir()."img/activities.png", null, null, 10, 10);

//Título
$pdf->SetXY(103, $pdf->GetY()-7);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(237, 81, 127);
$pdf->Cell(47.5, 5, "Actividades", 0, 0, 'L');

//Actividades
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
	else if($start_date == '&nbsp' && $end_date == '&nbsp') {
		$start_date = '';
		$end_date = '';
	} else if ($start_date == '&nbsp')
		$start_date = '';

	$text = $start_date.' - '.$end_date.' -> '.utf8_decode($row['title']);

	$pdf->SetXY(90, $pdf->GetY()+2);
	$pdf->MultiCell(105, 6, $text);
}


$pdf->Output();
?>