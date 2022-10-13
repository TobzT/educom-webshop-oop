<?php 
function showMenu($data) {
        startMenuList();
        

        showMenuItem('index.php?page=home', 'HOME');
        showMenuItem('index.php?page=about', 'ABOUT');
        showMenuItem('index.php?page=contact', 'CONTACT');
        showMenuItem('index.php?page=webshop', 'WEBSHOP');
        
        stopMenuList();
}

function showMenuItem($link, $labeltext) {
    echo '<div class="divh"><li class="menu"><a href="'.$link.'" class="menu">'.$labeltext.'</a></li></div>';
}

function showSideMenuItem($link, $labeltext) {
    echo '<a href="'.$link.'" class="menu">'.$labeltext.'</a>';
}

function startMenuList() {
    echo '<ul class="list">';
}

function stopMenuList() {
    echo '</ul>';
}

function showSideMenu($data) {
    // if(isUserLoggedIn()) {
    //     echo('
    //     <div class="register">');
    //         showSideMenuItem('index.php?page=logout', 'Log Out ' . ucfirst($_SESSION['username']));
    //         echo '<br>';
    //         showSideMenuItem('index.php?page=cart', 'Cart');
    //         echo '</div>';
        
    // } else {
    //     echo ('
    //     <div class="register">');
    //         showSideMenuItem('index.php?page=login', 'Log In');
    //         showSideMenuItem('index.php?page=register', 'Sign up');
    //     echo '</div>';
        
    // }
    echo '<div class="register">';
    foreach($data['sideMenu'] as $key => $value) {
        showSideMenuItem('index.php?page='.$key, $value);
        echo '<br>';
    }
    echo '</div>';

    
}

function showTitle($page) {
    echo '<h1 class="header">'. ucfirst($page) .'</h1>';
}
?>