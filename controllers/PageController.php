<?php 

class PageController {

    private $model;
    private $view;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        $this->getRequest();
        // if($this->model->getIsPost()){
            $this->processRequest();
        // }
        $this->showPage();
    }

    private function getRequest() {
        $this->model->getRequestedPage();
    }

    private function processRequest() {
        $this->session_check();

        switch($this->model->getPage()) {
            case "login":
                include_once('./models/UserModel.php');
                $this->model = new UserModel($this->model);
                $this->model->validateForm();
                if($this->model->getValid()) {
                    $this->model->doLogin();
                    $this->model->refreshMenu();
                    $this->model->setPage('home');
                }
                break;
            
            case "register":
                include_once('./models/UserModel.php');
                $this->model = new UserModel($this->model);
                $this->model->validateForm();
                if($this->model->getValid()) {
                    $this->model->registerUser();
                    $this->model->setPage('login');
                    $this->model->refreshMetaData();
                }
                break;

            case "contact":
                include_once('./models/UserModel.php');
                $this->model = new UserModel($this->model);
                $this->model->validateForm();
                if($this->model->getValid()){
                    $this->model->setPage('contactThanks');
                }
                break;
            
            case "logout":
                $this->model->sessionManager->doLogOut();
                $this->model->refreshMenu();
                $this->model->setPage('home');
                break;

            case "webshop":
                include_once('./models/ShopModel.php');
                $this->model = new ShopModel($this->model);
                
                $id = $this->getVarFromArray($_POST, 'id', NULL);
                $count = $this->getVarFromArray($_POST, 'count', 0);
                if($id !== NULL && $count !== 0) {
                    $this->model->sessionManager->addToCart($id, $count);
                }
                break;

            case "details":
                include_once('./models/ShopModel.php');
                $this->model = new ShopModel($this->model);
                $id = $this->getVarFromArray($_POST, 'id', NULL);
                $count = $this->getVarFromArray($_POST, 'count', 0);
                if($id !== NULL && $count !== 0) {
                    $this->model->sessionManager->addToCart($id, $count);
                    $this->model->setId($id);
                }
                
                break;

            case "cart":
                include_once('./models/ShopModel.php');
                $this->model = new ShopModel($this->model);
                $type = $this->getVarFromArray($_POST, 'type', 0);
                $id = (int)$this->getVarFromArray($_POST, 'id', 0);
                if($id !== 0 && $type !== 0) {
                    switch($type) {
                        // case "details":
                        //     if($this->model->getIsPost()) {
                        //         $id = (int)$this->getVarFromArray($_POST, 'id', 0);
                        //         $count = (int)$this->getVarFromArray($_POST, 'count', 0);
                        //         if($id !== 0 && $count !== 0) {
                        //             addToCart($id, $count);
                        //         }
                        //         $this->model->setPage('details');
                        //         $this->model->setId($id);
                        //         break;
                        //     }
                        
                        case "remove":
                            $_SESSION['cart'][$id] = 0;
                            $this->model->cleanCart();
                            break;
                        
                        case "count":
                            $value = $this->getVarFromArray($_POST, 'value', NULL);
                            $_SESSION['cart'][$id] = $value;
                            break;
                        
                        case "order":
                            $totalPrice = $this->getVarFromArray($_POST, 'total', 0);
                            
                            $ids = array_keys($_SESSION['cart']);
                            $conn = openDb();
                            
                            $result = getItemsFromDb($conn, $ids);
                            $results = sortWebshopResults($result);
                            
                            $order = '';
                            foreach($ids as $id) {
                                $count = $_SESSION['cart'][$id];
                                $price = $results[$id]['price'];
                                $order .= $id . '|' . $count . '|' . $price . ':';
    
                            }
                            $user = findByName($conn, $_SESSION['username']);
                            $userId = $user[0][0];
                            saveInOrders($conn, $userId, $order, $totalPrice);
                            $this->model->sessionManager->clearCart();
                            $this->model->sessionManager->cleanCart();
                            closeDb($conn);
                            $this->model->setPage('confirmOrder');
                            break;
                    }
                } 
        }   
    }

    

    private function showPage() {
        $page = $this->model->getPage();

        switch($page) {
            case 'home':
                include_once('./views/HomeDoc.php');
                $view = new HomeDoc($this->model);
                break;

            case 'about':
                include_once('./views/AboutDoc.php');
                $view = new AboutDoc($this->model);
                break;

            case 'contact':
                include_once('./views/FormsDoc.php');
                $view = new FormsDoc($this->model);
                break;

            case 'contactThanks':
                include_once('./views/ContactThanksDoc.php');
                $view = new ContactThanksDoc($this->model);
                break;

            case 'login':
                include_once('./views/FormsDoc.php');
                $view = new FormsDoc($this->model);
                break;
            
            case 'logout':
                include_once('./views/HomeDoc.php');
                $view = new HomeDoc($this->model);
                break;

            case 'register':
                include_once('./views/FormsDoc.php');
                $view = new FormsDoc($this->model);
                break;
            
            case 'webshop':
                include_once('./views/WebshopDoc.php');
                $view = new WebshopDoc($this->model);
                break;
            
            case "details":
                include_once('./views/DetailDoc.php');
                $view = new DetailDoc($this->model);
                break;

            case "cart":
                if(!checkCart()) {
                    include_once('./views/EmptyCartDoc.php');
                    $view = new EmptyCartDoc($this->model);
                } else {
                    include_once('./views/CartDoc.php');
                    $view = new CartDoc($this->model);
                }
                break;
            
            case "confirmOrder":
                include_once('./views/ConfirmOrderDoc.php');
                $view = new ConfirmOrderDoc($this->model);
                break;
            }

            $view->show();
        }
        
            private function session_check() {
                if ($_SESSION['lastUsed'] !== NULL){
                    $currentDate = explode("-", date('Y:m:t-H:m:s'));
                    $currentTime = $currentDate[1];
                    $currentDay = $currentDate[0];
                    $lastDate = explode("-", $_SESSION['lastUsed']);
                    $lastTime = $lastDate[1];
                    $lastDay = $lastDate[0];
                    if ($currentDay !== $lastDay) {
                        doLogout();
                        return;
                    } elseif(checkTimeout($currentTime, $lastTime)) {
                        doLogout();
                        return;
                    }
                } else {
                    doLogout();
                    return;
                }
            }

            private function getVarFromArray($array, $key, $default = NULL) {
                return isset($array[$key]) ? $array[$key] : $default;
                
            }
}

        
    

?>