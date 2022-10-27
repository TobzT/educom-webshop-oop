<?php 
class Crud {
    private $pdo;
    private $statement;
    private $connstring = "mysql:host=localhost;dbname=tobias_webshop;";
    private $username = "tobias_webshop";
    private $password = "EducomCheeta";
    public function __construct() {
        $this->pdo = new PDO($this->connstring, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPDO() {
        return $this->pdo;
    }
    
    public function createRow($sql, $params) {
        $this->prepareAndBind($sql, $params);
        $this->statement->execute();
        return true;
    }

    public function readOneRow($sql, $params) {
        $this->prepareAndBind($sql, $params);
        $this->statement->execute();
        return $this->statement->fetch();
    }

    public function readManyRows($sql, $params) {
        $this->prepareAndBind($sql, $params);
        $this->statement->execute();
        return $this->statement->fetchAll();
    }

    public function readAllRows($sql) {
        $this->statement = $this->pdo->prepare($sql);
        $this->statement->execute();
        return $this->statement->fetchAll();
    }

    public function updateRow($sql, $params) {
        $this->prepareAndBind($sql, $params);
        $this->statement->execute();
        return true;
    }

    public function deleteRow($sql, $params) {
        $this->prepareAndBind($sql, $params);
        $this->statement->execute();
        return true;
    }

    private function prepareAndBind($sql, $params) {
        $this->statement = $this->pdo->prepare($sql);
        foreach($params as $key => $value) {
            $this->statement->bindValue(":".$key, $value);
        }
        $this->statement->setFetchMode(PDO::FETCH_OBJ);
    }
}



// $crud = new Crud();
// $sql = 'UPDATE users SET name = :name WHERE id = :id';
// $params = array(":name" => "TOBZZZZ", ":id" => 29);
// print_r($crud->updateRow($sql, $params));
?>