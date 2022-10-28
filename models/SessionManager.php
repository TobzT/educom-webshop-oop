<?php 
include_once("./models/PageModel.php");
class SessionManager{

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

    public function addToCart($id, $count) {
        if (isset($_SESSION['username'])){
            if(array_key_exists($id, $_SESSION['cart'])) {
                $_SESSION['cart'][$id] += (int)$count;
            } else {
                $_SESSION['cart'][$id] = (int)$count;
            }
        } 
    }

    public function cleanCart() {
        foreach($_SESSION['cart'] as $id => $count) {
            if($count < 1) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    public function clearCart() {
        foreach($_SESSION['cart'] as $id => $count) {
            $_SESSION['cart'][$id] = 0;
        }
    }

    public function getLoggedInUserName() {
        if(isUserLoggedIn()){
            return $_SESSION['username'];
        }
        return false;
    }

    private function getVarFromArray($array, $key, $default = NULL) {
        return isset($array[$key]) ? $array[$key] : $default;
        
    }

    public function session_check() {
        if (isset($_SESSION['lastUsed'])){
            $currentDate = explode("-", date('Y:m:t-H:m:s'));
            $currentTime = $currentDate[1];
            $currentDay = $currentDate[0];
            $lastDate = explode("-", $_SESSION['lastUsed']);
            $lastTime = $lastDate[1];
            $lastDay = $lastDate[0];
            if ($currentDay !== $lastDay) {
                $this->doLogout();
                return;
            } elseif(checkTimeout($currentTime, $lastTime)) {
                $this->doLogout();
                return;
            }
        } else {
            $this->doLogout();
            return;
        }
    }
    
}
?>