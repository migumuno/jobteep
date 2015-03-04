<?php
//PRUEBAS DE LA MEMORIA CACHÉ


$collection = $_SESSION['SO']->load('language');
$obj = $_SESSION['SO']->getElement('language');
$obj->set('name', 'Inglés');
echo $obj->get('name').'<br>';
$collection->addItem($obj, 1);
$element = $collection->getItem(1);
echo $element->get('name').'<br>';

$obj = $_SESSION['SO']->getElement('language');
$obj->set('name', 'Alemán');
echo $obj->get('name').'<br>';
$collection->addItem($obj, 2);
$element = $collection->getItem(2);
echo $element->get('name').'<br>';

/*$obj = $_SESSION['SO']->getElement('language');
$obj->set('name', 'Inglés');
echo $obj->get('name').'<br>';
$collection->addItem($obj, 1);
$obj = $_SESSION['SO']->getElement('language');
$obj->set('name', 'Alemán');
echo $obj->get('name').'<br>';
$collection->addItem($obj, 2);
$obj = $collection->getItem(1);
echo $obj->get('name');
$obj = $collection->getItem(2);
echo $obj->get('name');*/


/*$collection = $_SESSION['SO']->load('language');
$obj = $_SESSION['SO']->getElement('language');
$obj->set('name', 'Inglés');
echo $obj->get('name').'<br>';
$collection->addItem($obj, 1);
$obj = $_SESSION['SO']->getElement('language');
$obj->set('name', 'Alemán');
echo $obj->get('name').'<br>';
$collection->addItem($obj, 2);
$_SESSION['SO']->erase('language');
$_SESSION['SO']->store($collection, 'language');
$coll = $_SESSION['SO']->load('language');
foreach ($coll as $k => $v) {
	echo $v->get('name').'<br>';
}*/

/*//PRUEBAS DE LA PILA
$_SESSION['SO']->push("Pila");
echo $_SESSION['SO']->pop();
$_SESSION['SO']->pop();*/

/*//PRUEBAS BASE DE DATOS

//INSERT
$fields = array("user", "pass");
$values = array("cuellar.pa@gmail.com", "gusanillo");
$_SESSION['SO']->insert('user', $fields, $values);

//SELECT
$result = $_SESSION['SO']->select('user');
for ($i = 0; $i < $result->num_rows; $i++) {
	$row = $result->fetch_assoc();
	echo 'User '.$i.':<br>';
	echo 'usuario = '.$row['user'].'<br>';
	echo 'pass = '.$row['pass'].'<br>';
}
echo '<br>';

//UPDATE
$where = 'user = "cuellar.pa@gmail.com"';
$fields = array("pass");
$values = array("gusanillo0");
$_SESSION['SO']->update('user', $fields, $values, $where);

//SELECT
$result = $_SESSION['SO']->select('user');
for ($i = 0; $i < $result->num_rows; $i++) {
	$row = $result->fetch_assoc();
	echo 'User '.$i.':<br>';
	echo 'usuario = '.$row['user'].'<br>';
	echo 'pass = '.$row['pass'].'<br>';
}
echo '<br>';

//DELETE
$where = 'user = "cuellar.pa@gmail.com"';
$_SESSION['SO']->delete('user', $where);

//SELECT
$result = $_SESSION['SO']->select('user');
for ($i = 0; $i < $result->num_rows; $i++) {
	$row = $result->fetch_assoc();
	echo 'User '.$i.':<br>';
	echo 'usuario = '.$row['user'].'<br>';
	echo 'pass = '.$row['pass'].'<br>';
}
echo '<br>';*/
?>