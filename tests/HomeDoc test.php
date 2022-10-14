<?php 
require_once('../views/HomeDoc.php');
$data = array('page' => 'home');
$test = new HomeDoc($data);
$test->show();
?>