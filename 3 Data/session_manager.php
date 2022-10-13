<?php 
function isUserLoggedIn() {
    return isset($_SESSION['username']);
}

function getLoggedInUserName() {
    if(isUserLoggedIn()){
        return $_SESSION['username'];
    }
    return false;
    
}
?>