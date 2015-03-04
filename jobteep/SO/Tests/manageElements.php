<?php
//PRUEBAS

//CARGO LOS PARSERS
$elementParser = $_SESSION['controller']->getParser('element');
$instructionParser = $_SESSION['controller']->getParser('instruction');

//CREO OBJETO DEL TIPO PRUEBA
$obj = $elementParser->parser('prueba');

$values = array(
		"name" => "Miguel Ángel Muñoz Viejo",
		"email" => "miguel@3iwi.com",
		"comments" => "",
		"telf" => "+34 91 219 05 01",
		"number" => "3"
);



try {
	//RELLENO EL OBJETO
	$obj->setN($values);
	$obj->setId(1);

	//INSERTO EN LA CACHÉ
	$instruction = $instructionParser->parser('insertMC');
	$instruction->execute($obj);

	//CREO UN OBJETO DEL TIPO DEL QUE QUIERO OBTENER DE LA CACHÉ
	$aux = $elementParser->parser('prueba');
	$aux->setId(1);

	//BORRO DE LA CACHÉ
	$instruction = $instructionParser->parser('deleteMC');
	$instruction->execute($aux);

	//SELECCIONO DE LA CACHÉ
	$instruction = $instructionParser->parser('selectMC');
	$element = $instruction->execute($aux);


} catch (Exception $e) {
	echo $e->getMessage().'<br>';
}

echo 'Esto es lo que has insertado: <br><br>';
echo 'Nombre: '.$element->get('name').'<br>';
echo 'Email: '.$element->get('email').'<br>';
echo 'Comments: '.$element->get('comments').'<br>';
echo 'Teléfono: '.$element->get('telf').'<br>';
echo 'Número: '.$element->get('number').'<br>';
?>