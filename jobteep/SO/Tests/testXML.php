<?php
$xml=simplexml_load_file("dictionary.xml");
$i = 0;

foreach ($xml->page as $item) {
	if ($item->name == 'Education') {
		foreach ($item->children()as $child) {
			echo $child . '<br>';
		}
	}

	echo '<br>'. $i .'<br>';
	$i++;
}
?>