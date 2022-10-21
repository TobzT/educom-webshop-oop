<?php 

class SessionManager {

    public function isLoggedIn() {
        return isset($_SESSION['username']);
    }

    public function doLogOut() {
        unset($_SESSION['username']);
        unset($_SESSION['lastUsed']);
    }   
}
?>