<?php 
class ShopCrud {

    private $crud;

    public function __construct($copy) {
        $this->crud = $copy;
    }

    public function createItem($name, $price, $description, $path) {
        $params = get_defined_vars();
        $sql = "INSERT INTO items (name, price, description, path) VALUES (:name, :price, :description, :path);";
        return $this->crud->createRow($sql, $params);
    }

    public function readOneShopItem($id) {
        $params = get_defined_vars();
        $sql = "SELECT * FROM items WHERE id = :id";
        return $this->crud->readOneRow($sql, $params);
    }

    public function readManyShopItems($params) {
        $len = count($params);
        $extraSql = "";
        for($i = 0; $i < $len; $i++) {
            if($i < $len - 1) {
                $extraSql .= " id = ? OR"; 
            } else {
                $extraSql .= " id = ?";
            }
        }
        $sql = "SELECT * FROM items WHERE" . $extraSql . ";";
        return $this->crud->readManyRows($sql, $params);
    }

    public function readAllShopItems() {
        $sql = "SELECT * FROM items;";
        return $this->crud->readAllRows($sql);
    }

    public function updateItem($id, $name=NULL, $price=NULL, $description=NULL, $path=NULL) {
        $params = get_defined_vars();
        $extraSql = "";
        foreach($params as $key => $value) {
            if($key !== "id" && $value !== NULL) {
                
                $extraSql .= $key . " = " . ":" .$key . ", ";
                
            } else {
                if($key == "id") { continue; }
                else { unset($params[$key]); }
            }
        }
        if($extraSql == "") {
            return false;
        }
        $extraSql = substr($extraSql, 0, strlen($extraSql) - 2) . " ";
        $sql = "UPDATE items SET " . $extraSql . "WHERE id = :id;";

        $this->crud->updateRow($sql, $params);
        return true;
    }

    public function deleteItem($id) {
        $params = get_defined_vars();
        $sql = "DELETE FROM items WHERE id = :id";
        $this->crud->deleteRow($sql, $params);
        return true;
    }

    
}
    

?>