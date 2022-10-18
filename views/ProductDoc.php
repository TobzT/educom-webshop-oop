<?php 
require_once('./views/BasicDoc.php');
abstract class ProductDoc extends BasicDoc {

    protected function startGrid($class) {
        echo('<div class='.$class.'>');
    }
    
    protected function stopGrid() {
        echo('</div>');
    }

    protected function sortWebshopResults($results) {
        $output = [];
        foreach($results as $line) {
            $output[$line[0]] = ['id' => $line[0], 'name' => $line[1], 'price' => $line[2], 'desc' => $line[3], 'path' => $line[4]];
        }
        return $output;
    }
}
?>