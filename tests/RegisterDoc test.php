<?php 
require_once('../views/RegisterDoc.php');

$data = array('page' => 'register');
$test = new RegisterDoc($data);
$test->show();

?>