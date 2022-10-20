<?php 
require_once('./views/BasicDoc.php');
class HomeDoc extends BasicDoc {

    protected function showBodyContent() {
        echo('
            Welcome to the website, dear traveler. <br>
            Here we will have some fun while also learning a thing or two. <br>
            See you around traveler!
        ');
    }
}
?>