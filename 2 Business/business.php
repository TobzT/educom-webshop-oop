<?php 


function getGenders() {
    return array("male" => "Dhr",
                "female" => "Mvr",
                "other" => "Anders");
}

function getOptions() {
    return array("tlf" => "Telefoon",
                "email" => "E-mail");
}



function getVarFromArray($array, $key, $default = NULL) {
    return isset($array[$key]) ? $array[$key] : $default;
    
}


//DATA
function getData($page) {
    $data = array('page' => $page, "valid" => NULL, 'errors' => array(), 'values' => array());
    $data['meta'] = getMetaData($page);
    return $data;
}

function getMetaData($page) {
    switch($page) {
        case 'login':
            return array(
                'email' => array('label' => 'E-mail: ', 'type' => 'email', 'validations' => array('validEmail', 'notEmpty')),
                'pw' => array('label' => 'Password: ', 'type' => 'password', 'validations' => array('correctPassword', 'notEmpty'))
            );
    
        case 'register':
            return array(
                'name' => array('label' => 'Name: ', 'type' => 'text', 'validations' => array('onlyLetters', 'notEmpty')),
                'email' => array('label' => 'E-mail: ', 'type' => 'email', 'validations' => array('validEmail', 'notDuplicateMail', 'notEmpty')),
                'pw' => array('label' => 'Password', 'type' => 'password', 'validations' => array('validPassword', 'notEmpty')),
                'cpw' => array('label' => 'Confim Password', 'type' => 'password', 'validations' => array('equalField:pw', 'notEmpty'))
            );

        case 'contact':
            return array(
                'gender' => array('label' => 'Aanspreeksvorm: ', 'type' => 'dropdown', 'options' => getGenders(), 'validations' => array('notEmpty')),
                'name' => array('label' => 'Name: ', 'type' => 'text', 'validations' => array('onlyLetters', 'notEmpty')),
                'email' => array('label' => 'E-mail', 'type' => 'email', 'validations' => array('validEmail', 'notEmpty')),
                'tlf' => array('label' => 'Telefoon: ', 'type' => 'number', 'validations' => array('onlyNumbers', 'notEmpty')),
                'radio' => array('label' => 'Communicatievoorkeur: ', 'type' => 'radio', 'options' => getOptions(), 'validations' => array('notEmpty')),
                'text' => array('label' => '', 'type' => 'textarea', 'validations' => array())
            );
        default:
            return NULL;
    }
}

function validateForm($data) {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $data['valid'] = true;
        $data['errors'] = NULL;
        foreach($data['meta'] as $key => $metaArray) {
            
            $data['values'][$key] = test_inputs(getVarFromArray($_POST, $key));
            $data = validateField($data, $key);
        }
    }

    return $data;
}

function validateField($data, $key) {
    if(!empty($data['meta'][$key]['validations'])){
        $value = $data['values'][$key];
        $conn = openDb();
        foreach($data['meta'][$key]['validations'] as $validation) {
            switch($validation) { 
                case 'notEmpty':
                    if(empty($value)) {
                        $data['valid'] = false;
                        $fieldName = explode(':', $data['meta'][$key]['label'])[0];
                        $data['errors'][$key] = $fieldName .' mag niet leeg zijn.';
                    }
                    break;
                    
                case 'validEmail':
                    
                    if(!str_contains($value, '@') Or !str_contains($value, '.')) {
                        $data['valid'] = false;
                        $data['errors'][$key] = 'Dit is geen E-mail adres.';
                    }
                    break;
                    
                case 'onlyNumbers':
                    if(!is_numeric($value)) {
                        $data['valid'] = false;
                        $data['errors'][$key] = 'Voer alleen cijfers in.';
                    }
                    break;
                    
                case 'onlyLetters':
                    if(!ctype_alpha($value)) {
                        $data['valid'] = false;
                        $data['errors'][$key] = 'Voer alleen letters in.';
                    }
                    break;
                case 'notDuplicateMail':
                    
                    if(findByEmailB($conn, strtolower($data['values'][$key]))) {
                        $data['valid'] = false;
                        $data['errors'][$key] = 'Dit e-mail adres is al bekend.';
                    }
                    break;
                case 'validPassword':
                    $len = strlen($data['values'][$key]);
                    switch($len){
                        case ($len < 8):
                            $data['valid'] = false;
                            $data['errors'][$key] = 'Wachtwoord mag niet minder dan acht tekens zijn.';
                            break;
                        case ($len > 40):
                            $data['valid'] = false;
                            $data['errors'][$key] = 'Wachtwoord mag niet meer dan veertig tekens zijn.';
                            break;
                    }
                    break;
                case 'correctPassword':
                    $pwInDb = findByEmail($conn, strtolower(getVarFromArray($_POST, 'email')));
                    if(count($pwInDb) > 0 ){
                        $pwInDb = test_inputs($pwInDb[0][3]);
                    } else {
                        $data['valid'] = false;
                        $data['errors'][$key] = 'Deze gebruiker is niet bekend.';
                        break;
                    }
                    $pwInPost = test_inputs($data['values'][$key]);
                    if($pwInDb !== $pwInPost ) {
                        $data['valid'] = false;
                        $data['errors'][$key] = 'Deze combinatie van e-mail en wachtwoord is niet bekend.';
                    }
                    break;
                case str_starts_with($validation, 'equalField'):
                    $fields = explode(':', $validation);
                    if($data['values'][$key] !== $data['values'][$fields[1]]){
                        $data['valid'] = false;
                        $data['errors'][$key] = 'Twee velden komen niet overeen.';
                    }
                    break;
                    
            }
        }
        closeDb($conn);
        return $data;
    }
    
    return $data;
}

//LOGIN

function doLogIn($data) {
    $conn = openDb();
    $_SESSION['username'] = findByEmail($conn, $data['values']['email'])[0][2];
    $_SESSION['lastUsed'] = date('Y:m:t-H:m:s');
    $_SESSION['cart'] = array();
    closeDb($conn);
}

function doLogOut() {
    $_SESSION['username'] = NULL;
    $_SESSION['lastUsed'] = NULL;
    $_SESSION['cart'] = NULL;
}

function session_check() {
    if ($_SESSION['lastUsed'] !== NULL){
        $currentDate = explode("-", date('Y:m:t-H:m:s'));
        $currentTime = $currentDate[1];
        $currentDay = $currentDate[0];
        $lastDate = explode("-", $_SESSION['lastUsed']);
        $lastTime = $lastDate[1];
        $lastDay = $lastDate[0];
        if ($currentDay !== $lastDay) {
            doLogout();
            return;
        } elseif(checkTimeout($currentTime, $lastTime)) {
            doLogout();
            return;
        }
    } else {
        doLogout();
        return;
    }
}

function checkTimeout($currentTime, $lastTime) {
    $currentTime = explode(":", $currentTime);
    $lastTime = explode(":", $lastTime);
    if(2 > (int)$currentTime[0] - (int)$lastTime[0]){
        return false;
    } elseif(30 > (int)$currentTime[1] - (int)$lastTime[1]) {
        return false;
    }

    return true;
}

function checkCart() {
    $check = true;
    if(isset($_SESSION['cart'])) {
        $count = 0;
        $count2 = 0;
        foreach($_SESSION['cart'] as $key => $value){
            $count += 1;
            if($value < 1) {
                $count2 += 1;
                
            }
        }
        if ($count2 == $count) {
            $check = false;
        }
    } else {
        $check = false;
    }
    
    return $check;
}

//REGISTER

function registerUser($conn, $data) {
    $name = $data['values']['name'];
    $email = $data['values']['email'];
    $pw = $data['values']['pw'];
    saveInDb($conn, $email, $name, $pw);
}




//HOME


//ABOUT


//CONTACT
function test_inputs($data) {
    if(!empty($data)){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
    }
    
    return $data;
}




function showMetaForm($data, $text) {

    showFormStart();
    // var_dump($data);
    foreach(array_keys($data['meta']) as $key){
        $meta = $data['meta'][$key];
        showMetaFormItem($key, $data, $meta);
    }
    showFormEnd($data['page'], $text);
}

function showMetaFormItem($key, $data, $meta) {
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

            echo(repeatingForm($meta['options'], $data['values'][$key]));

            echo('</select>');
            break;
        
        case "radio":
            echo('
                <p><h3 class="error"> '. $data['errors'][$key] .'</h3></p>
            ');

            echo(repeatingRadio($meta['options'], $data['values'][$key], $key));

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

function repeatingForm($options, $value) {
    
    $count = count($options);
    $keys = array_keys($options);
    for ($i = 0; $i < $count; $i++) {
        echo('<option value="'.$keys[$i].'"'.(($value == $keys[$i]) ? "selected" : "").'>'.$options[$keys[$i]].'</option><br>');
    }
}

function repeatingRadio($options, $value, $key) {
    $count = count($options);
    $keys = array_keys($options);
    for ($i = 0; $i < $count; $i++) {
        echo('
            <input type="radio" name="'.$key.'" id="'.$keys[$i].'"value="'.$keys[$i].'"'.(($value == $keys[$i]) ? "checked" : "").'></option>
            <label for="'.$keys[$i].'">'.$options[$keys[$i]].'</label><br>
        ');
    }
    
}

function radioCheck($data, $key, $option) {
    return ($data['values'][$key] == $option) ? "checked" : "";
}


//WEBSHOP
function startGrid($class) {
    echo('<div class="'.$class.'">');
}

function stopGrid() {
    echo('</div>');
}

function showShopItemComp($cssId, $value) {
    return('<div class="subShopItem" id='.$cssId.'> '.$value.'</div>');
}

function showImg($cssId, $path) {
    return('<img id="'.$cssId.'"src='.$path.'>');
}

function showDiv($class, $cssId, $content) {
    return('<div class="'.$class.'" id="'.$cssId.'">'.$content.'</div>');
}



function showItems($data) {
    $conn = openDb();
    $items = getAllItemsFromDb($conn);
    closeDb($conn);
    if(count($items) < 1){
        // TODO ERROR
    }
    startGrid('shopGrid');
    foreach($items as $item) {
        showItem($item);  
    }
    stopGrid();

}

function showItem($item) {
    echo('<a href="index.php?page=details&id='.$item[0].'">');
    $title = showShopItemComp('shopTitle', showDiv('center', 'fillbox', '<h3>'.$item[1].'</h3>'));
    $body = showShopItemComp('shopImg', showImg('fillbox', $item[4])); //showImg('fillbox', $item[4])
    $button_1 = '<form method="post" action="index.php">
                <input type="hidden" name="id" value="'.$item[0].'">
                <input type="hidden" name="type" value="webshop">
                <input type="hidden" name="count" value="1">
                <input type="hidden" name="page" value="cart">
                <button id="details" type="submit">add to cart </button></form>';
    $button = showShopItemComp('shopButton', showDiv('center', 'fillbox', $button_1));
    startGrid('shopItem');
    echo(showDiv('', 'fillbox', $title));
    echo(showDiv('', 'fillbox', $body));
    echo(showDiv('', 'fillbox', $button));
    stopGrid();
    echo('</a>');

}









function showDetails($data) {
    $id = $data['id'];
    $conn = openDb();
    $item = getItemFromDb($conn, $id);
    if(count($item) < 1){
        //TODO ERROR
    }
    $item = $item[0];
    closeDb($conn);
    startGrid('detailgrid');
    echo('<div class="detailtitle"><h1>'.$item[1].'</h1></div>');
    echo('<div class="detailprice"><p>€'.round($item[2], 2).'</p> 
        <form method="post" action="index.php">
        <input type="hidden" name="id" value="'.$item[0].'">
        <input type="hidden" name="type" value="details">
        <input type="hidden" name="count" value="1">
        <input type="hidden" name="page" value="cart">
        <button id="details" type="submit">add to cart</button></form></div>');
    echo('<div class="detaildesc"><p>'.$item[3].'</p> </div>');
    echo('<div class="detailimg"><img src='.$item[4].'></div>');
    stopGrid();

}

function cleanCart() {
    foreach($_SESSION['cart'] as $id => $count) {
        if($count < 1) {
            unset($_SESSION['cart'][$id]);
        }
    }
}

function clearCart() {
    foreach($_SESSION['cart'] as $id => $count) {
        $_SESSION['cart'][$id] = 0;
    }
}
function showCart() {
    $total = 0;
    startGrid('cartGrid');
    showCartHeaders();
    cleanCart();
    $conn = openDb();
    $result = getItems($conn, array_keys($_SESSION['cart']));
    closeDb($conn);
    $itemArray = sortWebshopResults($result);
    foreach($_SESSION['cart'] as $id => $count) {
        $total += cartLine($conn, $itemArray, $id, $count);
    }
    stopGrid();
    startGrid('cartGrid');
    showTotal($total);
    stopGrid();
    startGrid('cartGrid');
    showOrderButton($total);
    stopGrid();
    
    
    
}

function cartLine($conn, $itemArray, $id, $count) {
    if($count > 0){
        startCartLine();
        showCartItem('image', $id, $itemArray[$id]['path'], true);
        showCartItem('name', $id, $itemArray[$id]['name']);
        showCartItem('price', $id, '€ ' . round($itemArray[$id]['price'], 2)); 
        showCartItem('count', $id, showCountForm($count, $id));
        $subtotal = round((int)$count * (float)$itemArray[$id]['price'], 2);
        showCartItem('subtotal', $id, '€ ' . round($subtotal, 2));
        showCartItem('remove', $id, showRemoveButton($id));
        
        stopCartLine();
        return $subtotal;
    }
    return 0;
    
}

function showCartItem($cssId, $id = NULL, $value = null, $image = false) {
    if($image) {
        $value = '<img src="'.$value.'">';
    }
    if($cssId !== 'count' && $id !== NULL) {
        echo('<a class="cartItem" id="'.$cssId.'" href="index.php?page=details&id='.$id.'">'.$value.'</a>');
    } else {
        echo('<div class="cartItem" id="'.$cssId.'">'.$value.'</div>');
    }
    
    // if($cssId !== 'count' && $id !== NULL) { echo('</a>'); }

}

function showTotal($total) {
    startCartLine();
    showCartItem('rest');
    showCartItem('total', NULL, '€ ' . round($total, 2));
    showCartItem('remove');
    stopCartLine();
}

function startCartLine() {
    echo('<div class="cartLine" id="line">');
}

function stopCartLine($id = null) {
    echo('</div>');
    if($id !== null) {
    echo('</a>');
    }
}

function showCartHeaders(){
    startCartLine();
    showCartItem('image');
    showCartItem('name', NULL, 'Naam');
    showCartItem('price', NULL, 'Prijs');
    showCartItem('count', NULL, 'Aantal');
    showCartItem('subtotal', NULL, 'Subtotaal');
    stopCartLine();
}
function showCountForm($count, $id) {
    $html = '
        <form method="post" action="index.php">
            <input type="hidden" name="page" value="cart">
            <input type="hidden" name="type" value="count">
            <input type="hidden" name="id" value="'.$id.'">
            <input type="number" name="value" value="'.$count.'" id="small"></input>
            <button type="submit">Apply</button>
        </form>
    ';
    // <button type="submit">Apply</button>
    return $html;
}

function showRemoveButton($id) {
    $html = '
    <form method="post" action="index.php">
        <input type="hidden" name="id" value="'.$id.'">
        <input type="hidden" name="type" value="remove">
        <input type="hidden" name="page" value="cart">

        <button action="submit" id="small">Remove</button>
    </form>
    ';

    return $html;
}

function showOrderButton($total) {
    startCartLine();
    showCartItem('rest');
    echo('<div class="cartItem" id="total">');
    echo('<form method="post" action="index.php">');
    echo('<input type="hidden" name="type" value="order">');
    echo('<input type="hidden" name="page" value="cart">');
    echo('<input type="hidden" name="total" value="'.$total.'">');
    echo('<button type="submit">Order</button>');
    echo('</form>');
    echo('</div>');
    showCartItem('remove');
    stopCartLine();
}

function addToCart($id, $count) {
    if (isset($_SESSION['username'])){
        if(array_key_exists($id, $_SESSION['cart'])) {
            $_SESSION['cart'][$id] += (int)$count;
        } else {
            $_SESSION['cart'][$id] = (int)$count;
        }
    } 
}

function sortWebshopResults($results) {
    $output = [];
    foreach($results as $line) {
        $output[$line[0]] = ['name' => $line[1], 'price' => $line[2], 'desc' => $line[3], 'path' => $line[4]];
    }
    return $output;
}



?>