<?php 
require_once('./views/ProductDoc.php');
class DetailDoc extends ProductDoc {

    private function showDetails() {
        $id = (int)$this->model->getId();
        $item = $this->model->getItems();
        // $item = $this->sortWebshopResults($item);
        $this->startGrid('detailgrid');
        echo('<div class="detailtitle"><h1>'.$item->name.'</h1></div>');
        echo('<div class="detailprice"><p>€'.round($item->price / 100, 2).'</p> 
            <form method="post" action="index.php">
            <input type="hidden" name="id" value="'.$item->id.'">
            <input type="hidden" name="type" value="details">
            <input type="hidden" name="count" value="1">
            <input type="hidden" name="page" value="details">
            <button id="details" type="submit">add to cart</button></form></div>');
        echo('<div class="detaildesc"><p>'.$item->description.'</p> </div>');
        echo('<div class="detailimg"><img src='.$item->path.'></div>');
        $this->stopGrid();
    
    }

    protected function showBodyContent() {
        $this->showDetails();
    }
}
?>