<?php 
class Crud {
    private $pdo;
    private $connstring = "mysql:host=localhost;dbname=tobias_webshop;";
    private $username = "tobias_webshop";
    private $password = "EducomCheeta";
    public function __construct() {
        $this->pdo = new PDO($this->connstring, $this->username, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo($this->pdo);
    }
    
    public function createRow($sql, $params) {
        $statement = $this->pdo->prepare($sql);
        foreach($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return true;
    }

    public function readOneRow($sql, $params) {
        $statement = $this->pdo->prepare($sql);
        foreach($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return $statement->fetch();
    }

    public function readManyRows($sql, $params) {
        $statement = $this->pdo->prepare($sql);
        foreach($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return $statement->fetch();
    }

    public function updateRow($sql, $params) {
        $statement = $this->pdo->prepare($sql);
        foreach($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->setFetchMode(PDO::FETCH_OBJ);
        $statement->execute();
        return true;
    }
}

$crud = new Crud();
$sql = "SELECT * FROM users WHERE id = :id";
$params = array(":id" => 12);
print_r($crud->readOneRow($sql, $params));
?>