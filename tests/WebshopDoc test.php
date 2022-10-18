<?php 
require_once('../views/WebshopDoc.php');

$data = array(
    'page' => 'Webshop', 
    'menu' => array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP'), 
    'sideMenu' => array('login' => 'Log In', 'register' => 'Sign Up'), 
    'items' => array(array(1, 'Boerenbrood', 2.49, 'test desc', './Images/brood.jpg'), array(2, 'Tomatensoep', 2.39, 'testing testing', './Images/soep.png')));
$test = new WebshopDoc($data);
$test->show();
