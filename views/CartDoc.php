<?php 
require_once('../views/ProductDoc.php');

class CartDoc extends ProductDoc {

    private function showCart() {
        $items = $this->data['items'];
        $total = 0;
        $this->startGrid('cartGrid');
        $this->showCartHeaders();
        $items = $this->sortWebshopResults($items);
        foreach($_SESSION['cart'] as $id => $count) {
            $total += $this->cartLine($items, $id, $count);
        }
        $this->stopGrid();
        $this->startGrid('cartGrid');
        $this->showTotal($total);
        $this->stopGrid();
        $this->startGrid('cartGrid');
        $this->showOrderButton($total);
        $this->stopGrid();

    }

    private function cartLine($items, $id, $count) {
        if($count > 0) {
            $this->startCartLine();
            $this->showCartItem('image', $id, $items[$id]['path'], true);
            $this->showCartItem('name', $id, $items[$id]['name']);
            $this->showCartItem('price', $id, '€ ' . round($items[$id]['price'], 2)); 
            $this->showCartItem('count', $id, $this->showCountForm($count, $id));
            $subtotal = round((int)$count * (float)$items[$id]['price'], 2);
            $this->showCartItem('subtotal', $id, '€ ' . round($subtotal, 2));
            $this->showCartItem('remove', $id, $this->showRemoveButton($id));
            
            $this->stopCartLine();
            return $subtotal;
        }
        return 0;
    }

    private function showCartHeaders() {
        $this->startCartLine();
        $this->showCartItem('image');
        $this->showCartItem('name', NULL, 'Naam');
        $this->showCartItem('price', NULL, 'Prijs');
        $this->showCartItem('count', NULL, 'Aantal');
        $this->showCartItem('subtotal', NULL, 'Subtotaal');
        $this->stopCartLine();
    }
    
    private function startCartLine() {
        echo('<div class="cartLine" id="line">');
    }

    private function stopCartLine() {
        echo('</div>');
    }

    private function showCartItem($cssId, $id = NULL, $value = null, $image = false) {
        if($image) {
            $value = '<img src="'.$value.'">';
        }
        if($cssId !== 'count' && $id !== NULL) {
            echo('<a class="cartItem" id="'.$cssId.'" href="index.php?page=details&id='.$id.'">'.$value.'</a>');
        } else {
            echo('<div class="cartItem" id="'.$cssId.'">'.$value.'</div>');
        }
    
    }

    private function showTotal($total) {
        $this->startCartLine();
        $this->showCartItem('rest');
        $this->showCartItem('total', NULL, '€ ' . round($total, 2));
        $this->showCartItem('remove');
        $this->stopCartLine();
    }

    private function showOrderButton($total) {
        $this->startCartLine();
        $this->showCartItem('rest');
        echo('<div class="cartItem" id="total">');
        echo('<form method="post" action="index.php">');
        echo('<input type="hidden" name="type" value="order">');
        echo('<input type="hidden" name="page" value="cart">');
        echo('<input type="hidden" name="total" value="'.$total.'">');
        echo('<button type="submit">Order</button>');
        echo('</form>');
        echo('</div>');
        $this->showCartItem('remove');
        $this->stopCartLine();
    }

    

    private function showCountForm($count, $id) {
        $html = '
            <form method="post" action="index.php">
                <input type="hidden" name="page" value="cart">
                <input type="hidden" name="type" value="count">
                <input type="hidden" name="id" value="'.$id.'">
                <input type="number" name="value" value="'.$count.'" id="small"></input>
                <button type="submit">Apply</button>
            </form>
        ';
        return $html;
    }

    private function showRemoveButton($id) {
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


    protected function showBodyContent() {
        $this->showCart();
    }
}

?>