<?php 
include_once("./1 Presentation/cart.php");
function showWebshopContent($data) {
    showItems($data);
}

function showDetailsContent($data) {
    $data['page'] = getVarFromArray($_GET, 'page', 'home');
    $data['id'] = getVarFromArray($_GET, 'id', 1);
    showDetails($data);
}


?>