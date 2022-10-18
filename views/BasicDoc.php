<?php 
require_once('../views/HtmlDoc.php');

class BasicDoc extends HtmlDoc{

    protected $page;
    protected $loggedin;
    protected $sideMenuData;

    public function __construct($data) {
        $this->setPage($data);
        $this->setLoggedIn();
        $this->setSideMenuData();
    }

    protected function getLoggedIn() {
        return $this->loggedin;
    }

    protected function setPage($data) {
        $this->page = $data['page'];
        return;
    }

    protected function setLoggedIn() {
        if(isset($_SESSION['username'])) {
            $this->loggedin = true;
        } else {
            $this->loggedin = false;
        }
        return;
    }

    protected function setSideMenuData() {
        if($this->getLoggedIn()) {
            $this->sideMenuData = array('logout' => 'Log out ' . ucfirst($_SESSION['username']), 'cart' => 'Cart');
        } else {
            $this->sideMenuData = array('login' => 'Log In', 'register' => 'Sign Up');
        }
        return;
    }

    

    protected function showBody() {
        $this->showBodyStart();
        $this->showHeader();
        $this->showBodyContent();
        $this->showFooter();
        $this->showBodyEnd();
    }

    //BODY
    private function showBodyStart() {
        echo('<body> <div class="container">');
    }

    private function showBodyEnd() {
        echo('</div> </body>');
    }

    protected function showBodyContent() {
        //EMPTY
    }
    

    //HEADER
    protected function showHeader() {
        $this->showHeaderStart();
        $this->showHeaderContent();
        $this->showHeaderEnd();
    }

    private function showHeaderStart() {
        echo('<header>');
    }

    private function showHeaderContent() {
        $this->showTitle();
        $this->showSideMenu();
        $this->showMenu();
    }

    private function showTitle() {
        echo ('<h1 class="header">'. ucfirst($this->page) .'</h1>');
        
    }

    private function showSideMenu() {
        echo '<div class="register">';
        foreach($this->sideMenuData as $key => $value) {
            $this->showSideMenuItem('index.php?page='.$key, $value);
            echo '<br>';
    }
    echo '</div>';
    }

    private function showSideMenuItem($link, $labeltext) {
        echo '<a href="'.$link.'" class="menu">'.$labeltext.'</a>';
    }

    private function showMenu() {
        $this->startMenuList();
        

        $this->showMenuItem('index.php?page=home', 'HOME');
        $this->showMenuItem('index.php?page=about', 'ABOUT');
        $this->showMenuItem('index.php?page=contact', 'CONTACT');
        $this->showMenuItem('index.php?page=webshop', 'WEBSHOP');
        
        $this->stopMenuList();
    }

    private function startMenuList() {
        echo '<ul class="list">';
    }

    private function stopMenuList() {
        echo '</ul>';
    }

    private function showMenuItem($link, $labeltext) {
        echo '<div class="divh"><li class="menu"><a href="'.$link.'" class="menu">'.$labeltext.'</a></li></div>';
    }
    private function showHeaderEnd() {
        echo('</header>');
    }

    //FOOTER
    private function showFooter() {
        $this->showFooterStart();
        $this->showFooterContent();
        $this->showFooterEnd();
        
    }
    private function showFooterStart() {
        echo('<footer>');
    }

    private function showFooterEnd() {
        echo('</footer>');
    }

    private function showFooterContent() {
        echo('
            <div>
                <p> &#169; </p>
                <p>' . date("Y") . '</p>
                <p>Tobias The</p>
            </div>
        ');
    }


}
?>