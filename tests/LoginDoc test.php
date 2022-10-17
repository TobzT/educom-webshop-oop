<?php 
require_once('../views/LoginDoc.php');

$data = array('page' => 'login');
$test = new LoginDoc($data);
$test->show();

?>