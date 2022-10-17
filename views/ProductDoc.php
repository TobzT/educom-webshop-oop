<?php 
require_once('../views/BasicDoc.php');
abstract class ProductDoc extends BasicDoc {

    abstract function showItems($data);
    abstract function showItem($data);
    abstract function startGrid();
    protected function stopGrid() {
        echo('</div>');
    }

    //function startGrid($class) {
    //echo('<div class="'.$class.'">');
    //}
}
?>