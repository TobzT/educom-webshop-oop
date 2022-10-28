<?php 

class UserCrud {

    private $crud;

    public function __construct($copy) {
        $this->crud = $copy;
    }

    public function createUser($email, $name, $pw) {
        $params = get_defined_vars();
        $sql = "INSERT INTO users (email, name, pw) VALUES (:email, :name, :pw);";
        
        $this->crud->createRow($sql, $params);
        return true;
    }

    public function readUserByEmail($email) {
        $params = get_defined_vars();
        $sql = "SELECT * FROM users WHERE email = :email;";
        return $this->crud->readOneRow($sql, $params);
    }

    public function readUserById($id) {
        $params = get_defined_vars();
        $sql = "SELECT * FROM users WHERE id = :id;";
        return $this->crud->readOneRow($sql, $params);
    }

    // can only update by id
    public function updateUser($id, $name=NULL, $email=NULL, $pw=NULL) {
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
        $sql = "UPDATE users SET " . $extraSql . "WHERE id = :id;";
        
        $this->crud->updateRow($sql, $params);
        return true;
    }

    // can only delete by id
    public function deleteUser($id) {
        $params = get_defined_vars();
        $sql = "DELETE FROM users WHERE id = :id";
        $this->crud->deleteRow($sql, $params);
        return true;
    }


}


?>