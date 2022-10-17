<?php 
require_once('../views/BasicDoc.php');
abstract class FormsDoc extends BasicDoc {
    protected $page;
    protected $data;

    protected function showBodyContent() {
        $this->showForm();
    }

    abstract protected function showForm();
    abstract protected function getData();
    abstract protected function showMetaForm($data);
    

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

    // protected function validateForm($data) {
    //     if($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $data['valid'] = true;
    //         $data['errors'] = NULL;
    //         foreach($data['meta'] as $key => $value) {
                
    //             $data['values'][$key] = test_inputs(getVarFromArray($_POST, $key));
    //             $data = validateField($data, $key);
    //         }
    //     }
    
    //     return $data;
    // }
    
    // protected function validateField($data, $key) {
    //     if(!empty($data['meta'][$key]['validations'])){
    //         $value = $data['values'][$key];
    //         $conn = openDb();
    //         foreach($data['meta'][$key]['validations'] as $validation) {
    //             switch($validation) { 
    //                 case 'notEmpty':
    //                     if(empty($value)) {
    //                         $data['valid'] = false;
    //                         $fieldName = explode(':', $data['meta'][$key]['label'])[0];
    //                         $data['errors'][$key] = $fieldName .' mag niet leeg zijn.';
    //                     }
    //                     break;
                        
    //                 case 'validEmail':
                        
    //                     if(!str_contains($value, '@') Or !str_contains($value, '.')) {
    //                         $data['valid'] = false;
    //                         $data['errors'][$key] = 'Dit is geen E-mail adres.';
    //                     }
    //                     break;
                        
    //                 case 'onlyNumbers':
    //                     if(!is_numeric($value)) {
    //                         $data['valid'] = false;
    //                         $data['errors'][$key] = 'Voer alleen cijfers in.';
    //                     }
    //                     break;
                        
    //                 case 'onlyLetters':
    //                     if(!ctype_alpha($value)) {
    //                         $data['valid'] = false;
    //                         $data['errors'][$key] = 'Voer alleen letters in.';
    //                     }
    //                     break;
    //                 case 'notDuplicateMail':
                        
    //                     if(findByEmailB($conn, strtolower($data['values'][$key]))) {
    //                         $data['valid'] = false;
    //                         $data['errors'][$key] = 'Dit e-mail adres is al bekend.';
    //                     }
    //                     break;
    //                 case 'validPassword':
    //                     $len = strlen($data['values'][$key]);
    //                     switch($len){
    //                         case ($len < 8):
    //                             $data['valid'] = false;
    //                             $data['errors'][$key] = 'Wachtwoord mag niet minder dan acht tekens zijn.';
    //                             break;
    //                         case ($len > 40):
    //                             $data['valid'] = false;
    //                             $data['errors'][$key] = 'Wachtwoord mag niet meer dan veertig tekens zijn.';
    //                             break;
    //                     }
    //                     break;
    //                 case 'correctPassword':
    //                     $pwInDb = findByEmail($conn, strtolower(getVarFromArray($_POST, 'email')));
    //                     if(count($pwInDb) > 0 ){
    //                         $pwInDb = test_inputs($pwInDb[0][3]);
    //                     } else {
    //                         $data['valid'] = false;
    //                         $data['errors'][$key] = 'Deze gebruiker is niet bekend.';
    //                         break;
    //                     }
    //                     $pwInPost = test_inputs($data['values'][$key]);
    //                     if($pwInDb !== $pwInPost ) {
    //                         $data['valid'] = false;
    //                         $data['errors'][$key] = 'Deze combinatie van e-mail en wachtwoord is niet bekend.';
    //                     }
    //                     break;
    //                 case str_starts_with($validation, 'equalField'):
    //                     $fields = explode(':', $validation);
    //                     if($data['values'][$key] !== $data['values'][$fields[1]]){
    //                         $data['valid'] = false;
    //                         $data['errors'][$key] = 'Twee velden komen niet overeen.';
    //                     }
    //                     break;
                        
    //             }
    //         }
    //         closeDb($conn);
    //         return $data;
    //     }
        
    //     return $data;
    // }
    
}
?>