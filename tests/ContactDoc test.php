<?php 
require_once('../views/ContactDoc.php');

$data = array('page' => 'contact');
$test = new ContactDoc($data);
$test->show();

?>