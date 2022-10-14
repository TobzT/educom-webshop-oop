<?php 
require_once('../views/FormsDoc');

class LoginDoc extends FormsDoc {

    protected function getData() {
        $data = array('page' => 'login', "valid" => NULL, 'errors' => array(), 'values' => array());
        $data['meta'] = array(
                            'email' => array('label' => 'E-mail: ', 'type' => 'email', 'validations' => array('validEmail', 'notEmpty')),
                            'pw' => array('label' => 'Password: ', 'type' => 'password', 'validations' => array('correctPassword', 'notEmpty')));
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
        $this->showFormEnd($data['page'], 'Log in');
    }

}
?>