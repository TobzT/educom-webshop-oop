<?php 
include_once('./Crud.php');
include_once('./UserCrud.php');
include_once('./ShopCrud.php');

$crud = new Crud();
$crud = new ShopCrud($crud);

// print_r($crud->createItem("test", 1300, "TEST", "./images/testing.png"));

// print_r($crud->updateItem(10, price:1000));

print_r($crud->deleteItem(10));

// print_r($crud->readAllShopItems());

// print_r($crud->readOneShopItem(1));

// $items = array(1,2,3,5);
// print_r($crud->readManyShopItems($items));

// $crud = new UserCrud($crud);

// $crud->updateUser(15, name:"Hanne", pw:"whatever");

// print_r($crud->readUserById(13));

// print_r($crud->readUserByEmail("123@123.nl"));

// $crud->createUser("tobz@thethetest.test", "Tobz", "adminadmin");

// $crud->deleteUser(29);

// print_r($crud->readAllUsers());
?>