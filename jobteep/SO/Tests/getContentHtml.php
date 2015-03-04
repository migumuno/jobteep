<?php
header('Content-Type: text/html; charset=utf-8');

function between($beg, $end, $str) {
	$a = explode($beg, $str, 2);
	$b = explode($end, $a[1]);
	return $beg . $b[0] . $end;
}

$jobandtalent = '../../Docs/jobandtalent.html';
$linkedin = '../../Docs/Linkedin.txt';

$file = $linkedin;

/*$lineas = file($file);

foreach ($líneas as $num_línea => $línea) {
    echo "Línea #<b>{$num_línea}</b> : " . htmlspecialchars($línea) . "<br />\n";
}*/

$document = file_get_contents($file);

/*$extract_string = between('<h3>', '</h3>', $document);*/

/*$string = strip_tags($document);*/

/*preg_match("#<h3>([\s\S]*)</h3>#s",$document,$matches);

print_r($matches);*/

//LINKEDIN

$lnkdn = explode("\n", $document);

echo '
	<ul>';
for ($i = 0; $i < count($lnkdn)-1; $i++) {
	echo '<li>'.$lnkdn[$i].'</li>';
}
echo '</ul>
';

//JOBAND TALENT

/*$dom = new DOMDocument();
$dom->loadHTML($document);
$sector = $dom->getElementsByTagName('h3');

$sectors = array();

for ($i = 0; $i < 26; $i++) {
	$sectors[] = $sector->item($i)->nodeValue;
}

echo '
	<ul>';
	
	for ($i = 0; $i < count($sectors); $i++) {
		echo '<li>'.$sectors[$i].'</li>';
	}

	echo '</ul>
';*/
	
	


?>