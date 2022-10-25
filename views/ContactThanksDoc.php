<?php 
include_once("./views/BasicDoc.php");
class ContactThanksDoc extends BasicDoc {

    protected function showBodyContent() {
        $genders = getGenders();
        $options = getOptions();
        $values = $this->model->getValues();
        $pronoun = $genders[$values['gender']];
        if($pronoun == 'Anders') {
            $pronoun = "";
        }
        echo(
            '<p class="body">
                Dankjewel ' . $pronoun . " " . ucfirst($values['name']) . '! <br> <br>

                Jouw e-mail adres is ' . $values["email"] . '. <br>
                Jouw telefoonnummer is ' . $values["tlf"] . '. <br>
                Jouw voorkeur is ' . $options[$values["radio"]] . '. <br> <br>
                
                ' . $values["text"] . '
            </p>
            '
        );
    }
}
?>