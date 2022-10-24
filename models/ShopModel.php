<?php 
include_once('./models/PageModel.php');
include_once('./3 Data/data.php');

class ShopModel extends PageModel {

    protected $items;
    protected $id;

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
        $this->setItems();

    }

    public function getItems() {
        return $this->items;
    }

    public function getId() {
        return $this->id;
    }

    private function setItems() {
        $conn = openDb();
        switch($this->page) {
            case "webshop":
                $this->items = getAllItemsFromDb($conn);
                break;
            case "details":
                $this->id = $this->getVarFromArray($_GET, 'id', '1');
                $this->items = getItemFromDb($conn, $this->id);
                break;
            case "cart":
                if(!empty($_SESSION['cart'])) {
                    $ids = array_keys($_SESSION['cart']);
                    $this->items = getItemsFromDb($conn, $ids);
                } else {
                    $this->items = NULL;
                }
                
                break;
        }
        closeDb($conn);
    }

}

?>