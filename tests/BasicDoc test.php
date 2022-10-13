<?php 
require_once('../views/BasicDoc.php');
$test  = new BasicDoc('test');
$test->show($test->getPage());
?>