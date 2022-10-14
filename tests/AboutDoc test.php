<?php 
require_once('../views/AboutDoc.php');
$data = array('page' => 'about');
$test = new AboutDoc($data);
$test->show();
?>