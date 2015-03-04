<?php
$coll = clone $_SESSION['SO']->load('language');
echo $coll->length();