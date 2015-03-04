<?php
require_once 'Pdf.class.php';

$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image("images/perfil.png", null, null, 60, 60);
$pdf->SetFont('Arial','',10);
/*
$icons = array(
	"images/web.png",
	"images/email.png",
	"images/phone.png",
	"images/twitter.png",
	"images/linkedin.png"
);

$titles = array(
	"WEBSITE",
	"EMAIL",
	"PHONE",
	"TWITTER",
	"LINKEDIN"
);

$content = array(
	"www.jobteep.com",
	"miguel@jobteep.com",
	"696 984 784",
	"3perspectivas",
	"linkedin.com/miguelangelmunoz"
);

for ($i = 0; $i < count($titles); $i++) {
	//ICONO
	$pdf->SetXY(80, 16);
	$pdf->Image($icons[$i], null, null, 8, 0);
	
	//TITULO
	$pdf->SetXY(90, 15);
	$pdf->SetTextColor(224, 109, 24);
	$pdf->Cell(47.5, 5, $titles[$i], 0, 0, 'L');
	
	//TEXTO
	$pdf->SetXY(90, 20);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(47.5, 5, $content[$i], 0, 0, 'L');
}*/

//WEBSITE

//ICONO
$pdf->SetXY(80, 16);
$pdf->Image("images/web.png", null, null, 8, 0);

//TITULO
$pdf->SetXY(90, 15);
$pdf->SetTextColor(224, 109, 24);
$pdf->Cell(47.5, 5, "WEBSITE", 0, 0, 'L');

//TEXTO
$pdf->SetXY(90, 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(47.5, 5, "www.jobteep.com", 0, 0, 'L');


//EMAIL

//ICONO
$pdf->SetXY(140, 16);
$pdf->Image("images/email.png", null, null, 8, 0);

//TITULO
$pdf->SetXY(150, 15);
$pdf->SetTextColor(224, 109, 24);
$pdf->Cell(47.5, 5, "EMAIL", 0, 0, 'L');

//TEXTO
$pdf->SetXY(150, 20);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(47.5, 5, "info@jobteep.com", 0, 'L');

//PHONE

//ICONO
$pdf->SetXY(80, 36);
$pdf->Image("images/phone.png", null, null, 8, 0);

//TITULO
$pdf->SetXY(90, 35);
$pdf->SetTextColor(224, 109, 24);
$pdf->Cell(47.5, 5, "PHONE", 0, 0, 'L');

//TEXTO
$pdf->SetXY(90, 40);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(47.5, 5, "555 555 555", 0, 0, 'L');

//TWITTER

//ICONO
$pdf->SetXY(140, 36);
$pdf->Image("images/twitter.png", null, null, 8, 0);

//TITULO
$pdf->SetXY(150, 35);
$pdf->SetTextColor(224, 109, 24);
$pdf->Cell(47.5, 5, "TWITTER", 0, 0, 'L');

//TEXTO
$pdf->SetXY(150, 40);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(47.5, 5, "@jobteep", 0, 'L');

//LINKEDIN

//ICONO
$pdf->SetXY(80, 56);
$pdf->Image("images/linkedin.png", null, null, 8, 0);

//TITULO
$pdf->SetXY(90, 55);
$pdf->SetTextColor(224, 109, 24);
$pdf->Cell(47.5, 5, "LINKEDIN", 0, 0, 'L');

//TEXTO
$pdf->SetXY(90, 60);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(47.5, 5, "linkedin.com/jobteep", 0, 0, 'L');

//NOMBRE
$pdf->SetXY(10, 75);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(60, 6, utf8_decode("Miguel Ángel Muñoz Viejo"), 0, 'C');

//PROFESION
$pdf->SetXY(10, 90);
$pdf->SetTextColor(162,162,162);
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(60, 5, utf8_decode("DESARROLLADOR WEB"), 0, 'C');

//EXPERIENCES
//ICONO
$pdf->SetXY(90, 73.5);
$pdf->Image("images/experience.png", null, null, 7, 0);

//TITULO
$pdf->SetXY(100, 75);
$pdf->SetFont('Arial','B',14);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(47.5, 5, "EXPERIENCE", 0, 0, 'L');

//LINEA
$pdf->SetDrawColor(162,162,162);
$pdf->SetLineWidth(0.5);
$pdf->Line(90, 83, 190, 83);

$titles = array("DIRECTOR DE PROYECTO", "DISEÑADOR GRÁFICO", "DESARROLLADOR WEB", "MONITOR DE OCIO Y TIEMPO LIBRE");
$years = array("2013-2014", "2012-2013", "2011-2012", "2010-2011");
$description = array(
	"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat, purus non pharetra imperdiet, nisl justo consequat ipsum, non consequat purus elit non dolor. In et massa ultrices, mollis magna ut, dapibus quam. Mauris ut consequat diam, non auctor orci.", 
	"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat, purus non pharetra imperdiet, nisl justo consequat ipsum, non consequat purus elit non dolor. In et massa ultrices, mollis magna ut, dapibus quam. Mauris ut consequat diam, non auctor orci.", 
	"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat, purus non pharetra imperdiet, nisl justo consequat ipsum, non consequat purus elit non dolor. In et massa ultrices, mollis magna ut, dapibus quam. Mauris ut consequat diam, non auctor orci.",
	"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt."
);

for ($i = 0; $i < count($titles); $i++) {
	$x = 90;
	
	//TITULO
	$y = 90 + 50 * $i;
	$pdf->SetXY($x, $y);
	$pdf->SetTextColor(224, 109, 24);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(0, 0, utf8_decode($titles[$i]), 0, 0, 'L');
	
	//AÑO
	$y = $y + 5;
	$pdf->SetXY($x, $y);
	$pdf->SetTextColor(162,162,162);
	$pdf->Cell(0, 0, $years[$i], 0, 0, 'L');
	
	//DESCRIPCIÓN
	$y = $y + 5;
	$pdf->SetXY($x, $y);
	$pdf->SetTextColor(0,0,0);
	$pdf->MultiCell(0, 5, utf8_decode($description[$i]));
	
}

//SKILLS
//ICONO
$pdf->SetXY(10, 108.5);
$pdf->Image("images/skills.png", null, null, 7, 0);

//TITULO
$pdf->SetXY(20, 110);
$pdf->SetFont('Arial','B',14);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(47.5, 5, "SKILLS", 0, 0, 'L');

//LINEA
$pdf->SetDrawColor(162,162,162);
$pdf->SetLineWidth(0.5);
$pdf->Line(10, 118, 70, 118);

$skill_titles = array("HTML5", "PHP", "CSS3", "JQUERY", "AJAX");
$skill_level = array("images/advance.jpg", "images/advance.jpg", "images/advance.jpg", "images/advance.jpg", "images/advance.jpg");

for ($i = 0; $i < count($skill_titles); $i++) {
	$x = 10;
	$y = 125 + 20 * $i;
	
	//TITULLO
	$pdf->SetXY($x, $y);
	$pdf->SetTextColor(162,162,162);
	$pdf->Cell(70, 5, utf8_decode($skill_titles[$i]), 0, 0, 'L');
	
	//NIVEL
	$y = $y + 8;
	$pdf->SetXY($x, $y);
	$pdf->Image($skill_level[$i], null, null, 60, 0);
}


$pdf->Output();
?>