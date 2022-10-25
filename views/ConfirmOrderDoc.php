<?php 
include_once("./views/BasicDoc.php");
class ConfirmOrderDoc extends BasicDoc {

    protected function showBodyContent() {
        echo(
            '<p class="body">
                Bedankt voor je bestelling!
            </p>
            '
        );
    }
}

?>