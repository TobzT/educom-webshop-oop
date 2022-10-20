<?php 

class PageController {

    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        $this->model->getRequestedPage();
    }
}
?>