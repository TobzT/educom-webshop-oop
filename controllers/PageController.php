<?php 

class PageController {

    private $model;
    private $view;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        $this->getRequest();

        $this->showPage();
    }

    private function getRequest() {
        $this->model->getRequestedPage();
    }

    private function showPage() {
        $page = $this->model->getPage();

        switch($page) {
            case 'home':
                include_once('./views/HomeDoc.php');
                $view = new HomeDoc($this->model);
                break;

            case 'about':
                include_once('./views/AboutDoc.php');
                $view = new AboutDoc($this->model);
                break;

            case 'contact' Or 'login' Or 'register':
                include_once('./views/FormsDoc.php');
                include_once('./models/UserModel.php');
                $this->model = new UserModel();
                $this->getRequest();
                $view = new FormsDoc($this->model);
                
                break;
            }

            
                

        $view->show();
    }
}
?>