<?php 
include_once('./models/SessionManager.php');
class PageModel {

    protected $page;
    protected $isPost;
    protected $menu = array();
    protected $sideMenu = array();
    public $sessionManager;
    protected $crud;

    public function __construct($copy, $crud=NULL) {
        if(empty($copy) Or $crud !== NULL) {
            $this->sessionManager = new SessionManager();
            $this->crud = $crud;
        } else {
            $this->page = $copy->getPage();
            $this->isPost = $copy->getIsPost();
            $this->menu = $copy->getMenu();
            $this->sideMenu = $copy->getSideMenu();
            $this->sessionManager = $copy->getSessionManager();
            $this->crud = $copy->getCrud();
        }
        
    }

    public function getRequestedPage() {
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

    public function setPage($page) {
        $this->page = $page;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function getSideMenu() {
        return $this->sideMenu;
    }

    public function getIsPost() {
        return $this->isPost;
    }

    public function getSessionManager() {
        return $this->sessionManager;
    }

    public function refreshMenu() {
        $this->createMenuArr();
    }

    public function getCrud() {
        return $this->crud;
    }

    public function cleanCart() {
        foreach($_SESSION['cart'] as $id => $count) {
            if($count < 1) {
                unset($_SESSION['cart'][$id]);
            }
        }
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

    public function doLogIn() {
        $this->sessionManager->doLogIn();
    }

    public function doLogOut() {
        $this->sessionManager->doLogOut();
    }

    


}
?>