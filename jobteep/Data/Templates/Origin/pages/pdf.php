<?php
header('Content-Type: text/html; charset=UTF-8');
require_once 'Libraries/PDF/Pdf.class.php';

class MyPDF extends FPDF{
	//Pie de página
	function Footer()
	{

		$this->SetY(-10);

		$this->SetFont('Arial','I',8);

		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$tildes = array("&aacute","&eacute","&iacute","&oacute","&uacute");
$tildes2 = array("á", "é", "í", "ó", "ú");

$pdf = new MyPDF();
$pdf->AliasNbPages();
$pdf->AddPage();

//TARJETA INFO BÁSICA
$pos = strpos($info['img'], 'http');
if (isset($info['img']) && $info['img'] != "") {
	if ($pos !== false)
		$pdf->Image($info['img'], 10, 10, 60, 60, 'JPEG');
	else 
		$pdf->Image("Data/Users/".$info['dir']."/".$info['img'], 10, 10, 60, 60);
}
	

//Nombre
$pdf->SetY(13);
$pdf->SetX(80);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(115, 6, utf8_decode($info['name']. ' '.$info['surname']));

//Qué eres
$pdf->SetXY(80,$pdf->GetY()+1);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(115, 6, utf8_decode(htmlspecialchars_decode($info['profession'])));

//Slogan
$pdf->SetXY(80,$pdf->GetY()+1);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(115, 6, '"'.utf8_decode($info['slogan']).'"');

//Email
$pdf->SetXY(80,$pdf->GetY()+3);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(163,163,163);
$pdf->MultiCell(115, 6, 'Email: '.utf8_decode($info['email']));

//Teléfono
$pdf->SetXY(80,$pdf->GetY()+1);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(163,163,163);
$pdf->MultiCell(115, 6, 'Telf.: '.utf8_decode($info['telf1']));

//Ciudad/País
$pdf->SetXY(80,$pdf->GetY()+1);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(163,163,163);
$pdf->MultiCell(115, 6, utf8_decode($info['city']).', '.utf8_decode($info['country']));

//Jobteep
$pdf->SetXY(80,$pdf->GetY()+1);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(163,163,163);
$pdf->MultiCell(115, 6, 'Jobteep: http://www.jobteep.com/'.utf8_decode($info['domain']));

//Linea
$pdf->SetDrawColor(163,163,163);
$pdf->SetLineWidth(0.4);
$pdf->Line(10, 75, 200, 75);

$pdf->SetY(78);

//Extracto
if (isset($info['description']) && $info['description'] != '') {
	//Título extracto
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(195, 6, 'EXTRACTO');
	
	$pdf->SetY($pdf->GetY()+1);
	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
	$description = html_entity_decode($info['description'], ENT_QUOTES);
	$pdf->MultiCell(185, 6, strip_tags(utf8_decode(html_entity_decode($description, ENT_QUOTES))));

	//Linea
	$pdf->SetDrawColor(163,163,163);
	$pdf->SetLineWidth(0.2);
	$pdf->Line(10, $pdf->GetY()+3, 200, $pdf->GetY()+3);
}

//TRABAJOS
if (count($trabajos) > 0) {
	//Título
	$pdf->SetY($pdf->GetY()+6);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(185, 6, 'EXPERIENCIA');
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($pdf->GetY()+1);
	foreach ($trabajos as $k => $v) {
		$pdf->SetTextColor(0,0,0);
		//Cargo y empresa
		$pdf->SetY($pdf->GetY()+5);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(185, 6, utf8_decode(html_entity_decode($v['position'], ENT_QUOTES)).' en '.utf8_decode(html_entity_decode($v['company'], ENT_QUOTES)));
		$pdf->SetFont('Arial','',10);
		
		//FORMATO FECHA
		if (isset($v['start_date']))
			$start_date = $controller->getDateElement($v['start_date']);
		else
			$start_date = '&nbsp';
		if (isset($v['start_date']))
			$end_date = $controller->getDateElement($v['end_date']);
		else
			$end_date = '&nbsp';
		if ($start_date != '&nbsp' && $end_date == '&nbsp')
			$end_date = 'Actualidad';
		else if($start_date == '&nbsp' && $end_date == '&nbsp') {
			$start_date = '';
			$end_date = '';
		} else if ($start_date == '&nbsp')
			$start_date = '';
		
		$text = $start_date.' - '.$end_date;
		//Fecha
		$pdf->SetY($pdf->GetY()+1);
		$pdf->MultiCell(185, 6, $text);
		
		if(isset($v['description']) && $v['description'] != '' && $v['description'] != '&nbsp') {
			//Descripción
			$pdf->SetTextColor(163,163,163);
			$pdf->SetXY($pdf->GetX()+3, $pdf->GetY()+1);
			$description = strip_tags(utf8_decode(html_entity_decode(html_entity_decode($v['description'], ENT_QUOTES), ENT_QUOTES)));
			$pdf->MultiCell(185, 6, $description);
		}
	}
	
	//Linea
	$pdf->SetDrawColor(163,163,163);
	$pdf->SetLineWidth(0.2);
	$pdf->Line(10, $pdf->GetY()+3, 200, $pdf->GetY()+3);
}

//FORMACIÓN
if (count($formacion) > 0) {
	//Título
	$pdf->SetY($pdf->GetY()+6);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(185, 6, utf8_decode('FORMACIÓN'));
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($pdf->GetY()+1);
	foreach ($formacion as $k => $v) {
		$pdf->SetTextColor(0,0,0);
		//Cargo y empresa
		$pdf->SetY($pdf->GetY()+5);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(185, 6, utf8_decode(html_entity_decode($v['titulation'], ENT_QUOTES)).' en '.utf8_decode(html_entity_decode($v['nameCenter'], ENT_QUOTES)));
		$pdf->SetFont('Arial','',10);
	
		//FORMATO FECHA
		if (isset($v['start_date']))
			$start_date = $controller->getDateElement($v['start_date']);
		else
			$start_date = '&nbsp';
		if (isset($v['end_date']))
			$end_date = $controller->getDateElement($v['end_date']);
		else
			$end_date = '&nbsp';
		if ($start_date != '&nbsp' && $end_date == '&nbsp')
			$end_date = 'Actualidad';
		else if($start_date == '&nbsp' && $end_date == '&nbsp') {
			$start_date = '';
			$end_date = '';
		} else if ($start_date == '&nbsp')
			$start_date = '';
	
		$text = $start_date.' - '.$end_date;
		//Fecha
		$pdf->SetY($pdf->GetY()+1);
		$pdf->MultiCell(185, 6, $text);
	
		if(isset($v['description']) && $v['description'] != '' && $v['description'] != '&nbsp') {
			//Descripción
			$pdf->SetTextColor(163,163,163);
			$pdf->SetXY($pdf->GetX()+3, $pdf->GetY()+1);
			$description = strip_tags(utf8_decode(html_entity_decode(html_entity_decode($v['description'], ENT_QUOTES), ENT_QUOTES)));
			$pdf->MultiCell(185, 6, $description);
		}
	}
	
	//Linea
	$pdf->SetDrawColor(163,163,163);
	$pdf->SetLineWidth(0.2);
	$pdf->Line(10, $pdf->GetY()+3, 200, $pdf->GetY()+3);
}

if (count($proyectos) > 0) {
//PROYECTOS
	//Título
	$pdf->SetY($pdf->GetY()+6);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(185, 6, utf8_decode('PROYECTOS'));
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($pdf->GetY()+1);
	foreach ($proyectos as $k => $v) {
		$pdf->SetTextColor(0,0,0);
		//Cargo y empresa
		$pdf->SetY($pdf->GetY()+5);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(185, 6, utf8_decode(html_entity_decode($v['title'], ENT_QUOTES)));
		$pdf->SetFont('Arial','',10);
	
		//FORMATO FECHA
		if (isset($v['start_date']))
			$start_date = $controller->getDateElement($v['start_date']);
		else 
			$start_date = '&nbsp';
		if (isset($v['end_date']))
			$end_date = $controller->getDateElement($v['end_date']);
		else
			$end_date = '&nbsp';
		if ($start_date != '&nbsp' && $end_date == '&nbsp')
			$end_date = 'Actualidad';
		else if($start_date == '&nbsp' && $end_date == '&nbsp') {
			$start_date = '';
			$end_date = '';
		} else if ($start_date == '&nbsp')
			$start_date = '';
	
		$text = $start_date.' - '.$end_date;
		//Fecha
		$pdf->SetY($pdf->GetY()+1);
		$pdf->MultiCell(185, 6, $text);
	
		if(isset($v['description']) && $v['description'] != '' && $v['description'] != '&nbsp') {
			//Descripción
			$pdf->SetTextColor(163,163,163);
			$pdf->SetXY($pdf->GetX()+3, $pdf->GetY()+1);
			$description = strip_tags(utf8_decode(html_entity_decode(html_entity_decode($v['description'], ENT_QUOTES), ENT_QUOTES)));
			$pdf->MultiCell(185, 6, $description);
		}
	}

	//Linea
	$pdf->SetDrawColor(163,163,163);
	$pdf->SetLineWidth(0.2);
	$pdf->Line(10, $pdf->GetY()+3, 200, $pdf->GetY()+3);
}

if (count($idiomas) > 0) {
//IDIOMAS
	$lan_level = array("BÁSICA", "BÁSICA LIMITADA", "BÁSCIA PROFESIONAL", "PROF. COMPLETA", "BILINGÜE");
	//Título
	$pdf->SetY($pdf->GetY()+6);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(185, 6, utf8_decode('IDIOMAS'));
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($pdf->GetY()+1);
	foreach ($idiomas as $k => $v) {
		$pdf->SetTextColor(0,0,0);
		$pdf->SetY($pdf->GetY()+5);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(185, 6, utf8_decode(html_entity_decode($v['name'], ENT_QUOTES).' -> '.$lan_level[$v['level']]));
	}

	//Linea
	$pdf->SetDrawColor(163,163,163);
	$pdf->SetLineWidth(0.2);
	$pdf->Line(10, $pdf->GetY()+3, 200, $pdf->GetY()+3);
}

if (count($aptitudes) > 0) {
//APTITUDES
	$apt_level = array("APRENDIZ", "JUNIOR", "ESPECIALISTA", "MAESTRO", "GURÚ");
	//Título
	$pdf->SetY($pdf->GetY()+6);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(185, 6, utf8_decode('APTITUDES'));
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetY($pdf->GetY()+1);
	foreach ($aptitudes as $k => $v) {
		$pdf->SetTextColor(0,0,0);
		$pdf->SetY($pdf->GetY()+5);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(185, 6, utf8_decode(html_entity_decode($v['name'], ENT_QUOTES).' -> '.$lan_level[$v['level']]));
	}

	//Linea
	$pdf->SetDrawColor(163,163,163);
	$pdf->SetLineWidth(0.2);
	$pdf->Line(10, $pdf->GetY()+3, 200, $pdf->GetY()+3);
}

//PRÓXIMOS OBJETIVOS
if (isset($upgrade['obj1']) && $upgrade['obj1'] != '' && isset($upgrade['obj2']) && $upgrade['obj2'] != '' && isset($upgrade['obj3']) && $upgrade['obj3'] != '') {
	$pdf->SetY($pdf->GetY()+6);
	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(185, 6, utf8_decode('PRÓXIMOS OBJETIVOS'));
	
	
	$pdf->Image("Data/Templates/Origin/img/objetivos2.png", $pdf->GetX(), $pdf->GetY()+6, 195, 20);
	
	$pdf->SetFont('Arial','',10);
	$pdf->SetXY($pdf->GetX()+10,$pdf->GetY()+30);
	$pdf->SetTextColor(0,0,0);
	$pdf->MultiCell(185, 6, utf8_decode('1º- '.$upgrade['obj1']));
	$pdf->SetXY($pdf->GetX()+10,$pdf->GetY()+1);
	$pdf->MultiCell(185, 6, utf8_decode('2º- '.$upgrade['obj2']));
	$pdf->SetXY($pdf->GetX()+10,$pdf->GetY()+1);
	$pdf->MultiCell(185, 6, utf8_decode('3º- '.$upgrade['obj3']));
}

//FOCO
if (isset($upgrade['focus']) && $upgrade['focus'] != '') {
	$pdf->SetY($pdf->GetY()+20);
	$pdf->SetFont('Arial','',16);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(185, 6, utf8_decode('Mi foco está en '.$upgrade['focus']), 0, 'C');
}

//END
if (isset($upgrade['end']) && $upgrade['end'] != '') {
	$pdf->SetY($pdf->GetY()+6);
	$pdf->SetFont('Arial','',14);
	$pdf->SetTextColor(163,163,163);
	$pdf->MultiCell(185, 6, utf8_decode('"'.$upgrade['end']).'"', 0, 'C');
}



$pdf->Output();
?>