<?php 
require_once('../views/WebshopDoc.php');

$data = array('page' => 'Webshop', 'items' => array(array(1, 'Boerenbrood', 2.49, 'test desc', './Images/brood.jpg'), array(2, 'Tomatensoep', 2.39, 'testing testing', './Images/soep.png')));
$test = new WebshopDoc($data);
$test->show();
