<?php 
require_once('../views/FormsDoc.php');

class RegisterDoc extends FormsDoc {

    protected function getData() {
        $data = array('page' => 'register', "valid" => NULL, 'errors' => array(), 'values' => array());
        $data['meta'] = array(
            'name' => array('label' => 'Name: ', 'type' => 'text', 'validations' => array('onlyLetters', 'notEmpty')),
            'email' => array('label' => 'E-mail: ', 'type' => 'email', 'validations' => array('validEmail', 'notDuplicateMail', 'notEmpty')),
            'pw' => array('label' => 'Password', 'type' => 'password', 'validations' => array('validPassword', 'notEmpty')),
            'cpw' => array('label' => 'Confim Password', 'type' => 'password', 'validations' => array('equalField:pw', 'notEmpty'))
        );
        return $data;
    }
    protected function showForm() {
        $this->data = $this->getData();
        $this->showMetaForm($this->data);
        
    }

    protected function showMetaForm($data) {

        $this->showFormStart();
        // var_dump($data);
        foreach(array_keys($data['meta']) as $key){
            $meta = $data['meta'][$key];
            $this->showMetaFormItem($key, $data, $meta);
        }
        $this->showFormEnd($data['page'], 'Sign Up');
    }

}
?>