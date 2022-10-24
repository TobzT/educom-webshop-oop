<?php 
include_once('./models/PageModel.php');
include_once('./3 Data/data.php');

class UserModel extends PageModel {
    
    protected $submitLabel;
    protected $meta = array();
    protected $errors = array();
    protected $values = array();
    protected $valid = true;



    public function getRequestedPage() {

        $this->sessionManager = new SessionManager();

        $request_type = $_SERVER["REQUEST_METHOD"];
        $this->isPost = $request_type == "POST";
    
        if ($this->isPost) {
            $this->page =  $this->getVarFromArray($_POST, 'page', 'home');
            
        } else {
            $this->page =  $this->getVarFromArray($_GET, 'page', 'home');
        }

        $this->createMenuArr();
        $this->setMetaData();

        if($this->isPost) {
            $this->validateForm();
        }

        

    }

    public function getPage() {
        return $this->page;
    }

    public function getMeta() {
        return $this->meta;
    }

    public function getSubmitLabel() {
        return $this->submitLabel;
    }

    public function getValues() {
        return $this->values;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getValid() {
        return $this->valid;
    }




    private function setMetaData() {
        switch($this->page) {
            case "login":
                $this->meta = array(
                    'email' => array('label' => 'E-mail: ', 'type' => 'email', 'validations' => array('validEmail', 'notEmpty')),
                    'pw' => array('label' => 'Password: ', 'type' => 'password', 'validations' => array('correctPassword', 'notEmpty'))
                );
                $this->submitLabel = 'Log in';
                break;

            case 'register':
                $this->meta =  array(
                    'name' => array('label' => 'Name: ', 'type' => 'text', 'validations' => array('onlyLetters', 'notEmpty')),
                    'email' => array('label' => 'E-mail: ', 'type' => 'email', 'validations' => array('validEmail', 'notDuplicateMail', 'notEmpty')),
                    'pw' => array('label' => 'Password', 'type' => 'password', 'validations' => array('validPassword', 'notEmpty')),
                    'cpw' => array('label' => 'Confim Password', 'type' => 'password', 'validations' => array('equalField:pw', 'notEmpty'))
                );
                $this->submitLabel = 'Sign up';
                break;
            
            case 'contact':
                $this->meta = array(
                    'gender' => array('label' => 'Aanspreeksvorm: ', 'type' => 'dropdown', 'options' => getGenders(), 'validations' => array('notEmpty')),
                    'name' => array('label' => 'Name: ', 'type' => 'text', 'validations' => array('onlyLetters', 'notEmpty')),
                    'email' => array('label' => 'E-mail', 'type' => 'email', 'validations' => array('validEmail', 'notEmpty')),
                    'tlf' => array('label' => 'Telefoon: ', 'type' => 'number', 'validations' => array('onlyNumbers', 'notEmpty')),
                    'radio' => array('label' => 'Communicatievoorkeur: ', 'type' => 'radio', 'options' => getOptions(), 'validations' => array('notEmpty')),
                    'text' => array('label' => '', 'type' => 'textarea', 'validations' => array())
                );
                $this->submitLabel = 'Submit';
                break;

            default:
                return NULL;
        }
    }

    private function validateForm() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->valid = true;
            $this->errors = NULL;
            foreach($this->meta as $key => $metaArray) {
                
                $this->values[$key] = test_inputs(getVarFromArray($_POST, $key));
                $data = $this->validateField($key);
            }
        }
    
        return $data;
    }

    private function validateField($key) {
        if(!empty($this->meta[$key]['validations'])){
            $value = $this->values[$key];
            $conn = openDb();
            foreach($this->meta[$key]['validations'] as $validation) {
                switch($validation) { 
                    case 'notEmpty':
                        if(empty($value)) {
                            $this->valid = false;
                            $fieldName = explode(':', $this->meta[$key]['label'])[0];
                            $this->errors[$key] = $fieldName .' mag niet leeg zijn.';
                        }
                        break;
                        
                    case 'validEmail':
                        
                        if(!str_contains($value, '@') Or !str_contains($value, '.')) {
                            $this->valid = false;
                            $this->errors[$key] = 'Dit is geen E-mail adres.';
                        }
                        break;
                        
                    case 'onlyNumbers':
                        if(!is_numeric($value)) {
                            $this->valid = false;
                            $this->errors[$key] = 'Voer alleen cijfers in.';
                        }
                        break;
                        
                    case 'onlyLetters':
                        if(!ctype_alpha($value)) {
                            $this->valid = false;
                            $this->errors[$key] = 'Voer alleen letters in.';
                        }
                        break;
                    case 'notDuplicateMail':
                        
                        if(findByEmailB($conn, strtolower($this->values[$key]))) {
                            $this->valid = false;
                            $this->errors[$key] = 'Dit e-mail adres is al bekend.';
                        }
                        break;
                    case 'validPassword':
                        $len = strlen($this->values[$key]);
                        switch($len){
                            case ($len < 8):
                                $this->valid = false;
                                $this->errors[$key] = 'Wachtwoord mag niet minder dan acht tekens zijn.';
                                break;
                            case ($len > 40):
                                $this->valid = false;
                                $this->errors[$key] = 'Wachtwoord mag niet meer dan veertig tekens zijn.';
                                break;
                        }
                        break;
                    case 'correctPassword':
                        $pwInDb = findByEmail($conn, strtolower(getVarFromArray($_POST, 'email')));
                        if(count($pwInDb) > 0 ){
                            $pwInDb = test_inputs($pwInDb[0][3]);
                        } else {
                            $this->valid = false;
                            $this->errors[$key] = 'Deze gebruiker is niet bekend.';
                            break;
                        }
                        $pwInPost = test_inputs($this->values[$key]);
                        if($pwInDb !== $pwInPost ) {
                            $this->valid = false;
                            $this->errors[$key] = 'Deze combinatie van e-mail en wachtwoord is niet bekend.';
                        }
                        break;
                    case str_starts_with($validation, 'equalField'):
                        $fields = explode(':', $validation);
                        if($this->values[$key] !== $this->values[$fields[1]]){
                            $this->valid = false;
                            $this->errors[$key] = 'Twee velden komen niet overeen.';
                        }
                        break;
                        
                }
            }
            closeDb($conn);
            
        }
        
        
    }

    
}

?>