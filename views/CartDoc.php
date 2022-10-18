<?php 
require_once('../views/ProductDoc.php');

class CartDoc extends ProductDoc {

    protected function showItems() {
        $total = 0;
        $this->startGrid('cartGrid');
        showCartHeaders();
        cleanCart();
        $conn = openDb();
        $result = getItems($conn, array_keys($_SESSION['cart']));
        closeDb($conn);
        $itemArray = sortWebshopResults($result);
        foreach($_SESSION['cart'] as $id => $count) {
            $total += cartLine($itemArray, $id, $count);
        }
        stopGrid();
        startGrid('cartGrid');
        showTotal($total);
        stopGrid();
        startGrid('cartGrid');
        showOrderButton($total);
        stopGrid();
    }

    protected function showItem($data) {

    }

    protected function showBodyContent() {
        $this-showItems();
    }
}

?>