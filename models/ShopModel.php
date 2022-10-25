<?php 
include_once('./models/PageModel.php');
include_once('./3 Data/data.php');

class ShopModel extends PageModel {

    protected $items;
    protected $id;


    public function __construct($copy) {
        PARENT::__construct($copy);
        $this->setItems();

    }
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

    public function setId($id) {
        $this->id = $id;
    }

    private function setItems() {
        $conn = openDb();
        switch($this->page) {
            case "webshop":
                $this->items = getAllItemsFromDb($conn);
                break;
            case "details":
                
                if(empty($this->id)){
                    if($this->getIsPost()){
                        $this->id = (int)$this->getVarFromArray($_POST, 'id', 1);
                    } else {
                        $this->id = (int)$this->getVarFromArray($_GET, 'id', 1);
                    }
                }
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