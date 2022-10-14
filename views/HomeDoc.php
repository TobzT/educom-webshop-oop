<?php 
require_once('../views/BasicDoc.php');
class HomeDoc extends BasicDoc {
    protected $page;
    protected $loggedin;
    protected $sideMenuData;
    
    
    public function __construct() {
        $this->page = 'home';

        // IS DIT NODIG?
        if(isset($_SESSION['username'])) {
            $this->loggedin = true;
        } else {
            $this->loggedin = false;
        }
        
        if($this->loggedin == true) {
            $this->sideMenuData = array('logout' => 'Log out ' . ucfirst($_SESSION['username']), 'cart' => 'Cart');
        } else {
            $this->sideMenuData = array('login' => 'Log In', 'register' => 'Sign Up');
        }
    }

    protected function showBodyContent() {
        echo('
        <p class="body">
            Welcome to the website, dear traveler. <br>
            Here we will have some fun while also learning a thing or two. <br>
            See you around traveler!
        </p>
        ');
    }
}
?>