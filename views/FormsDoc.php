<?php 
require_once('./views/BasicDoc.php');
class FormsDoc extends BasicDoc {
    


    protected function showBodyContent() {
        $this->showMetaForm();
    }


    protected function showMetaForm(){
        $this->showFormStart();
        $array = $this->model->getMeta();
        $this->values = $this->model->getValues();
        $this->errors = $this->model->getErrors();
        foreach(array_keys($array) as $key){
            $meta = $array[$key];
            $this->showMetaFormItem($key, $meta);
        }
        $this->showFormEnd($this->model->getPage(), $this->model->getSubmitlabel());
    }
    

    protected function showFormStart(){
        echo('<form action="index.php" method="post" class="body">');
    }
    
    protected function ShowFormEnd($page, $submitText) {
        echo('<input type="hidden" name="page" value="'.$page.'">');
        echo('<button type="submit">'.$submitText.'</button></form>');
    }

    protected function repeatingForm($options, $value) {
    
        $count = count($options);
        $keys = array_keys($options);
        for ($i = 0; $i < $count; $i++) {
            echo('<option value="'.$keys[$i].'"'.(($value == $keys[$i]) ? "selected" : "").'>'.$options[$keys[$i]].'</option><br>');
        }
    }
    protected function repeatingRadio($options, $value, $key) {
        $count = count($options);
        $keys = array_keys($options);
        for ($i = 0; $i < $count; $i++) {
            echo('
                <input type="radio" name="'.$key.'" id="'.$keys[$i].'"value="'.$keys[$i].'"'.(($value == $keys[$i]) ? "checked" : "").'></option>
                <label for="'.$keys[$i].'">'.$options[$keys[$i]].'</label><br>
            ');
        }
        
    }
    protected function showMetaFormItem($key, $meta) {
        echo('<div>
            <label for="'.$key.'">'.$meta['label'].'</label>'
        );
    
        if(empty($this->values[$key])) {
            $this->values[$key] = '';
        }
    
        if(empty($this->errors[$key])) {
            $this->errors[$key] = '';
        }
    
        switch ($meta['type']) {
            case "dropdown":
                echo('
                        <select name="'.$key.'" id="'.$key.'" >');
    
                echo($this->repeatingForm($meta['options'], $this->values[$key]));
    
                echo('</select>');
                break;
            
            case "radio":
                echo('
                    <p><h3 class="error"> '. $this->errors[$key] .'</h3></p>
                ');
    
                echo($this->repeatingRadio($meta['options'], $this->values[$key], $key));
    
                break;
            
            case "textarea":
                echo('
                    
                    <textarea class=input name="'.$key.'" cols="40" rows="10"></textarea>
    
                    
                ');
                break;
            
            default:
                echo('
                        <input class="input" type="'.$meta['type'].'" id="'.$key.'" name="'.$key.'" value="'. $this->values[$key] .'">
                        
                        <h3 class="error">'.$this->errors[$key] . '</h3>
                    
                ');
                break;
        }
        echo('</div><br>');
    }

    protected function getGenders() {
        return array("male" => "Dhr",
                "female" => "Mvr",
                "other" => "Anders"); 
    }

    protected function getOptions() {
        return array("tlf" => "Telefoon",
                "email" => "E-mail");
    }

}
?>