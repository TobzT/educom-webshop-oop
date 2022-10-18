<?php 
require_once('../views/BasicDoc.php');
abstract class ProductDoc extends BasicDoc {

    protected function startGrid($class) {
        echo('<div class='.$class.'>');
    }
    
    protected function stopGrid() {
        echo('</div>');
    }
}
?>