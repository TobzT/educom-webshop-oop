<?php 
include_once('./3 Data/Crud.php');

$crud = new Crud();
$sql = "INSERT INTO users (email, name, pw) VALUES (:email, :name, :pw)";
$params = array(':email' => 'tobz@thethetest.nl', ':name' => 'Tobz', ':pw' => 'adminadmin');
$crud->createRow($sql, $params);
?>