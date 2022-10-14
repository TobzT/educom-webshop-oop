<?php 
require_once('../views/BasicDoc.php');
$data = array('page' => 'Basic');
$test  = new BasicDoc($data);
$test->show();
?>