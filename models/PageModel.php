<?php 
include_once('./models/SessionManager.php');
class PageModel {

    protected $page;
    protected $isPost;
    protected $menu = array();
    protected $sideMenu = array();
    protected $sessionManager;

    // public function __construct() {
    //     $this->getRequestedPage();
    // }

    public function getRequestedPage() {
        $this->sessionManager = new SessionManager();
        $request_type = $_SERVER["REQUEST_METHOD"];
        
        $this->isPost = $request_type == "POST";
    
        if ($this->isPost) {
            $this->page =  $this->getVarFromArray($_POST, 'page', 'home');
        } else {
            $this->page =  $this->getVarFromArray($_GET, 'page', 'home');
        }

        $this->createMenuArr();

    }

    public function getPage() {
        return $this->page;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function getSideMenu() {
        return $this->sideMenu;
    }

    protected function createMenuArr() {
        $this->menu = array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => "WEBSHOP");
        if($this->isLoggedIn()) {
            $this->sideMenu = array('logout' => 'Log out', 'cart' => 'Cart');
        } else {
            $this->sideMenu = array('login' => 'Log In', 'register' => 'Sign up');
        }
    }

    protected function isLoggedIn() {
        return $this->sessionManager->isLoggedIn();
    }

    protected  function getVarFromArray($array, $key, $default = NULL) {
        return isset($array[$key]) ? $array[$key] : $default;
        
    }


}
?>