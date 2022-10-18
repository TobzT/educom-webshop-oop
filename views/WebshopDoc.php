<?php 
require_once('../views/ProductDoc.php');

class WebshopDoc extends ProductDoc {

    protected $model;
    protected $items;

    public function __construct($data) {
        $this->setPage($data);
        $this->setItems($data);
        $this->setLoggedIn();
        $this->setSideMenuData();
        
    }

    private function setItems($data) {
        $this->items = $data['items'];
        return;
    }
    


    protected function showItems() {
        
        if(count($this->items) < 1){
            // TODO ERROR
        }
        $this->startGrid('shopGrid');
        
        foreach($this->items as $item) {
            $this->showItem($item);  
        }
        $this->stopGrid();
    }

    protected function showItem($item) {
        echo('<a id="normal" href="index.php?page=details&id='.$item[0].'">');
        $title = $this->showShopItemComp('shopTitle', $this->showDiv('center', 'fillbox normal', '<h3>'.$item[1].'</h3>'));
        $body = $this->showShopItemComp('shopImg', $this->showImg('fillbox', $item[4])); //showImg('fillbox', $item[4])
        $button_1 = '<form method="post" action="index.php">
                    <input type="hidden" name="id" value="'.$item[0].'">
                    <input type="hidden" name="type" value="webshop">
                    <input type="hidden" name="count" value="1">
                    <input type="hidden" name="page" value="cart">
                    <button id="details" type="submit">add to cart </button></form>';
        $button = $this->showShopItemComp('shopButton', $this->showDiv('center', 'fillbox', $button_1));
        $this->startGrid('shopItem');
        echo($this->showDiv('', 'fillbox', $title));
        echo($this->showDiv('', 'fillbox', $body));
        echo($this->showDiv('', 'fillbox', $button));
        $this->stopGrid();
        echo('</a>');
    }

    private function showShopItemComp($cssId, $value) {
        return('<div class="subShopItem" id='.$cssId.'> '.$value.'</div>');
    }

    private function showImg($cssId, $path) {
        return('<img id="'.$cssId.'"src='.$path.'>');
    }
    
    private function showDiv($class, $cssId, $content) {
        return('<div class="'.$class.'" id="'.$cssId.'">'.$content.'</div>');
    }

    protected function showBodyContent() {
        
        $this->showItems();
    }
}
?>