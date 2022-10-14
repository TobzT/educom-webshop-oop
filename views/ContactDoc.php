<?php 
require_once('../views/FormsDoc');
class ContactDoc extends FormsDoc {
    protected function getData() {
        $data = array('page' => 'contact', "valid" => NULL, 'errors' => array(), 'values' => array());
        $data['meta'] = array(
            'gender' => array('label' => 'Aanspreeksvorm: ', 'type' => 'dropdown', 'options' => getGenders(), 'validations' => array('notEmpty')),
            'name' => array('label' => 'Name: ', 'type' => 'text', 'validations' => array('onlyLetters', 'notEmpty')),
            'email' => array('label' => 'E-mail', 'type' => 'email', 'validations' => array('validEmail', 'notEmpty')),
            'tlf' => array('label' => 'Telefoon: ', 'type' => 'number', 'validations' => array('onlyNumbers', 'notEmpty')),
            'radio' => array('label' => 'Communicatievoorkeur: ', 'type' => 'radio', 'options' => getOptions(), 'validations' => array('notEmpty')),
            'text' => array('label' => '', 'type' => 'textarea', 'validations' => array())
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
        $this->showFormEnd($data['page'], 'Submit');
    }
}
?>