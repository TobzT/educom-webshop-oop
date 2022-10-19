<?php

##############################################################
#MAIN APP                                                    #
##############################################################

include_once("./1 Presentation/show.php");
include_once("./2 Business/business.php");
include_once("./3 Data/data.php");

include_once("./views/AboutDoc.php");
include_once("./views/BasicDoc.php");
include_once("./views/CartDoc.php");
include_once("./views/EmptyCartDoc.php");
include_once("./views/DetailDoc.php");
include_once("./views/FormsDoc.php");
include_once("./views/HomeDoc.php");
include_once("./views/HtmlDoc.php");
include_once("./views/ProductDoc.php");
include_once("./views/WebshopDoc.php");
include_once("./views/ContactThanksDoc.php");
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
            $data['submitLabel'] = 'Submit';
            break;
        case 'login':
            $data = getData('login');
            // var_dump($data);
            $data = validateForm($data);
            if($data['valid']) {
                doLogin($data);
                $page = 'home';
            }
            $data['submitLabel'] = 'Log in';
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
            $data['submitLabel'] = 'Sign up';
            break;
        case 'details':
            $id = getVarFromArray($_GET, 'id', NULL);
            $conn = openDb();
            $data['items'] = getItemFromDb($conn, $id);
            closeDb($conn);
            $data['id'] = $id;
            break;
        case "confirmOrder":
            showConfirmOrder();
            break;
        case 'webshop':
            $conn = openDb();
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $id = getVarFromArray($_POST, 'id', NULL);
                $count = 1;
                addToCart($id, $count);
            }
            $data['items'] = getAllItemsFromDb($conn);
            closeDb($conn);
            break;
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
                        $data['id'] = $id;
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
                        break;
                }
                if(!checkCart()) {
                    $page = 'emptyCart';
                    break;
                }
                $ids = array_keys($_SESSION['cart']);
                $conn = openDb();
                    
                $data['items'] = getItemsFromDb($conn, $ids);
                closeDb($conn);
            

            } else {
                if(!checkCart()) {
                    $page = 'emptyCart';
                    break;
                }
                $ids = array_keys($_SESSION['cart']);
                $conn = openDb();
                    
                $data['items'] = getItemsFromDb($conn, $ids);
                closeDb($conn);

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
    switch($data['page']) {
        case "home":
            $view = new HomeDoc($data);
            break;
        case "about":
            $view = new AboutDoc($data);
            break;
        case "contact":
            $view = new FormsDoc($data);
            break;
        case "webshop":
            $view = new WebshopDoc($data);
            break;
        case "login":
            $view = new FormsDoc($data);
            break;
        case "register":
            $view = new FormsDoc($data);
            break;
        case "cart":
            $view = new CartDoc($data);
            break;
        case "details":
            $view = new DetailDoc($data);
            break;
        case "thanks":
            $view = new ContactThanksDoc($data);
            break;
        case "emptyCart":
            $view = new EmptyCartDoc($data);
            break;
        default:
            $view = new HomeDoc($data);
            break;   
    }
    $view->show(); 
}