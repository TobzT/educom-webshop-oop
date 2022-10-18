<?php 
require_once('../views/BasicDoc.php');
abstract class ProductDoc extends BasicDoc {

    // abstract protected function showBodyContent();
    abstract protected function showItems();
    abstract protected function showItem($item);
    protected function startGrid($class) {
        echo('<div class='.$class.'>');
    }
    
    protected function stopGrid() {
        echo('</div>');
    }
}
?>