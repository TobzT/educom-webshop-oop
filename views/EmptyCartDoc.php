<?php 
require_once("./views/BasicDoc.php");

class EmptyCartDoc extends BasicDoc {

    protected function showBodyContent() {
        $this->showEmpty();
    }

    private function showEmpty() {
        echo('Cart is empty');
    }
}
?>