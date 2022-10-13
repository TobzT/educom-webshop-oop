<?php 
function showCartContent() {
    if(checkCart()) {
        showCart();
    } else {
        echo('<div>Cart is empty</div>');
    }
}

?>