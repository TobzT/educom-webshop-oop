<?php

##############################################################
#MAIN APP                                                    #
##############################################################

include_once("./1 Presentation/show.php");
include_once("./2 Business/business.php");
include_once("./3 Data/data.php");
// includeOnceDir("./1 Presentation/");
// includeOnceDir("./2 Business/");
// includeOnceDir("./3 Data/");

session_start();
date_default_timezone_set('CET');
session_check();
// var_dump($_SESSION);
$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);

function getRequestedPage() {
    $request_type = $_SERVER["REQUEST_METHOD"];
    if ($request_type == "GET") {
        return getVarFromArray($_GET, 'page', 'home');
    } else {
        return getVarFromArray($_POST, 'page', 'home');
    }
}

function processRequest($page){
    session_check();
    switch($page) {
        case 'contact':
            $data = getData('contact');
            $data = validateForm($data);
            if($data['valid']){
                $page = 'thanks';
            }
            break;
        case 'login':
            $data = getData('login');
            // var_dump($data);
            $data = validateForm($data);
            if($data['valid']) {
                doLogin($data);
                $page = 'home';
            }
            break;

        case 'logout':
            doLogout();
            $page = 'home';
            break;
        case 'register':
            $data = getData('register');
            $data = validateForm($data);
            if($data['valid']) {
                $conn = openDb();
                registerUser($conn, $data);
                closeDb($conn);
                $page = 'login';
            }
            break;
        case 'details':
            $id = getVarFromArray($_GET, 'id', NULL);
            $data['id'] = $id;
            break;
        case "confirmOrder":
            showConfirmOrder();
        case 'cart':
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $type = getVarFromArray($_POST, 'type', NULL);
                $id = getVarFromArray($_POST, 'id', NULL);
                switch($type) {
                    case "details":
                        $count = getVarFromArray($_POST, 'count', 0);
                        if($id !== NULL && $count !== 0) {
                            addToCart($id, $count);
                        }
                        $page = 'details';
                        $_GET['id'] = $id;
                        break;
                    case "remove":
                        $_SESSION['cart'][$id] = 0;
                        break;

                    case "count":
                        $value = getVarFromArray($_POST, 'value', NULL);
                        $_SESSION['cart'][$id] = $value;
                        break;
                    
                    case "webshop":
                        $count = getVarFromArray($_POST, 'count', 0);
                        if($id !== NULL && $count !== 0) {
                            addToCart($id, $count);
                        }
                        $page = 'webshop';
                        $_GET['id'] = $id;
                        break;
                    
                    case "order":
                        $totalPrice = getVarFromArray($_POST, 'total', 0);
                        
                        $ids = array_keys($_SESSION['cart']);
                        $conn = openDb();
                        
                        $result = getItemsFromDb($conn, $ids);
                        $results = sortWebshopResults($result);
                        
                        $order = '';
                        foreach($ids as $id) {
                            $count = $_SESSION['cart'][$id];
                            $price = $results[$id]['price'];
                            $order .= $id . '|' . $count . '|' . $price . ':';

                        }
                        $user = findByName($conn, $_SESSION['username']);
                        $userId = $user[0][0];
                        saveInOrders($conn, $userId, $order, $totalPrice);
                        clearCart();
                        cleanCart();
                        closeDb($conn);
                        $page = 'confirmOrder';


                    
                    
                }
            

            }
        
        
    }
    $data['page'] = $page;
    $data['menu'] = array(
                        "home" => "HOME",
                        "about" => "ABOUT", 
                        "contact" => "CONTACT", 
                        "webshop" => "WEBSHOP" 
                    );
    if(isUserLoggedIn()) {
        $data['sideMenu'] = array("logout" => "Log out " . ucfirst(getLoggedInUserName()), "cart" => "Cart");
    } else {
        $data['sideMenu'] = array('login' => 'Log In', 'register' => 'Sign Up');
    }  
    return $data;
}

function showResponsePage($data) {
    beginDocument();
    showHead();
    showBody($data);
    endDocument();
}