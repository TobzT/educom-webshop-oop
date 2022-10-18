<?php 
require_once('../views/BasicDoc.php');
class FormsDoc extends BasicDoc {
    

    protected function showBodyContent() {
        $this->showMetaForm();
    }


    protected function showMetaForm(){
        $this->showFormStart();
        $data = $this->data;
        // var_dump($data);
        foreach(array_keys($data['meta']) as $key){
            $meta = $data['meta'][$key];
            $this->showMetaFormItem($key, $data, $meta);
        }
        $this->showFormEnd($data['page'], $data['submitLabel']);
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
    protected function showMetaFormItem($key, $data, $meta) {
        echo('<div>
            <label for="'.$key.'">'.$meta['label'].'</label>'
        );
    
        if(empty($data['values'][$key])) {
            $data['values'][$key] = '';
        }
    
        if(empty($data['errors'][$key])) {
            $data['errors'][$key] = '';
        }
    
        switch ($meta['type']) {
            case "dropdown":
                echo('
                        <select name="'.$key.'" id="'.$key.'" >');
    
                echo($this->repeatingForm($meta['options'], $data['values'][$key]));
    
                echo('</select>');
                break;
            
            case "radio":
                echo('
                    <p><h3 class="error"> '. $data['errors'][$key] .'</h3></p>
                ');
    
                echo($this->repeatingRadio($meta['options'], $data['values'][$key], $key));
    
                break;
            
            case "textarea":
                echo('
                    
                    <textarea class=input name="'.$key.'" cols="40" rows="10"></textarea>
    
                    
                ');
                break;
            
            default:
                echo('
                        <input class="input" type="'.$meta['type'].'" id="'.$key.'" name="'.$key.'" value="'. $data['values'][$key] .'">
                        
                        <h3 class="error">'.$data['errors'][$key] .'</h3>
                    
                ');
                break;
        }
        echo('</div><br>');
    }

}
?>