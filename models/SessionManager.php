<?php 

class SessionManager {

    public function isLoggedIn() {
        return isset($_SESSION['username']);
    }

    public function doLogOut() {
        unset($_SESSION['username']);
        unset($_SESSION['lastUsed']);
    }   

    public function doLogIn() {
        $conn = openDb();
        $_SESSION['username'] = findByEmail($conn, $this->getVarFromArray($_POST, 'email', NULL))[0][2];
        $_SESSION['lastUsed'] = date('Y:m:t-H:m:s');
        $_SESSION['cart'] = array();
        closeDb($conn);
    }
}
?>