<?php 
include_once('../3 Data/Crud.php');
include_once('../3 Data/UserCrud.php');

$crud = new Crud();
$crud = new UserCrud($crud);


$crud->updateUser(15);

// print_r($crud->readUserById(13));

// print_r($crud->readUserMyEmail("123@123.nl"));


// $crud->createUser("tobz@thethetest.test", "Tobz", "adminadmin");

// $crud->deleteUser(29);

// print_r($crud->readAllUsers());
?>