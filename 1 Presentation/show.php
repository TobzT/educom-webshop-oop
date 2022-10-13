<?php 
include_once('./1 Presentation/header.php');
include_once('./1 Presentation/webshop.php');
include_once('./1 Presentation/home.php');
include_once('./1 Presentation/about.php');
include_once('./1 Presentation/contact.php');
include_once('./1 Presentation/login.php');
include_once('./1 Presentation/register.php');
include_once('./1 Presentation/confirmorder.php');

include_once('./2 Business/business.php');


//INDEX
function beginDocument() {
    echo('
        <!DOCTYPE html>
        <html>
    ');
}

function showHead() {
    echo('<head>');
    linkExternalCss();
    echo('</head>');
}

function showBody($data) {
    echo('<body> <div class="container">');
    showHeader($data);
    showContent($data);
    showFooter();
    echo('</div> </body>');
    

}


function showHeader($data) {
    startHeader();
    showTitle($data['page']);
    showSideMenu($data);
    showMenu($data);
    stopHeader();
}
function startHeader() {
    echo '<header>';
}

function stopHeader() {
    echo '</header>';
}



function showContent($data) {
    
    switch($data['page']) {
        case "home":
            showHomeContent();
            break;
        case "about":
            showAboutContent();
            break;
        case "contact":
            showContactContent();
            break;
        case "register":
            showRegisterContent();
            break;
        case "login":
            showLoginContent($data);
            break;
        case 'thanks':
            showContactThanks($data);
            break;
        case 'logout':
            showHomeContent();
        case 'webshop':
            showWebshopContent($data);
            break;
        case 'details':
            showDetailsContent($data);
            break;
        case 'cart':
            showCartContent();
            break;
        case 'confirmOrder':
            showConfirmOrder();
            break;
        default:
            showPageError();
    }
}



function endDocument() {
    echo('</html>');
}

function linkExternalCss() {
    echo('<link rel="stylesheet" href="./CSS/css.css">');
}


//WEBSHOP


//LOGIN




function ShowFormStart() {
    echo('<form action="index.php" method="post" class="body">');
}

function ShowFormEnd($page, $submitText) {
    echo('<input type="hidden" name="page" value="'.$page.'">');
    echo('<button type="submit">'.$submitText.'</button></form>');
}

function showPageError() {
    echo('
        <h1 class="error">PAGE ERROR</h1>
    ');
}

function showFooter() {
    echo('
    <footer>
        &#169;
        <p>' . date("Y") . '</p>
        <p>Tobias The</p>
    </footer>
    ');
}


?>