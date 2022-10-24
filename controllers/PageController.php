<?php 

class PageController {

    private $model;
    private $view;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        $this->getRequest();

        $this->showPage();
    }

    private function getRequest() {
        $this->model->getRequestedPage();
    }

    private function showPage() {
        // $page = getVarFromArray($_GET, 'page', 'home');
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
                include_once('./models/UserModel.php');
                $this->model = new UserModel();
                $this->getRequest();
                $view = new FormsDoc($this->model);
                break;

            case 'login':
                include_once('./models/UserModel.php');
                $this->model = new UserModel();
                $this->getRequest();
                if($this->model->getIsPost()) {
                    if($this->model->getValid()) {
                        $this->model->doLogin();
                        $this->getRequest();
                        $this->model->setPage('home');
                        include_once('./views/HomeDoc.php');
                        $view = new HomeDoc($this->model);
                    } else {
                        include_once('./views/FormsDoc.php');
                        $view = new FormsDoc($this->model);
                    }
                } else {
                    include_once('./views/FormsDoc.php');
                    $view = new FormsDoc($this->model);
                }
                break;
            
            case 'logout':
                include_once('./views/HomeDoc.php');
                $this->model->doLogOut();
                $this->getRequest();
                $this->model->setPage('home');
                $view = new HomeDoc($this->model);
                break;

            case 'register':
                include_once('./views/FormsDoc.php');
                include_once('./models/UserModel.php');
                $this->model = new UserModel();
                $this->getRequest();
                $view = new FormsDoc($this->model);
                break;
            
            case 'webshop':
                include_once('./views/WebshopDoc.php');
                include_once('./models/ShopModel.php');
                if($this->model->getIsPost()) {
                    $id = (int)getVarFromArray($_POST, 'id', 0);
                    $count = (int)getVarFromArray($_POST, 'count', 0);
                    if($id !== NULL && $count !== 0) {
                        addToCart($id, $count);
                    }
                    $this->model->setPage('webshop');
                    $_GET['id'] = $id;
                }
                $this->model = new ShopModel();
                $this->getRequest();
                $view = new WebshopDoc($this->model);
                break;
            
            case "details":
                include_once('./views/DetailDoc.php');
                include_once('./models/ShopModel.php');
                
                $this->model = new ShopModel();
                $this->getRequest();
                
                $view = new DetailDoc($this->model);
                break;

            case "cart":
                include_once('./models/ShopModel.php');
                $this->model = new ShopModel();
                $this->getRequest();
                if($this->model->getIsPost()){
                    $type = getVarFromArray($_POST, 'type', NULL);
                    $id = (int)getVarFromArray($_POST, 'id', 0);

                    switch($type) {
                        case "details":
                            if($this->model->getIsPost()) {
                                $id = (int)getVarFromArray($_POST, 'id', 0);
                                $count = (int)getVarFromArray($_POST, 'count', 0);
                                if($id !== NULL && $count !== 0) {
                                    addToCart($id, $count);
                                }
                                $this->model->setPage('details');
                                $_GET['id'] = $id;
                                break;
                            }

                        case "remove":
                            $_SESSION['cart'][$id] = 0;
                            break;
    
                        case "count":
                            $value = getVarFromArray($_POST, 'value', NULL);
                            $_SESSION['cart'][$id] = $value;
                            break;
                        
                        case "order":
                            $totalPrice = getVarFromArray($_POST, 'total', 0);
                            
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
                            clearCart();
                            cleanCart();
                            closeDb($conn);
                            $this->model->setPage('confirmOrder');
                            break;
                    }
                }
                    
                    if(!checkCart()) {
                        include_once('./views/EmptyCartDoc.php');
                        $view = new EmptyCartDoc($this->model);
                    } else {
                        include_once('./views/CartDoc.php');
                        $view = new CartDoc($this->model);
                    }
                    break;
                }

                $view->show();
            }
        
}

        
    

?>