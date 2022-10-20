<?php 

class SessionManager {

    public function isLoggedIn() {
        return isset($_SESSION['username']);
    }
}
?>